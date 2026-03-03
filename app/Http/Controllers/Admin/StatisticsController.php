<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferenceTransaction;
use App\Models\Librarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $year  = $request->get('year', date('Y'));
        $month = $request->get('month', null);

        $query = ReferenceTransaction::whereYear('transaction_date', $year);
        if ($month) {
            $query->whereMonth('transaction_date', $month);
        }

        $total            = $query->count();
        $avgDuration      = round($query->avg('duration_minutes') ?? 0, 1);
        $followUpRequired = (clone $query)->where('follow_up_required', true)->count();

        $byType = (clone $query)->select('transaction_type', DB::raw('count(*) as total'))
            ->groupBy('transaction_type')->orderByDesc('total')->get();

        $byChannel = (clone $query)->select('channel', DB::raw('count(*) as total'))
            ->groupBy('channel')->orderByDesc('total')->get();

        $byComplexity = (clone $query)->select('complexity_level', DB::raw('count(*) as total'))
            ->groupBy('complexity_level')->orderByDesc('total')->get();

        $byStatus = (clone $query)->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')->orderByDesc('total')->get();

        $byPatronType = (clone $query)->select('patron_type', DB::raw('count(*) as total'))
            ->groupBy('patron_type')->orderByDesc('total')->limit(10)->get();

        $bySubject = (clone $query)->select('subject_area', DB::raw('count(*) as total'))
            ->groupBy('subject_area')->orderByDesc('total')->limit(10)->get();

        $byLibrarian = (clone $query)->select('librarian_id', DB::raw('count(*) as total'))
            ->with('librarian')->groupBy('librarian_id')->orderByDesc('total')->get();

        $monthlyTrend = ReferenceTransaction::whereYear('transaction_date', $year)
            ->select(DB::raw('strftime("%m", transaction_date) as month'), DB::raw('count(*) as total'))
            ->groupBy('month')->orderBy('month')->get()
            ->mapWithKeys(fn($item) => [(int)$item->month => $item->total]);

        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[$m] = $monthlyTrend[$m] ?? 0;
        }

        $availableYears = ReferenceTransaction::selectRaw('strftime("%Y", transaction_date) as year')
            ->groupBy('year')->orderByDesc('year')->pluck('year');

        return view('admin.statistics.index', compact(
            'total', 'avgDuration', 'followUpRequired',
            'byType', 'byChannel', 'byComplexity', 'byStatus',
            'byPatronType', 'bySubject', 'byLibrarian', 'months',
            'year', 'month', 'availableYears'
        ));
    }
}