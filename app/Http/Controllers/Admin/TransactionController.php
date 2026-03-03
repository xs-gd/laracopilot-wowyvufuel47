<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferenceTransaction;
use App\Models\Librarian;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $query = ReferenceTransaction::with('librarian');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('patron_type', 'like', "%{$search}%")
                  ->orWhere('subject_area', 'like', "%{$search}%")
                  ->orWhere('question_summary', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->transaction_type);
        }

        if ($request->filled('channel')) {
            $query->where('channel', $request->channel);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }

        if ($request->filled('librarian_id')) {
            $query->where('librarian_id', $request->librarian_id);
        }

        $transactions = $query->orderByDesc('transaction_date')->paginate(20)->withQueryString();
        $librarians   = Librarian::where('active', true)->orderBy('name')->get();

        return view('admin.transactions.index', compact('transactions', 'librarians'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        $librarians = Librarian::where('active', true)->orderBy('name')->get();
        return view('admin.transactions.create', compact('librarians'));
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'transaction_date'    => 'required|date',
            'transaction_time'    => 'required',
            'librarian_id'        => 'required|exists:librarians,id',
            'patron_type'         => 'required|string|max:100',
            'channel'             => 'required|in:in_person,phone,email,chat,virtual',
            'transaction_type'    => 'required|in:ready_reference,research,directional,instructional,reader_advisory,technical',
            'subject_area'        => 'required|string|max:200',
            'question_summary'    => 'required|string|max:2000',
            'response_summary'    => 'nullable|string|max:2000',
            'resources_used'      => 'nullable|string|max:1000',
            'duration_minutes'    => 'nullable|integer|min:1|max:480',
            'status'              => 'required|in:pending,in_progress,closed,referred',
            'complexity_level'    => 'required|in:simple,moderate,complex',
            'follow_up_required'  => 'boolean',
            'notes'               => 'nullable|string|max:1000',
        ]);

        $validated['follow_up_required'] = $request->boolean('follow_up_required');
        $validated['recorded_by']        = session('admin_user');

        ReferenceTransaction::create($validated);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transazione di riferimento registrata con successo.');
    }

    public function show($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        $transaction = ReferenceTransaction::with('librarian')->findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        $transaction = ReferenceTransaction::findOrFail($id);
        $librarians  = Librarian::where('active', true)->orderBy('name')->get();
        return view('admin.transactions.edit', compact('transaction', 'librarians'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'transaction_date'    => 'required|date',
            'transaction_time'    => 'required',
            'librarian_id'        => 'required|exists:librarians,id',
            'patron_type'         => 'required|string|max:100',
            'channel'             => 'required|in:in_person,phone,email,chat,virtual',
            'transaction_type'    => 'required|in:ready_reference,research,directional,instructional,reader_advisory,technical',
            'subject_area'        => 'required|string|max:200',
            'question_summary'    => 'required|string|max:2000',
            'response_summary'    => 'nullable|string|max:2000',
            'resources_used'      => 'nullable|string|max:1000',
            'duration_minutes'    => 'nullable|integer|min:1|max:480',
            'status'              => 'required|in:pending,in_progress,closed,referred',
            'complexity_level'    => 'required|in:simple,moderate,complex',
            'follow_up_required'  => 'boolean',
            'notes'               => 'nullable|string|max:1000',
        ]);

        $validated['follow_up_required'] = $request->boolean('follow_up_required');

        $transaction = ReferenceTransaction::findOrFail($id);
        $transaction->update($validated);

        return redirect()->route('admin.transactions.show', $id)
            ->with('success', 'Transazione aggiornata con successo.');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        ReferenceTransaction::findOrFail($id)->delete();
        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transazione eliminata con successo.');
    }
}