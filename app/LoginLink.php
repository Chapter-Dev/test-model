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

    protected function checkHash($token){
        if($this->api_token == hash('sha256', $token)){
            return true;
        }

        return false;
    }

    function generateToken(){
        $this->token = Str::random(32);
    }
}