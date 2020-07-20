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
        
        $user = $this->user->findByEmail(request()->email)->first();

        if($user){
            $token = $this->loginLink->generateToken($user->email);

            return response()->json([
                'token' => $token
            ],200);
        }

        return response()->json([
            'message' => 'User does not exist.'
        ],422);
    }

    function allowLogin($hash){
        $link = $this->loginLink->with('user')->checkHash($hash)->first();

        if($link && $link->user){

            $link->user->generateApiToken();

            $user = $link->user;

            $link->delete();

            return response()->json([
                'user' => $user
            ],200);
        }

        return response()->json([
            'message' => 'Link Expired or the user does not exist.'
        ],422);
        
    }

    function create(Request $request){
        $user = $this->user->create(request()->all());
        if($user){
            $token = $this->loginLink->generateToken($user->email);

            return response()->json([
                'token' => $token
            ],200);
        }

        return response()->json([
            'message' => 'Some error occured please try again.'
        ],422);
    }

    function update(User $user){
        if($user){
            $user->update(request()->all());

            return response()->json([
                'user' => $user,
                'message' => 'User updated successfully.'
            ],200);    
        }
        return response()->json([
            'message' => 'User does not exist.'
        ],403);
    }

    function details(User $user){
        if($user){
            return response()->json([
                'user' => $user,
                'message' => 'User details obtained successfully.'
            ],200);    
        }
        return response()->json([
            'message' => 'User does not exist.'
        ],403);
    }
}
