<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessageMail;
use App\Models\Contact;
use App\Support\WhatsApp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function index()
    {
        // FAQ dikelompokkan per kategori (Collection::groupBy).
        $faqs = collect(config('tepikebun.faqs'))->groupBy('category');

        return view('contact', [
            'faqs' => $faqs,
            'waLink' => WhatsApp::link('Halo Tepi Kebun, saya ingin bertanya tentang pasokan buah.'),
        ]);
    }

    public function store(ContactRequest $request)
    {
        $contact = Contact::create($request->validated());

        // Pengiriman email tidak boleh membuat aplikasi error bila SMTP belum disetel.
        try {
            Mail::to(config('tepikebun.admin_email'))->send(new ContactMessageMail($contact));
            $notice = 'Terima kasih! Pesan Anda sudah kami terima dan diteruskan ke tim kami.';
        } catch (Throwable $e) {
            Log::warning('Gagal mengirim email Hubungi Kami: '.$e->getMessage(), ['contact_id' => $contact->id]);
            $notice = 'Terima kasih! Pesan Anda tersimpan. (Notifikasi email belum dapat dikirim, tim kami tetap akan membacanya.)';
        }

        return redirect()->route('contact')->with('success', $notice);
    }
}
