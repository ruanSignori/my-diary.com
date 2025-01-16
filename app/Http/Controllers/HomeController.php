<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class HomeController extends Controller
{
    public static function index()
    {
        return Inertia::render('Home');
    }
}
