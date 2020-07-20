<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class LoginLink extends Model{

    protected $fillable = [
        'email' 
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'token',
    ];

    protected function setTokenAttribute($token){
        $this->attributes['api_token'] = hash('sha256', $token);
    }

    protected function scopecheckHash($query,$token){
        return $query->where('token',hash('sha256', $token))->first();
    }

    function generateToken($email){
        $this->token = $token = Str::random(32);
        $this->email = $email;
        $this->save();

        return $token;
    }

    function user(){
        $this->belongsTo(User::class,'email','email');
    }

}