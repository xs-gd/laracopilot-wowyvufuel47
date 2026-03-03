<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Librarian;
use Illuminate\Http\Request;

class LibrarianController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $search = request('search');
        $role   = request('role');

        $librarians = Librarian::when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            })
            ->when($role, fn($q) => $q->where('role', $role))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $roles = Librarian::roles();

        return view('admin.librarians.index', compact('librarians', 'search', 'role', 'roles'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $roles = Librarian::roles();
        return view('admin.librarians.create', compact('roles'));
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:librarians,email',
            'employee_id'    => 'required|string|unique:librarians,employee_id',
            'department'     => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'phone'          => 'nullable|string|max:50',
            'hire_date'      => 'required|date',
            'active'         => 'boolean',
            'role'           => 'required|in:' . implode(',', array_keys(Librarian::roles())),
            'role_notes'     => 'nullable|string|max:500',
        ]);

        $validated['active'] = $request->boolean('active');
        Librarian::create($validated);

        return redirect()->route('admin.librarians.index')->with('success', 'Bibliotecario aggiunto con successo.');
    }

    public function show($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $librarian = Librarian::with(['transactions' => function ($q) {
            $q->orderByDesc('transaction_date')->limit(10);
        }])->findOrFail($id);

        $stats = [
            'total'        => $librarian->transactions()->count(),
            'closed'       => $librarian->transactions()->where('status', 'closed')->count(),
            'pending'      => $librarian->transactions()->where('status', 'pending')->count(),
            'avg_duration' => round($librarian->transactions()->whereNotNull('duration_minutes')->avg('duration_minutes') ?? 0),
        ];

        return view('admin.librarians.show', compact('librarian', 'stats'));
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $librarian = Librarian::findOrFail($id);
        $roles     = Librarian::roles();
        return view('admin.librarians.edit', compact('librarian', 'roles'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $librarian = Librarian::findOrFail($id);

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:librarians,email,' . $id,
            'employee_id'    => 'required|string|unique:librarians,employee_id,' . $id,
            'department'     => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'phone'          => 'nullable|string|max:50',
            'hire_date'      => 'required|date',
            'active'         => 'boolean',
            'role'           => 'required|in:' . implode(',', array_keys(Librarian::roles())),
            'role_notes'     => 'nullable|string|max:500',
        ]);

        $validated['active'] = $request->boolean('active');
        $librarian->update($validated);

        return redirect()->route('admin.librarians.index')->with('success', 'Bibliotecario aggiornato con successo.');
    }

    /**
     * Dedicated endpoint to update only the role (AJAX-friendly quick-edit).
     */
    public function updateRole(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $librarian = Librarian::findOrFail($id);

        $validated = $request->validate([
            'role'       => 'required|in:' . implode(',', array_keys(Librarian::roles())),
            'role_notes' => 'nullable|string|max:500',
        ]);

        $librarian->update($validated);

        return redirect()->back()->with('success', 'Ruolo di ' . $librarian->name . ' aggiornato a "' . $librarian->fresh()->role_label . '".');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Librarian::findOrFail($id)->delete();
        return redirect()->route('admin.librarians.index')->with('success', 'Bibliotecario eliminato.');
    }
}