<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $files_count = File::get()->count();
        $total_size = File::get()->max('file_size');
        return view('dashboard',compact('files_count','total_size'));
    }
}
