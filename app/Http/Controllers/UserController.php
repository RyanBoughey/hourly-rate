<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\currency;
use App\Models\conversion_rate;
use App\libraries\LiveConversionRate;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currencies = currency::all();
        return view('users.create', ['currencies' => $currencies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(User::$validation);
        $new_user = new User;
        $new_user->fill($validatedData);
        $new_user->save();
        return redirect('/thank_you');
    }

    public function thankYou()
    {
        return view('users.thank_you');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Request $request)
    {
        $validatedData = $request->validate([
            'currency_id' => 'required|exists:currencies,id',
            'live_rate' => 'nullable|boolean',
        ]);
        $to_currency = currency::find($validatedData['currency_id']);
        if ($to_currency->id == $user->currency->id) {
            // it's the same currency, do nothing
            $user->converted_rate = $user->hourly_rate;
        } else {
            if (isset($validatedData['live_rate']) && $validatedData['live_rate']) {
                $conversion = new LiveConversionRate($to_currency->name, $user->currency->name);
                $conversion_rate = $conversion->convertRate($user->hourly_rate);
            } else {
                $conversion = conversion_rate::where([
                    ['from_currency_id', $user->currency->id],
                    ['to_currency_id', $to_currency->id]
                ])->first();
                $conversion_rate = $conversion->conversion_rate;
            }

            $user->converted_rate = $user->hourly_rate * $conversion_rate;
        }

        $return = [
            'name' => $user->name,
            'email' => $user->email,
            'hourly_rate' => $user->converted_rate,
            'currency' => $to_currency->name,
        ];
        return response()->json($user);
    }
}
