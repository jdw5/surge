<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RegisterIndexController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::modal('Auth/Register')
            ->baseRoute('home');
    }
}
