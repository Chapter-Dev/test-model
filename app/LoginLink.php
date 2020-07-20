<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class LoginLink extends Model{

    protected $primaryKey = 'email';

    public $incrementing = false;

    public $timestamps = false;

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
        $this->attributes['token'] = hash('sha256', $token);
    }

    protected function scopecheckHash($query,$token){
        return $query->where('token',$token);
    }

    function generateToken($email){
        $this->token = $token = Str::random(32);
        $this->email = $email;
        $this->created_at = Carbon::now();
        $this->save();

        return $this->token;
    }

    function user(){
        return $this->belongsTo(User::class,'email','email');
    }

}