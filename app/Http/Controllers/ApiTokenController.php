<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Psy\Util\Str;

class ApiTokenController extends Controller
{
    public function update(Request $request){
        $token = Str::random(255);
        $request->user()->forceFill([
           'token' => hash('sha256',$token),
        ])->save();
        return ['token' => $token];
    }
}
