{{-- Dipakai oleh form publik & edit. Variabel: $contact (opsional), $products, $selectedProduct (opsional) --}}
@php($current = old('product_id', $contact->product_id ?? ($selectedProduct ?? null)))

<div class="mb-3">
    <label for="name" class="form-label fw-semibold">Nama Lengkap / Nama Bisnis</label>
    <input type="text" name="name" id="name" value="{{ old('name', $contact->name ?? '') }}"
           class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama Anda">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label fw-semibold">Alamat Email</label>
    <input type="email" name="email" id="email" value="{{ old('email', $contact->email ?? '') }}"
           class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com">
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="product_id" class="form-label fw-semibold">Produk yang Diminati <span class="text-muted fw-normal">(opsional)</span></label>
    <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror">
        <option value="">-- Tidak spesifik --</option>
        @foreach ($products as $id => $name)
            <option value="{{ $id }}" @selected((string) $current === (string) $id)>{{ $name }}</option>
        @endforeach
    </select>
    @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-4">
    <label for="message" class="form-label fw-semibold">Pesan / Pertanyaan</label>
    <textarea name="message" id="message" rows="4"
              class="form-control @error('message') is-invalid @enderror"
              placeholder="Tuliskan kebutuhan pasokan buah Anda...">{{ old('message', $contact->message ?? '') }}</textarea>
    @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
