<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginIndexController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }
    
    public function __invoke()
    {
        return Inertia::modal('Auth/Login')
            ->baseRoute('home.index');
    }
}
