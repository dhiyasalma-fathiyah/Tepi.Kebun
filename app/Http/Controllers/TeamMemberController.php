<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::all();
        return view('team', compact('teamMembers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'required|string|max:100',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|string|max:255',
        ]);

        TeamMember::create($validated);

        return redirect()->back()->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'role' => 'sometimes|required|string|max:100',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|string|max:255',
        ]);

        $member = TeamMember::findOrFail($id);
        $member->update($validated);

        return redirect()->back()->with('success', 'Data anggota tim berhasil diperbarui.');
    }

    // Soft delete: mengisi kolom deleted_at tanpa menghapus permanen
    public function destroy($id)
    {
        $member = TeamMember::findOrFail($id);
        $member->delete();

        return redirect()->back()->with('success', 'Anggota tim berhasil dihapus sementara.');
    }

    public function trashed()
    {
        $trashedMembers = TeamMember::onlyTrashed()->get();
        return view('team', [
            'teamMembers' => $trashedMembers,
            'isTrashed' => true,
        ]);
    }

    public function restore($id)
    {
        $member = TeamMember::withTrashed()->findOrFail($id);
        $member->restore();

        return redirect()->back()->with('success', 'Anggota tim berhasil dipulihkan.');
    }
}