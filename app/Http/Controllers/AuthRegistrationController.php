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


class AuthRegistrationController extends Controller
{


    public function employeeRegister(Request $request)
    {
        $validated = $this->validate($request, [
            'pass_id' => 'required|numeric|digits:11|unique:users',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string',
            'department' => 'required|string',
        ]);

        try{

             $user = User::where('pass_id', $validated['pass_id'])->first();

             if($user)
             {
                 $message = 'Account Exist';
                 $data = null;
                 return response()->json(['error' => false, 'is_verified' => true, 'status_code' => 200, 'message' => $message], 200);
             }

             if(is_null($user))
                {
 
                   $userIDGen = mt_rand(100000000, 999999999);
                   $currentTime = Carbon::now()->addDay();

                        $payload = User::create([
                            'pass_id' => $userIDGen,
                            'first_name' => $request->first_name,
                            'last_name' => $request->last_name,
                            'email' => $request->email,
                            'department' => $request->department,
                            'address' => $request->address,
                            'age' => $request->age,
                            'role' => "employee",
                        ]);

                    /**Take note of this: Your user authentication access token is generated here **/
                    $data['user'] =  $payload;
                    $data['token'] =  $payload->createToken('EMS')->accessToken;
        
                } 

        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'status_code' => 200, 'message' => "Employee data successful", 'data' => $data ], 200);

    }




    public function adminRegister(Request $request)
    {
        $validated = $this->validate($request, [
            'pass_id' => 'required|numeric|digits:11|unique:users',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string',
        ]);

        try{

            $user = User::where('pass_id', $validated['pass_id'])
            ->first();

             if($user)
             {
                 $message = 'Account Exist';
                 $data = null;
                 return response()->json(['error' => false, 'is_verified' => true, 'status_code' => 200, 'message' => $message], 200);
             }

               if(is_null($user))
                {

                   $userIDGen = mt_rand(100000000, 999999999);
                   $currentTime = Carbon::now()->addDay();

                        $payload = User::create([
                            'pass_id' => $userIDGen,
                            'first_name' => $request->first_name,
                            'last_name' => $request->last_name,
                            'email' => $request->email,
                            'role' => "admin",
                        ]);

                    /**Take note of this: Your user authentication access token is generated here **/
                    $data['user'] =  $payload;
                    $data['token'] =  $payload->createToken('EMS')->accessToken;
        

                } 

        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'status_code' => 200, 'message' => "Admin data successful", 'data' => $data ], 200);

    }


   



}


