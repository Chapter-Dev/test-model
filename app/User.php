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
        'first_name','last_name','dob','gender', 'email'
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

    protected function checkHash($token){
        if($this->api_token == hash('sha256', $token)){
            return true;
        }

        return false;
    }

    function generateApiToken(){
        $this->api_token = Str::random(32);
    }
}
