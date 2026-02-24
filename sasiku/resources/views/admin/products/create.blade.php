@extends('layouts.admin', ['title' => 'Tambah Produk | SASIKU Admin', 'header' => 'Tambah Produk Baru'])

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @csrf

        <div class="space-y-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                    placeholder="Contoh: Tomat Segar"
                >
                @error('name')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                <select
                    name="category_id"
                    id="category_id"
                    required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                >
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price & Original Price -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Harga</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                        <input
                            type="number"
                            name="price"
                            id="price"
                            value="{{ old('price') }}"
                            required
                            class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                            placeholder="0"
                            min="0"
                            step="1"
                        >
                    </div>
                    @error('price')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="original_price" class="block text-sm font-semibold text-gray-700 mb-2">Harga Asli (opsional)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                        <input
                            type="number"
                            name="original_price"
                            id="original_price"
                            value="{{ old('original_price') }}"
                            class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                            placeholder="0"
                            min="0"
                            step="1"
                        >
                    </div>
                    @error('original_price')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Stock & Unit -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">Stok</label>
                    <input
                        type="number"
                        name="stock"
                        id="stock"
                        value="{{ old('stock', 0) }}"
                        min="0"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                        placeholder="0"
                    >
                    @error('stock')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="unit" class="block text-sm font-semibold text-gray-700 mb-2">Satuan</label>
                    <select
                        name="unit"
                        id="unit"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                    >
                        <option value="kg" {{ old('unit') === 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                        <option value="gram" {{ old('unit') === 'gram' ? 'selected' : '' }}>Gram</option>
                        <option value="ons" {{ old('unit') === 'ons' ? 'selected' : '' }}>Ons</option>
                        <option value="liter" {{ old('unit') === 'liter' ? 'selected' : '' }}>Liter</option>
                        <option value="ml" {{ old('unit') === 'ml' ? 'selected' : '' }}>Mililiter</option>
                        <option value="pcs" {{ old('unit') === 'pcs' ? 'selected' : '' }}>Pcs</option>
                        <option value="ikat" {{ old('unit') === 'ikat' ? 'selected' : '' }}>Ikat</option>
                        <option value="bunch" {{ old('unit') === 'bunch' ? 'selected' : '' }}>Bunch</option>
                        <option value="pack" {{ old('unit') === 'pack' ? 'selected' : '' }}>Pack</option>
                    </select>
                    @error('unit')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Gambar Produk</label>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-violet-400 transition-colors relative overflow-hidden">
                    <input
                        type="file"
                        name="image"
                        id="image"
                        accept="image/png,image/jpg,image/jpeg,image/webp"
                        required
                        class="hidden"
                        onchange="previewImage(event)"
                    >
                    <label for="image" class="cursor-pointer">
                        <div id="imagePreview" class="hidden mb-4">
                            <img src="" alt="Preview" class="max-h-48 mx-auto rounded-lg object-cover w-full aspect-square">
                        </div>
                        <div id="uploadPlaceholder">
                            <i data-lucide="upload-cloud" class="w-12 h-12 text-gray-400 mx-auto mb-3"></i>
                            <p class="text-gray-600 font-medium">Klik untuk upload gambar</p>
                            <p class="text-gray-400 text-sm mt-1">Format: PNG, JPG, JPEG, WebP | Max: 2MB | Min: 100x100px</p>
                        </div>
                    </label>
                    <div id="loadingIndicator" class="hidden absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
                    </div>
                </div>
                @error('image')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                    placeholder="Deskripsi produk..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>


            <!-- Active Status -->
            <div>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ !old('is_active') ? 'checked' : '' }} class="w-5 h-5 text-violet-600 rounded focus:ring-violet-500">
                    <span class="text-sm font-medium text-gray-700">Tampilkan produk (Aktif)</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.products') }}" class="px-6 py-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl hover:shadow-lg transition-all">
                    Simpan Produk
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function formatRupiah(input) {
    // Remove all non-digit characters
    let value = input.value.replace(/\D/g, '');

    // Format as Rupiah
    let rupiah = '';
    let numberReverse = value.toString().split('').reverse().join('');

    for (let i = 0; i < numberReverse.length; i++) {
        if (i % 3 === 0) {
            rupiah += numberReverse.substr(i, 3) + '.';
        }
    }

    rupiah = rupiah.split('', rupiah.length - 1).reverse().join('');

    // Update input value
    input.value = rupiah;
}

function unformatRupiah(value) {
    // Remove all non-digit characters
    return value.replace(/\D/g, '');
}

function previewImage(event) {
    const file = event.target.files[0];
    const maxSize = 2 * 1366 * 768; // 2MB in bytes
    const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];

    if (file) {
        // Validate file type
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung. Gunakan PNG, JPG, JPEG, atau WebP.');
            event.target.value = '';
            return;
        }

        // Validate file size
        if (file.size > maxSize) {
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            event.target.value = '';
            return;
        }

        // Show loading indicator
        document.getElementById('loadingIndicator').classList.remove('hidden');

        const reader = new FileReader();
        reader.onload = function(e) {
            // Hide loading indicator
            document.getElementById('loadingIndicator').classList.add('hidden');

            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('uploadPlaceholder').classList.add('hidden');
            document.querySelector('#imagePreview img').src = e.target.result;
        }
        reader.onerror = function() {
            // Hide loading indicator on error
            document.getElementById('loadingIndicator').classList.add('hidden');
            alert('Terjadi kesalahan saat memuat gambar.');
        }
        reader.readAsDataURL(file);
    }
}

function toggleIngredientFields(ingredientId) {
    const checkbox = document.getElementById('ingredient_' + ingredientId);
    const fieldsContainer = document.getElementById('ingredient_fields_' + ingredientId);

    if (checkbox.checked) {
        fieldsContainer.classList.remove('hidden');
    } else {
        fieldsContainer.classList.add('hidden');
    }
}

// Clean price values before form submission
document.querySelector('form').addEventListener('submit', function(e) {
    const priceInput = document.getElementById('price');
    const originalPriceInput = document.getElementById('original_price');
    
    if (priceInput) {
        priceInput.value = unformatRupiah(priceInput.value);
    }
    
    if (originalPriceInput) {
        originalPriceInput.value = unformatRupiah(originalPriceInput.value);
    }
});
</script>
@endsection
