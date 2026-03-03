<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Librarian;
use Illuminate\Http\Request;

class LibrarianController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $librarians = Librarian::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.librarians.index', compact('librarians'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.librarians.create');
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:librarians,email',
            'phone'      => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
            'active'     => 'nullable|boolean',
        ]);

        $validated['active'] = $request->has('active');

        Librarian::create($validated);

        return redirect()->route('admin.librarians.index')->with('success', 'Librarian created successfully.');
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $librarian = Librarian::findOrFail($id);
        return view('admin.librarians.edit', compact('librarian'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $librarian = Librarian::findOrFail($id);

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:librarians,email,' . $id,
            'phone'      => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
            'active'     => 'nullable|boolean',
        ]);

        $validated['active'] = $request->has('active');

        $librarian->update($validated);

        return redirect()->route('admin.librarians.index')->with('success', 'Librarian updated successfully.');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        Librarian::findOrFail($id)->delete();

        return redirect()->route('admin.librarians.index')->with('success', 'Librarian deleted successfully.');
    }
}