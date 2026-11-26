<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamMemberRequest;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function index(): View
    {
        return view('team-members.index', [
            'teamMembers' => TeamMember::orderBy('name')->get(),
            'isTrashed'   => false,
        ]);
    }

    public function create(): View
    {
        return view('team-members.create', ['teamMember' => new TeamMember()]);
    }

    public function store(TeamMemberRequest $request): RedirectResponse
    {
        TeamMember::create($request->validated());

        return redirect()->route('team-members.index')
            ->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function edit(TeamMember $teamMember): View
    {
        return view('team-members.edit', compact('teamMember'));
    }

    public function update(TeamMemberRequest $request, TeamMember $teamMember): RedirectResponse
    {
        $teamMember->update($request->validated());

        return redirect()->route('team-members.index')
            ->with('success', 'Data anggota tim berhasil diperbarui.');
    }

    // Soft delete
    public function destroy(TeamMember $teamMember): RedirectResponse
    {
        $teamMember->delete();

        return redirect()->route('team-members.index')
            ->with('success', 'Anggota tim dipindahkan ke sampah.');
    }

    public function trashed(): View
    {
        return view('team-members.index', [
            'teamMembers' => TeamMember::onlyTrashed()->latest('deleted_at')->get(),
            'isTrashed'   => true,
        ]);
    }

    public function restore(int $id): RedirectResponse
    {
        TeamMember::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('team-members.index')
            ->with('success', 'Anggota tim berhasil dipulihkan.');
    }
}
