<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Image Compression Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-center mb-6">Image Compression Test</h1>
        
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
                @if(session('image_path'))
                    <p><strong>Image path:</strong> {{ session('image_path') }}</p>
                    <p><strong>File size:</strong> {{ session('file_size_kb') }} KB</p>
                    <div class="mt-2">
                        <img src="{{ session('image_path') }}" alt="Compressed Image" class="max-w-full h-auto rounded">
                    </div>
                @endif
            </div>
        @endif
        
        <form action="{{ route('test-image-compression') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Select Image</label>
                <input type="file" name="image" id="image" accept="image/*" required 
                       class="block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-600 file:text-white
                              hover:file:bg-blue-700">
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">
                Upload and Compress
            </button>
        </form>
        
        <div class="mt-6 text-sm text-gray-600">
            <p><strong>Note:</strong> All uploaded images will be compressed to a maximum of 100KB.</p>
        </div>
    </div>
</body>
</html>