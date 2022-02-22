<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     *  Apply leave
     *
     * @return response()
     */
    public function applyLeave()
    {
        return view('leave.leaveform');
    }

    /**
     * Save Leave
     */
    public function postLeave(Request $request)
    {
        $leave = new Leave;
        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required|after:from_date',
            'reason' => 'required',
        ]);

        $leave->user_id = Auth::id();
        $leave->from_date = $request->from_date;
        $leave->to_date = $request->to_date;
        $leave->reason = $request->reason;
        $leave->aprove_at = date('Y-m-d H:i:s');

        $leave->save();

        return redirect("dashboard")->with('success','Leave Applied Successfully');
    }

    public function allLeave(){

        $leaves = Leave::where('status', '0')->latest()->paginate(10);

        return view('leave.leavelist', compact('leaves'));
    }

    /**
     * Apprve leave
     */
    public function leaveApprove($id){
        $user = User::findOrFail($id);
        $leave = Leave::findOrFail($id);
        $leave->status='1'; //Approved
        $leave->save();
        $details = [
            'status' => 'Your Leave request is approved form ' . $leave->from_date . ' to ' . $leave->to_date
        ];
       
        \Mail::to($user->email)->send(new \App\Mail\SendLeaveStatus($details));
        
        return \Redirect::back()->with('success','Leave Approve Successfully !');
     }

     /**
     * reject leave
     */
     public function leaveDecline($id){

        $user = User::findOrFail($id);
        $leave = Leave::findOrFail($id);
        $leave->status='2'; //Declined
        $leave->save();
        $details = [
            'status' => 'Your Leave request is rejected form ' . $leave->from_date . ' to ' . $leave->to_date
        ];
       
        \Mail::to($user->email)->send(new \App\Mail\SendLeaveStatus($details));
        return \Redirect::back()->with('success','Leave Rejected Successfully !');
     }

}
