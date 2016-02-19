<?php

namespace App\Http\Controllers;

use App\Backup;
use DateTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(){
        return view('admin/index', ['sidebar' => '1']);
    }

    public function getFileList(){
        return Backup::getFileList();
    }

    public function backup(){
        return Backup::backup();
    }

}
