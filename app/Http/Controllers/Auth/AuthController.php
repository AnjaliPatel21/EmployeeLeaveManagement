<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
  
class AuthController extends Controller
{
    /**
     * login
     *
     * @return response()
     */
    public function index()
    {
        if(Auth::check()){
            return redirect()->intended('dashboard');
        }
        return view('auth.login');
    }  
      
    /**
     * registraition
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
    }
      
    /**
     * check login credencial 
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::where(['email'=>$request->email])->first();
        if($user->status == "0" && $user->is_admin != "1"){
            return redirect("login-form")->with('error','You user request not approve yet, contact admin');
        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            
            return redirect()->intended('dashboard')
                        ->with('success','You have Successfully logged in');
        }
  
        return redirect("login-form")->with('error','You have entered invalid credentials');
    }
      
    /**
     * save user data
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($request->hasFile('image')) {
            $request->image->store('images', 'public');
        }

        $user = new User([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            'status' => '0',
            "image" => $request->image->hashName()
        ]);
        $user->save();
        
        return redirect("login-form")->with('success','Great! You have Successfully Registered');
    }
    
    /**
     * dashboad
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
            if(Auth::user()->is_admin){
                return view('admin-dashboard');
            }else{
                return view('dashboard');
            }
        }
  
        return redirect("index")->with('error','You do not have access');
    }
    
    /**
     * Logout
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login-form');
    }
}