@extends('layouts.app')

@section('title', 'Transaksi Penjualan')

@section('content')
<style>
    /* Perbaikan dark mode untuk input readonly */
    [data-bs-theme="dark"] .form-control[readonly] {
        background-color: #2a2a40;
        color: #e0dcec;
    }
    [data-bs-theme="dark"] .form-control[readonly]:focus {
        background-color: #2a2a40;
    }
</style>

<div class="card card-wibu p-4">
    <h4><i class="bi bi-cart-plus"></i> Transaksi Penjualan</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Pelanggan</label>
                <input type="text" name="customer_name" class="form-control" placeholder="Kosongkan jika umum" value="{{ old('customer_name') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                <select name="payment_method" class="form-select" required>
                    <option value="cash">Tunai (Cash)</option>
                    <option value="debit">Debit</option>
                    <option value="credit">Kredit</option>
                    <option value="qris">QRIS</option>
                </select>
            </div>
        </div>

        <!-- ===== SCAN QR CODE ===== -->
        <div class="row mb-3">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white"><i class="bi bi-qr-code"></i></span>
                    <input type="text" id="scan-input" class="form-control" placeholder="Scan QR Code atau masukkan kode produk..." autofocus>
                    <button class="btn btn-wibu-primary" id="btn-scan-add" type="button">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
                </div>
                <small class="text-muted">Tekan Enter atau klik Tambah untuk menambahkan produk</small>
            </div>
        </div>

        <hr>
        <h5 class="mt-3"><i class="bi bi-box-fill"></i> Daftar Produk</h5>

        <div id="product-rows">
            <div class="row g-2 mb-2 product-row">
                <div class="col-md-5">
                    <select name="products[0][product_id]" class="form-select product-select" required>
                        <option value="">Pilih Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}" data-stock="{{ $product->stock }}">
                                {{ $product->name }} ({{ $product->code }}) - Stok: {{ $product->stock }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="products[0][quantity]" class="form-control qty-input" placeholder="Qty" required min="1" value="1">
                </div>
                <div class="col-md-3">
                    <input type="number" name="products[0][price]" class="form-control price-input" placeholder="Harga Jual" required min="0" readonly>
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

        <hr class="mt-4">
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">Subtotal</label>
                <input type="text" id="subtotal_display" class="form-control" value="Rp 0" readonly>
                <input type="hidden" name="total_amount" id="total_amount" value="0">
            </div>
            <div class="col-md-3">
                <label class="form-label">Diskon (Rp)</label>
                <input type="number" name="discount" id="discount" class="form-control" value="0" min="0">
            </div>
            <div class="col-md-3">
                <label class="form-label">Pajak (Rp)</label>
                <input type="number" name="tax" id="tax" class="form-control" value="0" min="0">
            </div>
            <div class="col-md-3">
                <label class="form-label">Grand Total</label>
                <input type="text" id="grand_total_display" class="form-control fw-bold text-success" value="Rp 0" readonly>
                <input type="hidden" name="grand_total" id="grand_total" value="0">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <label class="form-label">Uang Bayar <span class="text-danger">*</span></label>
                <input type="number" name="payment_amount" id="payment_amount" class="form-control" required min="0" value="0">
            </div>
            <div class="col-md-4">
                <label class="form-label">Kembalian</label>
                <input type="text" id="change_display" class="form-control" value="Rp 0" readonly>
                <input type="hidden" name="change_amount" id="change_amount" value="0">
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-wibu-primary" id="submitBtn">Proses Transaksi</button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let rowIndex = 1;

    // Fungsi format Rupiah
    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
    }

    // ==== CEK STOK ====
    function checkStock(productId, qty) {
        const select = document.querySelector(`.product-select option[value="${productId}"]`);
        if (!select) return false;
        const stock = parseInt(select.dataset.stock) || 0;
        return qty <= stock;
    }

    // ==== CEK STOK SEMUA PRODUK ====
    function validateAllStock() {
        const rows = document.querySelectorAll('.product-row');
        let isValid = true;
        let errorMessage = '';
        rows.forEach(row => {
            const select = row.querySelector('.product-select');
            const qtyInput = row.querySelector('.qty-input');
            if (select && select.value) {
                const productId = select.value;
                const qty = parseInt(qtyInput.value) || 0;
                const stock = parseInt(select.options[select.selectedIndex]?.dataset?.stock) || 0;
                if (qty > stock) {
                    isValid = false;
                    errorMessage += `Stok ${select.options[select.selectedIndex].text.split('(')[0].trim()} tidak cukup! (Stok: ${stock}, Diminta: ${qty})\n`;
                }
            }
        });
        return { isValid, errorMessage };
    }

    // ===== KONFIRMASI TRANSAKSI =====
    document.getElementById('saleForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Validasi stok semua produk
        const stockValidation = validateAllStock();
        if (!stockValidation.isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Stok Tidak Cukup!',
                text: stockValidation.errorMessage,
                confirmButtonColor: '#ff6b9d',
                background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
                color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
            });
            return;
        }

        // Ambil data untuk ringkasan
        const customerName = document.querySelector('input[name="customer_name"]').value || 'Umum';
        const paymentMethod = document.querySelector('select[name="payment_method"]').value;
        const paymentAmount = parseInt(document.getElementById('payment_amount').value) || 0;
        const grandTotal = parseInt(document.getElementById('grand_total').value) || 0;
        const change = paymentAmount - grandTotal;

        if (paymentAmount < grandTotal) {
            Swal.fire({
                icon: 'warning',
                title: 'Uang Bayar Kurang!',
                text: `Uang bayar (Rp ${paymentAmount.toLocaleString('id-ID')}) kurang dari Grand Total (Rp ${grandTotal.toLocaleString('id-ID')})`,
                confirmButtonColor: '#ff6b9d',
                background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
                color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
            });
            return;
        }

        // Daftar produk
        let productList = '';
        const rows = document.querySelectorAll('.product-row');
        rows.forEach(row => {
            const select = row.querySelector('.product-select');
            const qtyInput = row.querySelector('.qty-input');
            const priceInput = row.querySelector('.price-input');
            if (select && select.value) {
                const name = select.options[select.selectedIndex].text.split('(')[0].trim();
                const qty = parseInt(qtyInput.value) || 0;
                const price = parseInt(priceInput.value) || 0;
                const subtotal = qty * price;
                productList += `<li>${name} x ${qty} = Rp ${subtotal.toLocaleString('id-ID')}</li>`;
            }
        });

        // Tampilkan konfirmasi
        Swal.fire({
            title: 'Konfirmasi Transaksi',
            html: `
                <div style="text-align: left; max-width: 400px; margin: 0 auto;">
                    <p><strong>Pelanggan:</strong> ${customerName}</p>
                    <p><strong>Metode Bayar:</strong> ${paymentMethod.toUpperCase()}</p>
                    <ul style="list-style: none; padding-left: 0;">${productList}</ul>
                    <hr>
                    <p><strong>Grand Total:</strong> Rp ${grandTotal.toLocaleString('id-ID')}</p>
                    <p><strong>Bayar:</strong> Rp ${paymentAmount.toLocaleString('id-ID')}</p>
                    <p><strong>Kembalian:</strong> Rp ${change.toLocaleString('id-ID')}</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ff6b9d',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Proses!',
            cancelButtonText: 'Batal',
            background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
            color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('saleForm').submit();
            }
        });
    });

    // ===== SCAN QR CODE (dengan validasi stok) =====
    const scanInput = document.getElementById('scan-input');
    const btnScanAdd = document.getElementById('btn-scan-add');

    function addProductByCode(code) {
        fetch(`/products/code/${code}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const product = data.product;
                    // Cek apakah produk sudah ada di keranjang
                    const rows = document.querySelectorAll('.product-row');
                    let found = false;
                    let currentQty = 0;
                    rows.forEach(row => {
                        const select = row.querySelector('.product-select');
                        if (select && select.value == product.id) {
                            const qtyInput = row.querySelector('.qty-input');
                            currentQty = parseInt(qtyInput.value) || 0;
                            const stock = parseInt(select.options[select.selectedIndex]?.dataset?.stock) || 0;
                            if (currentQty + 1 > stock) {
                                showToast(`Stok ${product.name} tidak cukup! (Stok: ${stock})`, 'danger');
                                found = true;
                                return;
                            }
                            qtyInput.value = currentQty + 1;
                            found = true;
                            calculateTotals();
                            showToast(`Jumlah ${product.name} ditambah!`, 'success');
                        }
                    });

                    if (!found) {
                        // Cek stok untuk produk baru
                        if (product.stock <= 0) {
                            showToast(`Stok ${product.name} habis!`, 'danger');
                            scanInput.value = '';
                            scanInput.focus();
                            return;
                        }
                        // Tambahkan baris baru
                        const container = document.getElementById('product-rows');
                        const newRow = document.createElement('div');
                        newRow.className = 'row g-2 mb-2 product-row';
                        const productOptions = document.querySelector('.product-row .product-select').innerHTML;
                        newRow.innerHTML = `
                            <div class="col-md-5">
                                <select name="products[${rowIndex}][product_id]" class="form-select product-select" required>
                                    ${productOptions}
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="products[${rowIndex}][quantity]" class="form-control qty-input" placeholder="Qty" required min="1" value="1">
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="products[${rowIndex}][price]" class="form-control price-input" placeholder="Harga Jual" required min="0" readonly>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-row">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        `;
                        container.appendChild(newRow);
                        rowIndex++;

                        const select = newRow.querySelector('.product-select');
                        select.value = product.id;
                        const priceInput = newRow.querySelector('.price-input');
                        priceInput.value = product.selling_price;

                        updateRemoveButtons();
                        calculateTotals();
                        showToast(`Produk ${product.name} ditambahkan!`, 'success');
                    }

                    scanInput.value = '';
                    scanInput.focus();
                } else {
                    showToast('Produk tidak ditemukan!', 'danger');
                    scanInput.focus();
                    scanInput.select();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan, coba lagi.', 'danger');
            });
    }

    scanInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const code = this.value.trim();
            if (code) addProductByCode(code);
        }
    });

    btnScanAdd.addEventListener('click', function() {
        const code = scanInput.value.trim();
        if (code) addProductByCode(code);
    });

    // ===== TOAST NOTIFICATION =====
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
        toast.style.zIndex = '9999';
        toast.style.maxWidth = '400px';
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // ===== EVENT LISTENER LAINNYA =====
    document.getElementById('product-rows').addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select')) {
            const row = e.target.closest('.product-row');
            const priceInput = row.querySelector('.price-input');
            const selectedOption = e.target.options[e.target.selectedIndex];
            if (selectedOption.value) {
                priceInput.value = selectedOption.dataset.price;
            } else {
                priceInput.value = '';
            }
            calculateTotals();
        }
    });

    document.getElementById('product-rows').addEventListener('input', function(e) {
        if (e.target.classList.contains('qty-input') || e.target.classList.contains('price-input')) {
            // Validasi stok saat qty berubah
            const row = e.target.closest('.product-row');
            if (e.target.classList.contains('qty-input') && row) {
                const select = row.querySelector('.product-select');
                if (select && select.value) {
                    const qty = parseInt(e.target.value) || 0;
                    const stock = parseInt(select.options[select.selectedIndex]?.dataset?.stock) || 0;
                    if (qty > stock) {
                        showToast(`Stok tidak cukup! Maksimal ${stock}`, 'danger');
                        e.target.value = stock;
                    }
                }
            }
            calculateTotals();
        }
    });

    document.getElementById('discount').addEventListener('input', calculateTotals);
    document.getElementById('tax').addEventListener('input', calculateTotals);
    document.getElementById('payment_amount').addEventListener('input', calculateTotals);

    document.getElementById('add-row').addEventListener('click', function() {
        const container = document.getElementById('product-rows');
        const newRow = document.createElement('div');
        newRow.className = 'row g-2 mb-2 product-row';
        newRow.innerHTML = `
            <div class="col-md-5">
                <select name="products[${rowIndex}][product_id]" class="form-select product-select" required>
                    <option value="">Pilih Produk</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}" data-stock="{{ $product->stock }}">
                            {{ $product->name }} ({{ $product->code }}) - Stok: {{ $product->stock }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="products[${rowIndex}][quantity]" class="form-control qty-input" placeholder="Qty" required min="1" value="1">
            </div>
            <div class="col-md-3">
                <input type="number" name="products[${rowIndex}][price]" class="form-control price-input" placeholder="Harga Jual" required min="0" readonly>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-row">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newRow);
        rowIndex++;
        updateRemoveButtons();
    });

    document.getElementById('product-rows').addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            const row = e.target.closest('.product-row');
            row.remove();
            updateRemoveButtons();
            calculateTotals();
        }
    });

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.product-row');
        rows.forEach((row, index) => {
            const btn = row.querySelector('.remove-row');
            if (rows.length > 1) {
                btn.style.display = 'inline-block';
            } else {
                btn.style.display = 'none';
            }
        });
    }

    function calculateTotals() {
        let subtotal = 0;
        const rows = document.querySelectorAll('.product-row');
        rows.forEach(row => {
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            subtotal += qty * price;
        });

        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const tax = parseFloat(document.getElementById('tax').value) || 0;
        const grandTotal = subtotal - discount + tax;

        document.getElementById('subtotal_display').value = formatRupiah(subtotal);
        document.getElementById('total_amount').value = subtotal;
        document.getElementById('grand_total_display').value = formatRupiah(grandTotal);
        document.getElementById('grand_total').value = grandTotal;

        const payment = parseFloat(document.getElementById('payment_amount').value) || 0;
        const change = payment - grandTotal;
        if (change >= 0) {
            document.getElementById('change_display').value = formatRupiah(change);
            document.getElementById('change_amount').value = change;
        } else {
            document.getElementById('change_display').value = 'Rp 0 (Kurang!)';
            document.getElementById('change_amount').value = 0;
        }
    }

    setTimeout(() => {
        updateRemoveButtons();
        calculateTotals();
    }, 100);
</script>
@endpush
@endsection