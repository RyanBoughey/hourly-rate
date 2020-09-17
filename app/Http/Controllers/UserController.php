<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\currency;
use App\Models\conversion_rate;
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
    public function show(User $user)
    {
        //
    }
}
