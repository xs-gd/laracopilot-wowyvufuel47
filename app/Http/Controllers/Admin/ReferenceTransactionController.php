<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferenceTransaction;
use App\Models\Librarian;
use Illuminate\Http\Request;

class ReferenceTransactionController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $search  = request('search');
        $status  = request('status');
        $channel = request('channel');

        $transactions = ReferenceTransaction::with('librarian')
            ->when($search, fn($q) => $q->where('subject_area', 'like', "%{$search}%")
                ->orWhere('question_summary', 'like', "%{$search}%")
                ->orWhere('patron_type', 'like', "%{$search}%"))
            ->when($status,  fn($q) => $q->where('status', $status))
            ->when($channel, fn($q) => $q->where('channel', $channel))
            ->orderByDesc('transaction_date')
            ->orderByDesc('transaction_time')
            ->paginate(15)
            ->withQueryString();

        return view('admin.transactions.index', compact('transactions', 'search', 'status', 'channel'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $librarians = Librarian::where('active', true)->orderBy('name')->get();
        return view('admin.transactions.create', compact('librarians'));
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $validated = $request->validate([
            'transaction_date'   => 'required|date',
            'transaction_time'   => 'required',
            'librarian_id'       => 'required|exists:librarians,id',
            'patron_type'        => 'required|string',
            'channel'            => 'required|in:in_person,phone,email,chat,virtual',
            'transaction_type'   => 'required|in:ready_reference,research,directional,instructional,reader_advisory,technical',
            'subject_area'       => 'required|string|max:255',
            'question_summary'   => 'required|string',
            'response_summary'   => 'nullable|string',
            'resources_used'     => 'nullable|string|max:255',
            'duration_minutes'   => 'nullable|integer|min:1|max:480',
            'status'             => 'required|in:pending,in_progress,closed,referred',
            'complexity_level'   => 'required|in:simple,moderate,complex',
            'follow_up_required' => 'boolean',
            'notes'              => 'nullable|string',
        ]);

        $validated['follow_up_required'] = $request->boolean('follow_up_required');
        $validated['recorded_by']        = session('admin_user', 'Administrator');

        ReferenceTransaction::create($validated);
        return redirect()->route('admin.transactions.index')->with('success', 'Transazione registrata con successo.');
    }

    public function show($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $transaction = ReferenceTransaction::with('librarian')->findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $transaction = ReferenceTransaction::findOrFail($id);
        $librarians  = Librarian::where('active', true)->orderBy('name')->get();
        return view('admin.transactions.edit', compact('transaction', 'librarians'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $transaction = ReferenceTransaction::findOrFail($id);

        $validated = $request->validate([
            'transaction_date'   => 'required|date',
            'transaction_time'   => 'required',
            'librarian_id'       => 'required|exists:librarians,id',
            'patron_type'        => 'required|string',
            'channel'            => 'required|in:in_person,phone,email,chat,virtual',
            'transaction_type'   => 'required|in:ready_reference,research,directional,instructional,reader_advisory,technical',
            'subject_area'       => 'required|string|max:255',
            'question_summary'   => 'required|string',
            'response_summary'   => 'nullable|string',
            'resources_used'     => 'nullable|string|max:255',
            'duration_minutes'   => 'nullable|integer|min:1|max:480',
            'status'             => 'required|in:pending,in_progress,closed,referred',
            'complexity_level'   => 'required|in:simple,moderate,complex',
            'follow_up_required' => 'boolean',
            'notes'              => 'nullable|string',
        ]);

        $validated['follow_up_required'] = $request->boolean('follow_up_required');
        $transaction->update($validated);

        return redirect()->route('admin.transactions.index')->with('success', 'Transazione aggiornata con successo.');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        ReferenceTransaction::findOrFail($id)->delete();
        return redirect()->route('admin.transactions.index')->with('success', 'Transazione eliminata.');
    }
}