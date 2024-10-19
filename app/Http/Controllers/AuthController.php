<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Login
    public function  login(Request $request)
    {
        if($request->isMethod('post'))
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if(Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ])){

                return to_route('dashboard');
                
            } else {
                return to_route('login')->with('error', 'Invalid Login Details.');
            }
        }

        return view('auth.login');

    }


    // Register
    public function  register(Request $request)
    {
        if($request->isMethod('post'))
        {
            if($request->image != "")
            {
                $rules['image'] = 'image';
            }

            $validator = Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                return redirect()->route('auth.register')->withInput()->withErrors($validator);
            }

            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'phone' => 'required',
                'password' => 'required',
            ]);

            // User::create([
            //     'name' => $request->name,
            //     'email' => $request->email,
            //     'phone' => $request->phone,
            //     'password' => bcrypt($request->password)
            // ]);

            $user = new User(); // this is model name
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = bcrypt($request->password);
            
            if($request->image != "")
            {
                // here we will store image
                $image = $request->image;
                $ext = $image->getClientOriginalExtension();
                $imageName = time().'.'.$ext; // Unique image name

                // Save image to gallery directory
                $image->move(public_path('uploads/gallery'), $imageName); 
                // Save image name in database
                
                $user->image = $imageName;
            }
            $user->save();


            if(Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ])){

                return to_route('dashboard')->with('success' ,'Data Added Successfully');

            } else {
                return to_route('register');
            }
        }
        return view('auth.register');

    }


    // Dashboard
    public function  dashboard()
    {
        // echo "<h1>Dashboard</h1>";
        return view('dashboard');

    }


    // Profile
    public function  Profile(Request $request)
    {
        if($request->isMethod('post'))
        {
            if($request->validate([
                'name' => 'required',
                'phone' => 'required'
            ]));

            $id = Auth::user()->id;
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->phone = $request->phone;

            if($request->image != "")
            {
                // Delete old image
                File::delete(public_path('uploads/gallery/'.$user->image));
                // here we will store image
                $image = $request->image;
                $ext = $image->getClientOriginalExtension();
                $imageName = time().'.'.$ext; // Unique image name

                // Save image to gallery directory
                $image->move(public_path('uploads/gallery'), $imageName); 
                // Save image name in database
                $user->image = $imageName;
            }


            $user->save(); 

            return redirect()->route('profile')->with('success' ,'Profile Updated Successfully');
             
         
        }
        return view('profile');

    }


    // Logout
    public function  Logout()
    {
        Session::flush();
        Auth::logout();
        return to_route('login')->with('success', 'Logged Out Successfully');

    }











}
