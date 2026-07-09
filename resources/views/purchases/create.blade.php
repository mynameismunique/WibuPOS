@extends('layouts.app')

@section('title', 'Tambah Pembelian')

@section('content')
<div class="card card-wibu p-4">
    <h4><i class="bi bi-plus-circle"></i> Tambah Pembelian</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('purchases.store') }}" method="POST" id="purchaseForm">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Supplier <span class="text-danger">*</span></label>
                <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                    <option value="">Pilih Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
                @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Pembelian <span class="text-danger">*</span></label>
                <input type="date" name="purchase_date" class="form-control @error('purchase_date') is-invalid @enderror" 
                       value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                @error('purchase_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
            </div>
        </div>

        <hr>
        <h5 class="mt-3"><i class="bi bi-cart-plus"></i> Detail Produk</h5>

        <div id="product-rows">
            <div class="row g-2 mb-2 product-row">
                <div class="col-md-5">
                    <select name="products[0][product_id]" class="form-select" required>
                        <option value="">Pilih Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="products[0][quantity]" class="form-control qty-input" placeholder="Qty" required min="1">
                </div>
                <div class="col-md-3">
                    <input type="number" name="products[0][price]" class="form-control price-input" placeholder="Harga Beli" required min="0">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-row" style="display:none;">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-wibu-accent mt-2" id="add-row">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </button>

        <div class="mt-4">
            <button type="button" class="btn btn-wibu-primary" onclick="confirmSubmit()">Simpan Pembelian</button>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let rowIndex = 1;

    document.getElementById('add-row').addEventListener('click', function() {
        const container = document.getElementById('product-rows');
        const newRow = document.createElement('div');
        newRow.className = 'row g-2 mb-2 product-row';
        newRow.innerHTML = `
            <div class="col-md-5">
                <select name="products[${rowIndex}][product_id]" class="form-select" required>
                    <option value="">Pilih Produk</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->code }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="products[${rowIndex}][quantity]" class="form-control qty-input" placeholder="Qty" required min="1">
            </div>
            <div class="col-md-3">
                <input type="number" name="products[${rowIndex}][price]" class="form-control price-input" placeholder="Harga Beli" required min="0">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-row">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newRow);
        rowIndex++;

        const rows = document.querySelectorAll('.product-row');
        rows.forEach((row, index) => {
            const btn = row.querySelector('.remove-row');
            if (rows.length > 1) {
                btn.style.display = 'inline-block';
            } else {
                btn.style.display = 'none';
            }
        });
    });

    document.getElementById('product-rows').addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            const row = e.target.closest('.product-row');
            row.remove();
            const rows = document.querySelectorAll('.product-row');
            rows.forEach((r, index) => {
                const btn = r.querySelector('.remove-row');
                if (rows.length > 1) {
                    btn.style.display = 'inline-block';
                } else {
                    btn.style.display = 'none';
                }
            });
        }
    });

    function confirmSubmit() {
        const form = document.getElementById('purchaseForm');
        const supplier = document.querySelector('select[name="supplier_id"]');
        const supplierName = supplier.options[supplier.selectedIndex]?.text || 'Belum dipilih';
        const date = document.querySelector('input[name="purchase_date"]').value;
        const rows = document.querySelectorAll('.product-row');
        let productList = '';
        let valid = true;

        rows.forEach((row, index) => {
            const select = row.querySelector('select');
            const qty = row.querySelector('.qty-input');
            const price = row.querySelector('.price-input');
            if (select && select.value) {
                const name = select.options[select.selectedIndex].text;
                const qtyVal = qty.value || 0;
                const priceVal = price.value || 0;
                const subtotal = qtyVal * priceVal;
                productList += `<li>${name} x ${qtyVal} = Rp ${parseInt(subtotal).toLocaleString('id-ID')}</li>`;
            } else {
                valid = false;
            }
        });

        if (!supplier.value) {
            Swal.fire({
                icon: 'error',
                title: 'Supplier belum dipilih',
                text: 'Silakan pilih supplier terlebih dahulu!',
                confirmButtonColor: '#ff6b9d',
                background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
                color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
            });
            return;
        }

        if (!valid || rows.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Data Produk Belum Lengkap',
                text: 'Pastikan semua produk terisi dengan benar!',
                confirmButtonColor: '#ff6b9d',
                background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
                color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
            });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Pembelian',
            html: `
                <div style="text-align: left; max-width: 350px; margin: 0 auto;">
                    <p><strong>Supplier:</strong> ${supplierName}</p>
                    <p><strong>Tanggal:</strong> ${date}</p>
                    <p><strong>Produk:</strong></p>
                    <ul style="list-style: none; padding-left: 0;">${productList}</ul>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ff6b9d',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
            color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endpush
@endsection