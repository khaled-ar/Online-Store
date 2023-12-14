<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    // Actions
    public function index() {
        // return response : view, josn, redirect, file
        return view('dashboard.index');
    }
}
