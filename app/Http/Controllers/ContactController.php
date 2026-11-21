<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return view('contact-us', compact('contacts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
        ]);

        Contact::create($validated);

        return redirect()->route('contact')
            ->with('success', 'Terima kasih! Pesan Anda sudah kami terima.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email',
            'message' => 'sometimes|required|string|max:2000',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update($validated);

        return redirect()->back()->with('success', 'Pesan kontak berhasil diperbarui.');
    }

    // Soft delete: mengisi kolom deleted_at tanpa menghapus permanen
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->back()->with('success', 'Pesan kontak berhasil dihapus sementara.');
    }

    public function trashed()
    {
        $trashedContacts = Contact::onlyTrashed()->get();
        return view('contact-us', [
            'contacts' => $trashedContacts,
            'isTrashed' => true,
        ]);
    }

    public function restore($id)
    {
        $contact = Contact::withTrashed()->findOrFail($id);
        $contact->restore();

        return redirect()->back()->with('success', 'Pesan kontak berhasil dipulihkan.');
    }
}