<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Storage;

class AuthLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function Login(Request $request)
    {
        $payload = $this->validate($request, [
            'pass_id' => 'required|numeric|digits:11',
            'password' => 'required|string',
        ]);

        try{
            $user = User::where('pass_id', $payload['pass_id'])->first();

            if(is_null($user)){
                return response()->json(['error' => true, 'message' => 'Credentials not correct'], 400);
            }
            if(!Hash::check($payload['password'], $user->password)){
                return response()->json(['error' => true, 'message' => 'Credentials not correct'], 400);
            }

            if($user->is_verified == false){

                return response()->json(['error' => true, 'message' => 'Redirect to First time Change your Password'], 400);

            } 


        }catch (\Exception $exception)
        {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        $data['user'] =  $user;
        $data['token'] =  $user->createToken('EMS')->accessToken;
        return response()->json(['error' => false, 'message' => 'login successful', 'data' => $data], 200);
    }


    public function firstTimePassword(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|string|min:6',
        ]);

        //Create First Time Password
        $firstTimePassword = User::where('id', $id)->updateOrCreate([
            'password' => Hash::make($request['password']),
            'is_verified' => True,
        ]);

      if ($firstTimePassword) {
        return response()->json(['error' => false, 'status_code' => 200, 'message' => 'Your Password is Created Successfully', 'data' => $firstTimePassword ], 200);
      }else{
        return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
      }
    }



    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ], 201);
    }

}
