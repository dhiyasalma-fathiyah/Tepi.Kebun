<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    // Form publik "Hubungi Kami" (GET /contact-us)
    public function create(Request $request): View
    {
        return view('contacts.create', [
            'products'         => Product::orderBy('product_name')->pluck('product_name', 'id'),
            'selectedProduct'  => $request->query('product_id'),
        ]);
    }

    // Daftar pesan masuk (Read)
    public function index(): View
    {
        return view('contacts.index', [
            'contacts'  => Contact::with('product')->latest()->get(),
            'isTrashed' => false,
        ]);
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        Contact::create($request->validated());

        return redirect()->route('contact')
            ->with('success', 'Terima kasih! Pesan Anda sudah kami terima.');
    }

    public function edit(Contact $contact): View
    {
        return view('contacts.edit', [
            'contact'  => $contact,
            'products' => Product::orderBy('product_name')->pluck('product_name', 'id'),
        ]);
    }

    public function update(ContactRequest $request, Contact $contact): RedirectResponse
    {
        $contact->update($request->validated());

        return redirect()->route('contacts.index')
            ->with('success', 'Pesan kontak berhasil diperbarui.');
    }

    // Soft delete
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Pesan dipindahkan ke sampah.');
    }

    public function trashed(): View
    {
        return view('contacts.index', [
            'contacts'  => Contact::onlyTrashed()->with('product')->latest('deleted_at')->get(),
            'isTrashed' => true,
        ]);
    }

    public function restore(int $id): RedirectResponse
    {
        Contact::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('contacts.index')
            ->with('success', 'Pesan berhasil dipulihkan.');
    }
}
