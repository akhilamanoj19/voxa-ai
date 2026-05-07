<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Chat;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalChats = \App\Models\Conversation::where('user_id', $user->id)->count();
        $recentChats = \App\Models\Conversation::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', compact('totalChats', 'recentChats', 'user'));
    }
}
