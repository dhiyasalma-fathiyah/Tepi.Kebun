@extends('layouts.app')

@section('title', 'Hubungi Kami - Tepi Kebun')

@section('content')
<div class="text-center mb-4">
    <h2 class="tk-title">Hubungi Kami</h2>
    <div class="tk-title-underline"></div>
    <p class="text-muted">Punya pertanyaan umum? Baca FAQ dulu, atau kirim pesan langsung ke tim kami.<br>
        Ingin memesan buah? Gunakan <a href="{{ route('orders.create') }}" class="fw-bold">Form Pemesanan</a>.</p>
</div>

<div class="row g-4">
    {{-- FAQ --}}
    <div class="col-lg-6">
        <h4 class="fs-5 fw-bold mb-3"><i class="bi bi-question-circle text-success"></i> Pertanyaan yang Sering Diajukan</h4>
        @php $n = 0; @endphp
        @foreach ($faqs as $category => $items)
            <div class="small text-uppercase fw-bold text-muted mt-3 mb-2">{{ $category }}</div>
            <div class="accordion" id="faq-{{ $loop->index }}">
                @foreach ($items as $faq)
                    @php $n++; @endphp
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-item-{{ $n }}">
                                {{ $faq['question'] }}
                            </button>
                        </h2>
                        <div id="faq-item-{{ $n }}" class="accordion-collapse collapse" data-bs-parent="#faq-{{ $loop->parent->index }}">
                            <div class="accordion-body text-muted">{{ $faq['answer'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    {{-- Form --}}
    <div class="col-lg-6">
        <div class="tk-form-card">
            <h5><i class="bi bi-envelope-paper text-success"></i> Kirim Pesan</h5>
            <form action="{{ route('contact.send') }}" method="POST" id="contactForm" novalidate>
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama lengkap / bisnis</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Anda">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Alamat email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Telepon <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="081234567890">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="subject" class="form-label">Subjek</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" class="form-control @error('subject') is-invalid @enderror" placeholder="Contoh: Kerja sama pasokan">
                        @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label for="message" class="form-label">Pesan / pertanyaan</label>
                        <textarea name="message" id="message" rows="5" class="form-control @error('message') is-invalid @enderror" placeholder="Tuliskan pertanyaan Anda...">{{ old('message') }}</textarea>
                        @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <button type="submit" class="btn tk-btn-green w-100 mt-3"><i class="bi bi-send"></i> Kirim Pesan</button>
            </form>

            <div class="d-flex align-items-center gap-2 my-3 text-muted small"><hr class="flex-grow-1 m-0">atau<hr class="flex-grow-1 m-0"></div>

            <a href="{{ $waLink }}" id="waBtn" target="_blank" rel="noopener" class="btn tk-btn-wa w-100">
                <i class="bi bi-whatsapp"></i> Chat langsung via WhatsApp
            </a>
            <div class="small text-muted text-center mt-2">Pesan di formulir akan ikut terisi otomatis ke chat WhatsApp.</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const base = @json(config('tepikebun.whatsapp'));
    const number = String(base).replace(/\D+/g, '');
    const btn = document.getElementById('waBtn');
    const f = id => document.getElementById(id);

    function update() {
        const name = f('name').value.trim();
        const subject = f('subject').value.trim();
        const message = f('message').value.trim();
        let text = 'Halo Tepi Kebun, saya ' + (name || 'calon pelanggan') + '.';
        if (subject) text += '\nTopik: ' + subject;
        text += '\n' + (message || 'Saya ingin bertanya tentang pasokan buah.');
        btn.href = 'https://wa.me/' + number + '?text=' + encodeURIComponent(text);
    }
    ['name', 'subject', 'message'].forEach(id => f(id).addEventListener('input', update));
})();
</script>
@endpush
