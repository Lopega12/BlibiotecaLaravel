<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Illuminate\Support\Str;

/**
 * Class AuthController
 * @package App\Http\Controllers
 * Clase personalizada para crear un usuario a traves de la api
 */
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
        $api_token = Str::random(8);
        $user->api_token =  hash('sha256',$api_token);
        try{
           $user->save();
           $res['error']= 200;
           $res['message']= 'Usuario creado correcto: '.$api_token;
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
