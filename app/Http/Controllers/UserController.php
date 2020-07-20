<?php
namespace App\Http\Controllers;

use App\User;
use App\LoginLink;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;
    protected $loginLink;

    function __construct(
        User $user,LoginLink $link
    ){
        $this->user = $user;
        $this->loginLink = $link;
    }

    function login(){
        $user = $this->user->findByEmail(request()->email);

        if($user){
            $token = $this->loginLink->generateToken($user->email);

            return response()->json([
                'token' => $token
            ],200);
        }

        return response()->json([
            'message' => 'User does not exist'
        ],422);
    }

    function allowLogin($hash){
        $link = $this->loginLink->with('user')->checkHash($hash);

        if($link->user){
            $user = $link->user;
            $user->generateApiToken();

            $link->delete();

            return response()->json([
                'user' => $user
            ],200);
        }

        return response()->json([
            'message' => 'Link Expired or the user does not exist'
        ],422);
        
    }

    function register(){

    }

    function update(User $user){
        if($user){
            $user->update($request->all());

            return response()->json([
                'user' => $user,
                'message' => 'User updated successfully'
            ],200);    
        }
        return response()->json([
            'message' => 'User does not exist'
        ],403);
    }
}
