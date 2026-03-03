<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferenceTransaction;
use App\Models\Librarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        $librarians = Librarian::where('active', true)->orderBy('name')->get();
        return view('admin.reports.index', compact('librarians'));
    }

    public function generate(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'date_from'    => 'required|date',
            'date_to'      => 'required|date|after_or_equal:date_from',
            'report_type'  => 'required|in:summary,detail,librarian,subject',
            'librarian_id' => 'nullable|exists:librarians,id',
        ]);

        $query = ReferenceTransaction::with('librarian')
            ->whereBetween('transaction_date', [$request->date_from, $request->date_to]);

        if ($request->filled('librarian_id')) {
            $query->where('librarian_id', $request->librarian_id);
        }

        $transactions = $query->orderBy('transaction_date')->get();

        $summary = [
            'total'         => $transactions->count(),
            'by_type'       => $transactions->groupBy('transaction_type')->map->count(),
            'by_channel'    => $transactions->groupBy('channel')->map->count(),
            'by_complexity' => $transactions->groupBy('complexity_level')->map->count(),
            'by_status'     => $transactions->groupBy('status')->map->count(),
            'avg_duration'  => round($transactions->avg('duration_minutes') ?? 0, 1),
            'follow_ups'    => $transactions->where('follow_up_required', true)->count(),
        ];

        $librarians = Librarian::where('active', true)->orderBy('name')->get();

        return view('admin.reports.result', compact('transactions', 'summary', 'request', 'librarians'));
    }
}