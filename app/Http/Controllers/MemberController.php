<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    /**
     * Simpan member baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'tier' => 'in:Bronze,Silver,Gold',
            'bday' => 'nullable|date',
        ]);

        $member = Member::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil ditambahkan!',
            'data' => $member,
        ], 201);
    }

    /**
     * Update data member.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'tier' => 'in:Bronze,Silver,Gold',
            'bday' => 'nullable|date',
        ]);

        $member = Member::findOrFail($id);
        $member->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil diperbarui!',
            'data' => $member,
        ]);
    }

    /**
     * Hapus member.
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil dihapus!',
        ]);
    }
}
