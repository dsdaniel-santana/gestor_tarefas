<?php

namespace App\Http\Controllers;

use App\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Main extends Controller
{
    public function index()
    {
        return view('main');
    }

    public function users()
    {
        // get users with raw sql
        // $users = DB::select('SELECT * FROM users');
        // dd($users);

        // Using Eloquent ORM - Using Model
        $model = new UserModel ();
        $users = $model->all();

        dd($users);
    }

    public function view()
    {
        $data = [
            'title' => 'Título da página'
        ];

        return view('home', $data);
    }

}
