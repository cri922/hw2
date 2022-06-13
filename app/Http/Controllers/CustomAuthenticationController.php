<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Session;

class CustomAuthenticationController extends BaseController
{
    public function loginForm(){
        if(Session::get('user_id')){
            return redirect(route('home'));
        }
        $errors = Session::get('errors');
        Session::forget('errors');
        return view('login')->with('errors',$errors);
    }
    
    public function doLogin(){
        if(Session::get('user_id')){
            return redirect(route('home'));
        }

        $emailErr = $passErr = "";
        $email = $pass = ""; 
        $count = 0;

        if(empty(request("f-email"))){
            $emailErr = "Email is required!";
            $count++;
        }else{
            if(!filter_var(request('f-email'), FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format!";
                $count++;
            }else{
                $email = request("f-email");
            }
        }

        if(empty(request("f-pass"))){
            $passErr = "Password is required!";
            $count++;
        }else{
            $pass = request("f-pass"); 
        }

        if($count==0){
            if($user=User::where('email',$email)->first()){
                if(password_verify($pass,$user->password)){
                    Session::put('user_id',$user->id);
                    Session::put('username',$user->username);
                    return redirect(route('home'));
                }else{
                    $passErr = "Password wrong!";
                }
            }else{
                $emailErr = "There is no user registered with that email!";
            }
        }
        Session::put('errors',[
            'emailErr' => $emailErr,
            'passErr' => $passErr
        ]);
        return redirect(route('login_form'))->withInput();
    }


    public function signupForm(){
        if(Session::get('user_id')){
            return redirect(route('home'));
        }
        $errors = Session::get('errors');
        Session::forget('errors');
        return view('signup')->with('errors',$errors);
    }

    public function doSignup(){

        if(Session::get('user_id')){
            return redirect(route('home'));
        }

        $firstNameErr = $lastNameErr = $usernameErr = $emailErr = $passErr = $repassErr = "";
        $firstName = $lastName = $username = $email = $pass = $hashPass = $repass = ""; 
        $count = 0;

        if(empty(request("f-fname"))){
            $firstNameErr = "First name is required!";
            $count++;
        }else{
            $firstName = request("f-fname");
        }

        if(empty(request("f-lname"))){
            $lastNameErr = "Last name is required!";
            $count++;
        }else{
            $lastName = request("f-lname");
        }

        if(empty(request("f-nick"))){
            $usernameErr = "Username is required!";
            $count++;
        }else{
            if(!preg_match("/^[A-Za-z][A-Za-z0-9_]{7,15}$/",$_POST["f-nick"])){
                $usernameErr = "Length(8-16).Letters,numbers and underscore!";
                $count++;
            }else{
                $username = request("f-nick");
                if(User::where('username',$username)->first()){
                    $usernameErr = "Username not available!";
                    $count++;
                }
            }
        }

        if(empty(request("f-email"))){
            $emailErr = "Email is required!";
            $count++;
        }else{
            if(!filter_var(request('f-email'), FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format!";
                $count++;
            }else{
                $email = request("f-email");
                if (User::where('email',$email)->first()) {
                    $emailErr = "Email already used!";
                    $count++;
                }
            }
        }

        if(empty(request("f-pass"))){
            $passErr = "Password is required!";
            $count++;
        }else{
            if(strlen(request("f-pass"))<8){
                $passErr = "Password must be a minimum of 8 characters!";
                $count++;
            }else{
                $pass = request("f-pass");
                $hashPass = password_hash($pass, PASSWORD_BCRYPT);
            }
        }

        if(empty(request("f-repass")) || request("f-pass") != request("f-repass")){
            $repassErr = "Password don't match!";
            $count++;
        }

        if($count==0){
            $user = new User;
            $user->firstName =$firstName;
            $user->lastName = $lastName; 
            $user->username = $username; 
            $user->email = $email; 
            $user->password = $hashPass;
            $user->save(); 
            Session::put('user_id',$user->id);
            Session::put('username',$user->username);
            return redirect(route('home'));
        }else{
            Session::put('errors',[
                'firstNameErr' => $firstNameErr,
                'lastNameErr' => $lastNameErr,
                'usernameErr' => $usernameErr,
                'emailErr' => $emailErr,
                'passErr' => $passErr,
                'repassErr' => $repassErr
            ]);
            return redirect(route('signup_form'))->withInput();
        }
    }

    public function logout(){
        Session::flush();
        return redirect(route('index'));
    }
}
