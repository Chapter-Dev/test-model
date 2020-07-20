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

    function login(Request $request){
        $user = $this->user->with('link')->findByEmail($request->email)->first();

        if($user){

            //Check if previous request exists
            if($user->link){
                return response()->json([
                    'message' => 'Request has already been sent once'
                ],403);
            }

            $token = $this->loginLink->generateToken($user->email);

            if($token)
                $user->resetApiToken();

            return response()->json([
                'message' => 'Token has been generated',
                'token' => $token
            ],200);
        }

        return response()->json([
            'message' => 'User does not exist.'
        ],422);
    }
    /**
     * Login using token and clearance
     * 
     * @param string $hash
     */
    function allowLogin($hash){

        $link = $this->loginLink->checkHash($hash)->with('user')->first();

        if($link && $link->user){

            $link->user->generateApiToken();

            $user = $link->user;

            $link->delete();

            return response()->json([
                'user' => $user,
                'token' => $user->getApiToken()
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

    function update(Request $request,User $user){
        if($user){
            $user->update($request->all());

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
