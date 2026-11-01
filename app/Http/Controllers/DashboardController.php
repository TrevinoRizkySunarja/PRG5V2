<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('dashboard', [
            'products' => $user->products()->latest()->paginate(10),
            'loginDays' => $user->loginDays()->count(),
        ]);
    }
}
