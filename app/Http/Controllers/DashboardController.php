<?php

namespace App\Http\Controllers;

use App\Models\CaseRecord;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $totalCases = CaseRecord::count();
            $totalUsers = User::count();
            $recentCases = CaseRecord::with('creator')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.admin', compact('totalCases', 'totalUsers', 'recentCases'));
        }

        // Staff dashboard
        $totalCases = CaseRecord::where('created_by', $user->id)->count();
        $recentCases = CaseRecord::where('created_by', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.staff', compact('totalCases', 'recentCases'));
    }
}
