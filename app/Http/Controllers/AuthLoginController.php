<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Http\Resources\NewUserResource;
use Storage;
use File;
use Image;

class AuthLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function validateNewToken(Request $request)
    {
        return new UserResource($request->user());
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



    public function uploadUserImage(Request $request)
    {

        $validated = $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        try{

            if ($request->hasFile('file')) {
                $currentUser = \Auth::user();
                $avatar = $request->file('file');
                $filename = 'avatar.'.$avatar->getClientOriginalExtension();
                $save_path = storage_path().'/users/id/'.$currentUser->id.'/uploads/images/profileImage/';
                $path = $save_path.$filename;
                $public_path = '/images/profile/'.$currentUser->id.'/profileImage/'.$filename;
    
                // Make the user a folder and set permissions
                File::makeDirectory($save_path, $mode = 0755, true, true);
    
                // Save the file to the server
                Image::make($avatar)->resize(300, 300)->save($save_path.$filename);
    
                // Save the public image path
                $currentUser->user->image = $public_path;
                $currentUser->user->save();
            }
    

           
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'status_code' => 200, 'message' => "Imagge updated successful", 'data' => $path ], 200);


    }



    public function profile($id)
    {
        try{
            $user = User::where('pass_id', $id)->first();
            if(is_null($user))
            {
                return response()->json(['error' => true, 'message' => 'User Not Found'], 401);
            }
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'Profile Valid', 'data' => $user], 200);

    }


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ], 201);
    }

}
