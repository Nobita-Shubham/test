<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Login;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $cpassword = $request->input('cpassword');
        $count_email = DB::table('logins')->where('email', $email)->count();
        if($count_email == 0)
        {
            if($password === $cpassword)
            {
                $user = new Login;
                $user->name = $name;
                $user->email = $email;
                $user->password = md5($password);
                $user->cpassword = md5($cpassword);
                $user->save();
                $request->session()->flash('msg', "you have sign up succesfully!!");
                return view('login');
            }else
            {
                $request->session()->flash('msg', "please confirm your password!!");
                return redirect('/');
            }
        }else
        {
            $request->session()->flash('msg', "please use another email!!");
            return redirect('/');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Login  $login
     * @return \Illuminate\Http\Response
     */
    public function show(Login $login)
    {
        return view('form');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Login  $login
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id = null)
    {
        // return ['name'=>'shubham',"email"=>"shubham@gmail.com"];
        if($id != "")
        {
            return Login::find($id);
        }else{
            return Login::all();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Login  $login
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request, Login $login)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $db_email = DB::table('logins')->where('email', $email);
        $db_password = DB::table('logins')->where('email', $email)->value('password');
        $hash_password = md5($password);
        if($db_email)
        {
            if($db_password === $hash_password)
            {
                $request->session()->put('user',$email);
                return view('main');
            }else{
                $request->session()->flash('msg2', "please check your password");
                return redirect('/login');
            }
        }else
        {
            $request->session()->flash('msg2', "please check your email address");
            return redirect('/login');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Login  $login
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $new = new Login;
        $new->name = $request->name;
        $new->email = $request->email;
        $new->password = $request->password;
        $new->cpassword = $request->cpassword;
        $new->save();
    }

    public function update(Request $request, $id)
    {
        $new = Login::find($id);
        $new->name = $request->name;
        $new->email = $request->email;
        $new->password = $request->password;
        $new->cpassword = $request->cpassword;
        $new->save();
    }

    public function search($name)
    {
        return Login::where('name', 'like', "%".$name."%")->get();
    }

    public function delete($id)
    {
        return Login::find($id)->delete();
    }
}
