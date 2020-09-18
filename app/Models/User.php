<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public static $validation = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users|max:255',
        'hourly_rate' => 'required|numeric|min:0',
        'currency_id' => 'required|numeric|exists:currencies,id'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'hourly_rate', 'currency_id'
    ];

    public function currency()
    {
        return $this->belongsTo('App\Models\currency');
    }
}
