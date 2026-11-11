<?php

namespace App\Http\Controllers;

//use App\Model\UserModel;

use App\Models\TaskModel;
use App\Models\UserModel;
use Illuminate\Http\Request;


class Main extends Controller
{
    
    //========================================
    //main page
    //========================================
    public function index()
    {
        $data = [
            'title' => 'Gestor de Tarefas',
            'datatables' => true,
            'tasks' => $this->_get_tasks()
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

    //========================================
    //new taks
    //========================================

    public function new_task()
    {
        $data = [
            'title' => 'Nova Tarefa'
        ];

        return view('new_task_frm', $data);
    }

    public function new_task_submit(Request $resquest)
    {
        //form validation
        $resquest->validate([        
            'text_task_name' => 'required|min:3|max:200',
            'text_task_description' => 'required|min:3|max:1000',
        ], [
            'text_task_name.required' => 'O campo é de preenchimento obrigatorio',
            'text_task_name.min' => 'O campo deve ter no minímo :min caracteres',
            'text_task_name.max' => 'O campo deve ter no máximo :max caracteres',
            
            'text_task_description.required' => 'O campo é de preenchimento obrigatorio',
            'text_task_description.min' => 'O campo deve ter no minímo :min caracteres',
            'text_task_description.max' => 'O campo deve ter no máximo :max caracteres',
        ]);

        // get form data
        $task_name = $resquest->input('text_task_name');
        $task_description = $resquest->input('text_task_description');

        // check if there is already another task with the same name for the same user
        $model = new TaskModel();
        $task = $model
            ->where('id_user', '=', session('id'))
            ->where('task_name', '=', $task_name)
            ->whereNull('deleted_at')
            ->first();
        if($task)
        {
            return redirect()->route('new_task')->with('task_error', 'Já existe uma tarefa com esse mesmo nome');
        }

        // insert new task
        $model->id_user = session('id');
        $model->task_name = $task_name;
        $model->task_description = $task_description;
        $model->task_status = 'new';
        $model->created_at = date('Y-m-d H:i:s');
        $model->save();

        return redirect()->route('index');
    }


    //========================================
    //private methods
    //========================================

    private function _get_tasks()
    {
        $model = new TaskModel();
        return $model
        ->where('id_user', '=', session()->get('id'))
        ->whereNull('deleted_at')
        ->get();
    }



}
