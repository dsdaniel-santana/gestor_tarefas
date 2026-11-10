<?php

namespace App\Http\Controllers;

//use App\Model\UserModel;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Main extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Gestor de Tarefas'
        ];

        return view ('main', $data);
    }


    //========================================
    //login
    //========================================
    public function login()
    {
        $data = [
            'title' => 'Login'
        ];

        return view('login_frm', $data);
    }

    public function login_submit(Request $resquest)
    {
        //form validation
        $resquest->validate([        
            'text_username' => 'required|min:3',
            'text_password' => 'required|min:3',
        ], [
            'text_username.required' => 'O campo é de preenchimento obrigatorio',
            'text_username.min' => 'O campo deve ter no minímo 3 caracteres',
            'text_password.required' => 'O campo é de preenchimento obrigatorio',
            'text_password.min' => 'O campo deve ter no minímo 3 caracteres',
        ]);

        //get form data
        $username = $resquest->input('text_username');
        $password = $resquest->input('text_password');

        //check if exists
        $model = new UserModel();
        $user = $model->where('username', '=', $username)
        ->whereNull('deleted_at')
        ->first();

        if($user){
            //check if password is correct
            if(password_verify($password, $user->password)){
            $session_data = [
                'id' => $user->id,
                'username' => $user->username
            ];
            session()->put($session_data);
            return redirect()->route('index');

            }
        }

        //invalid login
        return redirect()
            ->route('login')
            ->withInput()
            ->with('login_error', 'Login Inválido');
    }

    //========================================
    //logout
    //========================================
    public function logout()
    {
        session()->forget('username');
        return redirect()->route('login');
    }



}
