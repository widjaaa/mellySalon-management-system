<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        $members = \App\Models\Member::all();
        return view('welcome', compact('services', 'members'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|integer|min:0',
            'description' => 'nullable|string'
        ]);
        $service = Service::create($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Layanan berhasil ditambahkan!',
            'data' => $service
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|integer|min:0',
            'description' => 'nullable|string'
        ]);
        $service = Service::findOrFail($id);
        $service->update($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Layanan berhasil diupdate!',
            'data' => $service
        ]);
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Layanan berhasil dihapus!'
        ]);
    }
}
