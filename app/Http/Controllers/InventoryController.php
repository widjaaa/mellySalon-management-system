<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Get all inventories
     */
    public function index()
    {
        $inventories = Inventory::orderBy('name')->get();
        return response()->json($inventories);
    }

    /**
     * Store new inventory
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50'
        ]);

        $inventory = Inventory::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil ditambahkan',
            'data' => $inventory
        ], 201);
    }

    /**
     * Update existing inventory
     */
    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50'
        ]);

        $inventory->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil diperbarui',
            'data' => $inventory
        ]);
    }

    /**
     * Delete inventory
     */
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil dihapus'
        ]);
    }
}
