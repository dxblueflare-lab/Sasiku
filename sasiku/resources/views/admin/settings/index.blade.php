@extends('layouts.admin', ['title' => 'Pengaturan | SASIKU Admin', 'header' => 'Pengaturan'])

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Site Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold mb-6 flex items-center space-x-2">
                <i data-lucide="globe" class="w-5 h-5 text-purple-600"></i>
                <span>Pengaturan Situs</span>
            </h3>

            <div class="space-y-4">
                <div>
                    <label for="site_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Situs</label>
                    <input
                        type="text"
                        name="site_name"
                        id="site_name"
                        value="{{ old('site_name', $settings['site_name']) }}"
                        required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                    >
                </div>

                <div>
                    <label for="site_description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Situs</label>
                    <textarea
                        name="site_description"
                        id="site_description"
                        rows="3"
                        required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                    >{{ old('site_description', $settings['site_description']) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Contact Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold mb-6 flex items-center space-x-2">
                <i data-lucide="mail" class="w-5 h-5 text-purple-600"></i>
                <span>Informasi Kontak</span>
            </h3>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="contact_email" class="block text-sm font-semibold text-gray-700 mb-2">Email Kontak</label>
                    <input
                        type="email"
                        name="contact_email"
                        id="contact_email"
                        value="{{ old('contact_email', $settings['contact_email']) }}"
                        required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                    >
                </div>

                <div>
                    <label for="contact_phone" class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
                    <input
                        type="text"
                        name="contact_phone"
                        id="contact_phone"
                        value="{{ old('contact_phone', $settings['contact_phone']) }}"
                        required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                    >
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold mb-6 flex items-center space-x-2">
                <i data-lucide="share-2" class="w-5 h-5 text-purple-600"></i>
                <span>Media Sosial</span>
            </h3>

            <div class="space-y-4">
                <div>
                    <label for="social_facebook" class="block text-sm font-semibold text-gray-700 mb-2">Facebook</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">facebook.com/</span>
                        <input
                            type="text"
                            name="social_facebook"
                            id="social_facebook"
                            value="{{ old('social_facebook', $settings['social_facebook']) }}"
                            class="w-full pl-24 pr-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                            placeholder="username"
                        >
                    </div>
                </div>

                <div>
                    <label for="social_instagram" class="block text-sm font-semibold text-gray-700 mb-2">Instagram</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">instagram.com/</span>
                        <input
                            type="text"
                            name="social_instagram"
                            id="social_instagram"
                            value="{{ old('social_instagram', $settings['social_instagram']) }}"
                            class="w-full pl-28 pr-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                            placeholder="username"
                        >
                    </div>
                </div>

                <div>
                    <label for="social_twitter" class="block text-sm font-semibold text-gray-700 mb-2">Twitter / X</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">x.com/</span>
                        <input
                            type="text"
                            name="social_twitter"
                            id="social_twitter"
                            value="{{ old('social_twitter', $settings['social_twitter']) }}"
                            class="w-full pl-16 pr-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                            placeholder="username"
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl hover:shadow-lg transition-all">
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@append
