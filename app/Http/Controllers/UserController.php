<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $request;

    function __construct(Request $request){
        $this->request = $request;
    }

    function login(User $user){

    }

    function register(User $user){

    }

    function update(User $user){

    }
}
