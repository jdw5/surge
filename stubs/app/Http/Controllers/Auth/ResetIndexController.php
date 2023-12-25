<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResetIndexController extends Controller
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
        return Inertia::modal('Auth/Reset')
            ->with([
                'email' => $request->email,
                'token' => $request->token,
            ])
            ->baseRoute('home');
    }
}
