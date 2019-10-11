<?php


namespace App\Http\Controllers;


use App\DB\DBConnection;
use Illuminate\Http\Request;

class UserSelectionController extends Controller
{
    public function __construct(DBConnection $connection)
    {
    }

    public function goUserRole(Request $request)
    {
        $name = $request->input('role') == 'admin' ? 'Admin' : 'User';
        $role = $request->input('role') == 'admin' ? 'admin' : 'user';

       return redirect('/home');
    }

    public function index()
    {
        return view('user-selection');
    }
}
