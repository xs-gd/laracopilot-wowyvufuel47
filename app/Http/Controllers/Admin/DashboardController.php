<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Librarian;
use App\Models\ReferenceTransaction;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $totalLibrarians       = Librarian::count();
        $totalTransactions     = ReferenceTransaction::count();
        $recentTransactions    = ReferenceTransaction::with('librarian')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $activeLibrarians      = Librarian::where('active', true)->count();
        $todayTransactions     = ReferenceTransaction::whereDate('created_at', today())->count();
        $latestLibrarians      = Librarian::orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalLibrarians',
            'totalTransactions',
            'recentTransactions',
            'activeLibrarians',
            'todayTransactions',
            'latestLibrarians'
        ));
    }
}