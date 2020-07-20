<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Support\Str;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use UsesUuid;
    use Authenticatable, Authorizable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['uuid'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid','first_name','last_name','dob','gender', 'email'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'api_token',
    ];

    protected function setApiTokenAttribute($token){
        $this->attributes['api_token'] = hash('sha256', $token);
    }

    protected function scopecheckApiToken($query,$token){
        return $query->where('token',hash('sha256', $token));
    }

    function generateApiToken(){
        $this->api_token = Str::random(32);
        $this->save();
    }

    function resetApiToken(){
        $this->api_token = null;
        $this->save();
    }

    function getApiToken(){
        return $this->api_token;
    }

    function scopefindByEmail($query,$email){
        return $query->where('email',$email);
    }

    function link(){
        return $this->hasOne(LoginLink::class,'email','email');
    }
}
