<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamMemberRequest;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index(Request $request)
    {
        $trashed = $request->boolean('trashed');

        $members = TeamMember::when($trashed, fn ($q) => $q->onlyTrashed())->orderBy('id')->get();

        return view('admin.team.index', [
            'members' => $members,
            'trashed' => $trashed,
            'trashedCount' => TeamMember::onlyTrashed()->count(),
        ]);
    }

    public function create()
    {
        return view('admin.team.form', ['member' => new TeamMember]);
    }

    public function store(TeamMemberRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        TeamMember::create($data);

        return redirect()->route('admin.team.index')->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function edit(TeamMember $team)
    {
        return view('admin.team.form', ['member' => $team]);
    }

    public function update(TeamMemberRequest $request, TeamMember $team): RedirectResponse
    {
        $data = $request->safe()->except('photo');

        if ($request->hasFile('photo')) {
            if ($team->photo) {
                Storage::disk('public')->delete($team->photo);
            }
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        $team->update($data);

        return redirect()->route('admin.team.index')->with('success', 'Data anggota tim diperbarui.');
    }

    public function destroy(TeamMember $team): RedirectResponse
    {
        $team->delete();

        return back()->with('success', "{$team->name} dipindahkan ke daftar terhapus.");
    }

    public function restore(int $id): RedirectResponse
    {
        TeamMember::onlyTrashed()->findOrFail($id)->restore();

        return back()->with('success', 'Anggota tim berhasil dipulihkan.');
    }
}
