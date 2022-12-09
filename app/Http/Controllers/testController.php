<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect,Response;
 
use App\User;

class testController extends Controller
{
    public function testusers($id) {

        $where = array('id' => $id);
        $user  = User::where($where)->first();
 
        return Response::json($user);

        
    }
}
