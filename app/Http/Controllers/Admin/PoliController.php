<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::latest()->get();
        return view('admin.polis.index', compact('polis'));
    }

    public function create()
    {
        return view('admin.polis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:polis,name',
            'description' => 'nullable|string',
        ]);

        Poli::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('admin.polis.index')
            ->with('success', 'Poli berhasil ditambahkan.');
    }

    public function edit(Poli $poli)
    {
        return view('admin.polis.edit', compact('poli'));
    }

    public function update(Request $request, Poli $poli)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:polis,name,' . $poli->id,
            'description' => 'nullable|string',
        ]);

        $poli->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.polis.index')
            ->with('success', 'Poli berhasil diperbarui.');
    }

    public function destroy(Poli $poli)
    {
        $poli->delete();

        return redirect()->route('admin.polis.index')
            ->with('success', 'Poli berhasil dihapus.');
    }
}