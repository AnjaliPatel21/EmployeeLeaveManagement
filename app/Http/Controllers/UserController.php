<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
    * edit Profile
    *
    * @return response()
    */
   public function edit($id)
   {
       $user = User::findOrFail($id);
       return view('profile', compact('user'));
   }
     
   /**
   * Update DB for Profile
   *
   * @return response()
   */
    public function update(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        
        $imageName = time().'.'.$request->image->extension();  
        $request->image->storeAs('images', $imageName);

        $data = $request->all();
        $this->create($data);
        
        return redirect("dashboard")->with('success','Profile id updated');
    }

    /**
     * employee listing who are inactive after registrations
     */
    public function empList(){

        $employees = User::where('status', '0')->latest()->paginate(10);
        return view('emplist', compact('employees'));
    }

    /**
     * approve registration 
     */
    public function regApprove($id) {
        $user = User::findOrFail($id);
        $user->status='1'; //Approved
        $user->save();

        return \Redirect::back()->with('success','Registration Approved Successfully !');
    }
}
