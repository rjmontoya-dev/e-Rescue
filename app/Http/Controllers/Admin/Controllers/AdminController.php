<?php

namespace App\Http\Controllers\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminWelcome(){
        return inertia('Admin/Index');
    }
}
