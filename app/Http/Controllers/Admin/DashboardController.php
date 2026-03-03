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

        $totalLibrarians      = Librarian::count();
        $activeLibrarians     = Librarian::where('active', true)->count();
        $totalTransactions    = ReferenceTransaction::count();
        $pendingTransactions  = ReferenceTransaction::where('status', 'pending')->count();
        $closedTransactions   = ReferenceTransaction::where('status', 'closed')->count();
        $inProgressTransactions = ReferenceTransaction::where('status', 'in_progress')->count();

        $transactionsByChannel = ReferenceTransaction::selectRaw('channel, count(*) as total')
            ->groupBy('channel')
            ->orderByDesc('total')
            ->get();

        $transactionsByType = ReferenceTransaction::selectRaw('transaction_type, count(*) as total')
            ->groupBy('transaction_type')
            ->orderByDesc('total')
            ->get();

        $recentTransactions = ReferenceTransaction::with('librarian')
            ->orderByDesc('transaction_date')
            ->orderByDesc('transaction_time')
            ->limit(8)
            ->get();

        $avgDuration = ReferenceTransaction::whereNotNull('duration_minutes')->avg('duration_minutes');

        $transactionsByComplexity = ReferenceTransaction::selectRaw('complexity_level, count(*) as total')
            ->groupBy('complexity_level')
            ->get()
            ->keyBy('complexity_level');

        return view('admin.dashboard', compact(
            'totalLibrarians',
            'activeLibrarians',
            'totalTransactions',
            'pendingTransactions',
            'closedTransactions',
            'inProgressTransactions',
            'transactionsByChannel',
            'transactionsByType',
            'recentTransactions',
            'avgDuration',
            'transactionsByComplexity'
        ));
    }
}