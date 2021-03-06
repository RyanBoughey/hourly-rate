<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Currency;
use App\libraries\CurrencyConversion;
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
        $currencies = Currency::all();
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
        $validatedData = $request->validate(['currency_id' => 'required|exists:currencies,id',]);
        $to_currency = Currency::find($validatedData['currency_id']);
        if ($to_currency->id == $user->currency->id) {
            // it's the same currency, do nothing
            $user->converted_rate = $user->hourly_rate;
        } else {
            $conversion = new CurrencyConversion($to_currency->id, $user->currency->id);
            $user->converted_rate = $conversion->convertRate($user->hourly_rate);
            // $user->converted_rate = $user->hourly_rate * $conversion_rate;
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
