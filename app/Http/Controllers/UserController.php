<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function showRegisterForm(){
      return view('fontend.register');
    }

    public function login(Request $request){

      $username=$request->input('username');
      $password=$request->input('password');
      $users = DB::select(' select * from users where username = ? and password = ?',[$username, $password]);
      return view('welcome')
          ->with('users', $users);
    }

    public function storeUser(Request $request){
      //dd($request->all());

      $messages = [];
      $validator = Validator::make($request->all(), [
            'name'     => 'required|max:255',
            'email'    => 'required|email',
            'username' => 'required|max:255',
            'password' => 'required|numeric|min:6|confirmed',

        ], $messages);

        if ($validator->fails()) {
            return redirect('register')
                    ->withErrors($validator)
                    ->withInput();
        } else {
          // Lưu thông tin vào database, phần này sẽ giới thiệu ở bài về database

           $name = $request->input('name');
          $email = $request->input('email');
          $username = $request->input('username');
          $password = $request->input('password');

          DB::insert('insert into users (name, email, username ,password) values (?, ?, ?, ?)', [$name, $email, $username, $password]);

          return view('fontend.register')
          ->with('message', 'Register Success.');
        }
    }

    public function myAccount()
    {
      $roles=DB::table('user_roles')->where('user_id','=',auth()->user()->id)->join('roles','user_roles.role_id','=','roles.id')->select('name')->get();
      
      return view('fontend.myaccount')->with('roles',$roles);
    }

    

}