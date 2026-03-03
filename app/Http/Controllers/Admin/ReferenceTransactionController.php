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
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $transactions = ReferenceTransaction::with('librarian')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
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
            'librarian_id'   => 'required|exists:librarians,id',
            'patron_name'    => 'required|string|max:255',
            'question'       => 'required|string',
            'answer'         => 'nullable|string',
            'type'           => 'required|in:directional,informational,research,reader_advisory,technology',
            'duration'       => 'nullable|integer|min:1',
            'notes'          => 'nullable|string',
        ]);

        ReferenceTransaction::create($validated);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction recorded successfully.');
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

        $transaction = ReferenceTransaction::findOrFail($id);

        $validated = $request->validate([
            'librarian_id'   => 'required|exists:librarians,id',
            'patron_name'    => 'required|string|max:255',
            'question'       => 'required|string',
            'answer'         => 'nullable|string',
            'type'           => 'required|in:directional,informational,research,reader_advisory,technology',
            'duration'       => 'nullable|integer|min:1',
            'notes'          => 'nullable|string',
        ]);

        $transaction->update($validated);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        ReferenceTransaction::findOrFail($id)->delete();

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}