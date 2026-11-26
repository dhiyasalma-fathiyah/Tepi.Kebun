<?php

return [

    /*
    | Alamat email admin yang menerima pesan dari form "Hubungi Kami".
    */
    'admin_email' => env('ADMIN_EMAIL', 'admin@tepikebun.test'),

    /*
    | Nomor WhatsApp bisnis (format internasional tanpa +, contoh 6281234567890).
    */
    'whatsapp' => env('WHATSAPP_NUMBER', '6281234567890'),

    /*
    | Informasi rekening untuk pembayaran transfer bank.
    */
    'bank' => [
        'name' => env('BANK_NAME', 'BCA'),
        'account' => env('BANK_ACCOUNT', '1234 5678 90'),
        'holder' => env('BANK_HOLDER', 'Tepi Kebun'),
    ],

    /*
    | Pertanyaan yang sering diajukan (ditampilkan di halaman Hubungi Kami).
    */
    'faqs' => [
        [
            'category' => 'Pemesanan',
            'question' => 'Bagaimana cara memesan buah di Tepi Kebun?',
            'answer' => 'Buka halaman Pesan, pilih buah dan jumlah box, isi data pengiriman, lalu kirim pesanan. Anda akan mendapat kode pesanan dan ringkasan pembayaran.',
        ],
        [
            'category' => 'Pemesanan',
            'question' => 'Apakah ada minimum pemesanan?',
            'answer' => 'Pemesanan dihitung per box. Anda dapat memesan mulai dari 1 box per produk, selama stok tersedia.',
        ],
        [
            'category' => 'Pemesanan',
            'question' => 'Bisakah saya mengubah atau membatalkan pesanan?',
            'answer' => 'Bisa, selama status pesanan masih "Menunggu". Hubungi kami lewat WhatsApp dengan menyebutkan kode pesanan Anda.',
        ],
        [
            'category' => 'Pembayaran',
            'question' => 'Metode pembayaran apa yang tersedia?',
            'answer' => 'Transfer bank dan bayar di tempat (COD) untuk area tertentu. Detail rekening tampil di halaman konfirmasi pesanan.',
        ],
        [
            'category' => 'Pengiriman',
            'question' => 'Berapa lama pengiriman?',
            'answer' => 'Pesanan diproses 1 hari kerja. Estimasi tiba 1-3 hari tergantung kota tujuan.',
        ],
        [
            'category' => 'Kualitas',
            'question' => 'Apa beda Grade A dan Grade B?',
            'answer' => 'Grade A: ukuran seragam, kulit mulus, tingkat kematangan sesuai standar. Grade B: kualitas baik dengan ukuran/penampilan kurang seragam, cocok untuk jus dan olahan.',
        ],
        [
            'category' => 'Kualitas',
            'question' => 'Bagaimana jika buah yang diterima tidak sesuai?',
            'answer' => 'Laporkan dalam 24 jam setelah barang diterima beserta foto. Kami akan mengganti atau mengembalikan dana sesuai hasil pengecekan.',
        ],
    ],
];
