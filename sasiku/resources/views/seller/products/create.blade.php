@extends('layouts.seller', ['title' => 'Tambah Produk | SASIKU', 'header' => 'Tambah Produk Baru'])

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
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
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none"
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
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none"
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
                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Harga Diskon</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                        <input
                            type="number"
                            name="price"
                            id="price"
                            value="{{ old('price') }}"
                            required
                            class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none"
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
                            class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none"
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
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none"
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
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none"
                    >
                        <option value="kg" selected>Kilogram (kg)</option>
                        <option value="gram">Gram</option>
                        <option value="ons">Ons</option>
                        <option value="liter">Liter</option>
                        <option value="ml">Mililiter</option>
                        <option value="pcs">Pcs</option>
                        <option value="ikat">Ikat</option>
                        <option value="bunch">Bunch</option>
                        <option value="pack">Pack</option>
						<option value="Galon">Galon</option>
						<option value="tangkai">Tangkai</option>
                    </select>
                    @error('unit')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Gambar Produk</label>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-purple-400 transition-colors relative overflow-hidden">
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
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none"
                    placeholder="Deskripsi produk..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            
            <!-- Active Status -->
            <div>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ !old('is_active') ? 'checked' : '' }} class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500">
                    <span class="text-sm font-medium text-gray-700">Tampilkan produk (Aktif)</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100">
                <a href="{{ route('seller.products') }}" class="px-6 py-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors">
                    Simpan Produk
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
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
</script>
@endpush
@endsection
