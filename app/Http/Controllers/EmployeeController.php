<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Leave;
use App\Models\Salary;
use Illuminate\Pagination;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function show()
    {
        try{

        $users = User::where('role', 'employee')
                    ->whereDate('created_at', Carbon::now()->toDateString())
                    ->paginate(10)
                    ->get();

        }catch (\Exception $exception)
        {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'Employee Listed successful', 'data' => $users], 200);
    }




    public function deleteAllEmployee($id)
    {
        try {
       
        User::where('pass_id', '=', $id)->delete();

    }catch (\Exception $exception)
    {
        return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
    }
    return response()->json(['error' => false, 'message' => 'Deleted successful'], 200);


        
    }


    public function assignLeave(Request $request)
    {
        try {

            $leaves = Leave::create([
                'reason' => $request->reason,
                'status' => false,
            ]);

        }catch (\Exception $exception)
        {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'Leave Requested Successful'], 200);


    }


    public function grantLeave(Request $request, $id)
    {
        try {

            Leave::where('pass_id', $id)->update([
                'status' => true,
            ]);

        }catch (\Exception $exception)
        {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'Leave granted Successful'], 200);


    }


    public function getEmployee(Request $request, $id)
    {
        try {

            $sa = Salary::find($id);
            $users = User::where('role', 'employee')
                            ->where('pass_id', $sa)
                            ->get();

        }catch (\Exception $exception)
        {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'View  Employee with Salary', 'data' => $users], 200);


    }


    

    
}
