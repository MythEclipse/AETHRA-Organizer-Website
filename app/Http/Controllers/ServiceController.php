<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'description' => 'required|string',
        ]);

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Deskripsi layanan "' . $service->title . '" berhasil diperbarui.');
    }
}
