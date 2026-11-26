<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $trashed = $request->boolean('trashed');

        $messages = Contact::query()
            ->when($trashed, fn ($q) => $q->onlyTrashed())
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.contacts.index', [
            'messages' => $messages,
            'trashed' => $trashed,
            'trashedCount' => Contact::onlyTrashed()->count(),
        ]);
    }

    public function show(Contact $contact)
    {
        if (! $contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /** Tandai sudah/belum dibaca. */
    public function update(Request $request, Contact $contact): RedirectResponse
    {
        $data = $request->validate(['is_read' => ['required', 'boolean']]);
        $contact->update($data);

        return back()->with('success', 'Status pesan diperbarui.');
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Pesan dipindahkan ke daftar terhapus.');
    }

    public function restore(int $id): RedirectResponse
    {
        Contact::onlyTrashed()->findOrFail($id)->restore();

        return back()->with('success', 'Pesan berhasil dipulihkan.');
    }
}
