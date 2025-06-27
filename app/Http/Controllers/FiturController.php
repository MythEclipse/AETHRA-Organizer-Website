<?php

namespace App\Http\Controllers;

use App\Models\Fitur;
use Illuminate\Http\Request;

class FiturController extends Controller
{
    public function index()
    {
        $fiturs = Fitur::latest()->paginate(10);
        return view('admin.fiturs.index', compact('fiturs'));
    }

    public function create()
    {
        return view('admin.fiturs.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:fiturs']);
        Fitur::create($request->all());
        return redirect()->route('fiturs.index')->with('success', 'Fitur berhasil ditambahkan.');
    }

    public function edit(Fitur $fitur)
    {
        return view('admin.fiturs.edit', compact('fitur'));
    }

    public function update(Request $request, Fitur $fitur)
    {
        $request->validate(['name' => 'required|string|max:255|unique:fiturs,name,' . $fitur->id]);
        $fitur->update($request->all());
        return redirect()->route('fiturs.index')->with('success', 'Fitur berhasil diperbarui.');
    }

    public function destroy(Fitur $fitur)
    {
        $fitur->delete();
        return redirect()->route('fiturs.index')->with('success', 'Fitur berhasil dihapus.');
    }
}
