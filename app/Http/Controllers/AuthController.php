<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Illuminate\Support\Str;
class AuthController extends Controller
{
    public $successStatus = 200;

    public function register(Request $request) {
       $res = ['error'=>'200','message' => 'Fallo al crear el user'];
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = new User();
        $user->name= $input['name'];
        $user->email= $input['email'];
        $user->password= $input['password'];
        $user->token =  Str::random(255);
        try{
           $user->save();
           $res['error']= 200;
           $res['message']= 'Usuario creado correcto';
        }catch(Exception $ex){
            $res['message'] = $ex->getMessage();
        }
        return response()->json($res);
    }

    public function getUser() {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
}
