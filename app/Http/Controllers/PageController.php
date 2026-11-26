<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;

class PageController extends Controller
{
    public function about()
    {
        return view('about');
    }

    public function team()
    {
        $members = TeamMember::orderBy('id')->get();

        return view('team', compact('members'));
    }
}
