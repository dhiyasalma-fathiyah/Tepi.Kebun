<!DOCTYPE html>
<html lang="id">
<body style="font-family: Arial, sans-serif; color:#1c2a22;">
    <h2 style="color:#166a3e;">Pesan baru dari formulir Hubungi Kami</h2>
    <table cellpadding="6" style="border-collapse:collapse;">
        <tr><td><strong>Nama</strong></td><td>{{ $contact->name }}</td></tr>
        <tr><td><strong>Email</strong></td><td>{{ $contact->email }}</td></tr>
        <tr><td><strong>Telepon</strong></td><td>{{ $contact->phone ?: '-' }}</td></tr>
        <tr><td><strong>Subjek</strong></td><td>{{ $contact->subject }}</td></tr>
    </table>
    <p><strong>Pesan:</strong></p>
    <p style="white-space: pre-line; background:#f2f8f4; padding:12px; border-radius:8px;">{{ $contact->message }}</p>
    <p style="color:#66766c; font-size:12px;">Diterima {{ $contact->created_at->format('d M Y H:i') }} &mdash; Tepi Kebun</p>
</body>
</html>
