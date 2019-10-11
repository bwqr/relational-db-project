<?php


namespace App\Http\Controllers;


use App\DB\DBConnection;
use Illuminate\Http\Request;

class DBInstallController
{
    public function installDB(Request $request)
    {
        DBConnection::installDB($request->input('user'), $request->input('pass'));

        return redirect('/');
    }

    public function index()
    {
        return view('create-db');
    }
}
