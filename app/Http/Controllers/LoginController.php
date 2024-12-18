<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Users;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function add()
    {
        return view('pages.register');
    }

    public function forgot()
    {
        return view('pages.forgot-password');
    }

    public function validate(Request $request)
    {
        $inputs = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        try
        {
            $user = Users::authenticate($inputs);
            if(!$user)
            {
                return redirect('/')->with('message', $this->warningMessage('Incorrect credentials.'));
            }

            $userDetails = new \stdClass;
            $userDetails->id = md5($user->usr_id);
            $userDetails->firstname = $user->usr_fname;
            $userDetails->lastname = $user->usr_lname;
            $userDetails->email = $user->usr_email;
            $userDetails->role = [
                'id' => md5($user->rl_id),
                'detail' => $user->role->rl_detail,
            ];
            $userDetails->image = $user->usr_image;
            $userDetails->menus = $user->menus($user->rl_id);
            session()->put('user', $userDetails);

            return redirect()->route('dashboard');
        }
        catch(Exception $e)
        {
            return redirect('/')->with('message', $this->dangerMessage());
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}
