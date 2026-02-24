<?php

namespace App\Http\Controllers;

use App\Services\ImageCompressor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ImageUploadTestController extends Controller
{
    public function showForm()
    {
        return view('image-test.upload-form');
    }

    public function handleUpload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg,webp,gif|max:5000', // Max 5MB for testing
        ]);

        $imageCompressor = new ImageCompressor();
        $imagePath = $imageCompressor->compressImage($request->file('image'), 'test-compression');

        // Get the file size to verify compression worked
        $fullPath = Storage::disk('public')->path($imagePath);
        $fileSize = filesize($fullPath);
        $fileSizeKB = round($fileSize / 1024, 2);

        return redirect()->back()->with([
            'success' => 'Image uploaded and compressed successfully!',
            'image_path' => '/storage/' . $imagePath,
            'file_size_kb' => $fileSizeKB
        ]);
    }
}