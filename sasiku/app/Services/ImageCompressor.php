<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Encoders\GifEncoder;

class ImageCompressor
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Compress an image file to a maximum size of 100KB
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @return string Path to the compressed image
     */
    public function compressImage($file, $directory = 'temp')
    {
        $image = $this->manager->read($file);

        // Determine the extension - fallback to mime type if extension isn't available
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension());

        // Handle webp separately as it has different compression characteristics
        if ($extension === 'webp') {
            return $this->compressWebP($image, $file, $directory);
        }

        // For other formats (jpg, png, gif)
        return $this->compressStandardImage($image, $file, $directory, $extension);
    }

    /**
     * Get the appropriate encoder based on extension and quality
     */
    private function getEncoder($extension, $quality = 85)
    {
        switch (strtolower($extension)) {
            case 'jpg':
            case 'jpeg':
                return new JpegEncoder($quality);
            case 'png':
                return new PngEncoder($quality);
            case 'gif':
                return new GifEncoder($quality);
            case 'webp':
                return new WebpEncoder($quality);
            default:
                return new JpegEncoder($quality); // Default to jpeg
        }
    }

    /**
     * Compress standard images (jpg, png, gif)
     */
    private function compressStandardImage($image, $file, $directory, $extension)
    {
        // Get the original size
        $originalSize = $file->getSize();

        // If the original is already under 100KB, try to save it as is but with some optimization
        if ($originalSize <= 100 * 1024) {
            // Try to optimize the image slightly even if under limit
            $encoder = $this->getEncoder($extension, 85);
            $optimizedImage = $image->encode($encoder);
            $size = strlen($optimizedImage->toString());

            if ($size <= 100 * 1024) {
                $filename = time() . '_' . uniqid() . '.' . $extension;
                Storage::disk('public')->put($directory . '/' . $filename, $optimizedImage->toString());
                return $directory . '/' . $filename;
            }
        }

        // Start with high quality and progressively reduce until under 100KB
        $quality = 90;
        $compressedImagePath = null;

        // Try quality reduction first
        while ($quality >= 10) {
            $encoder = $this->getEncoder($extension, $quality);
            $encodedImage = $image->encode($encoder);
            $size = strlen($encodedImage->toString());

            if ($size <= 100 * 1024) {
                $filename = time() . '_' . uniqid() . '.' . $extension;
                Storage::disk('public')->put($directory . '/' . $filename, $encodedImage->toString());
                return $directory . '/' . $filename;
            }

            $quality -= 5; // Reduce in smaller steps for better precision
        }

        // If quality reduction wasn't enough, try resizing
        $resizeFactors = [0.8, 0.7, 0.6, 0.5, 0.4];

        foreach ($resizeFactors as $factor) {
            $width = (int) ($image->width() * $factor);
            $height = (int) ($image->height() * $factor);

            $resizedImage = $image->scaleDown($width, $height);

            // Try different qualities with the resized image
            $quality = 85;
            while ($quality >= 10) {
                $encoder = $this->getEncoder($extension, $quality);
                $encodedImage = $resizedImage->encode($encoder);
                $size = strlen($encodedImage->toString());

                if ($size <= 100 * 1024) {
                    $filename = time() . '_' . uniqid() . '.' . $extension;
                    Storage::disk('public')->put($directory . '/' . $filename, $encodedImage->toString());
                    return $directory . '/' . $filename;
                }

                $quality -= 5;
            }
        }

        // If still too big, force a small size with lowest quality
        $finalImage = $image->scaleDown(800, 600);
        $encoder = $this->getEncoder($extension, 10);
        $encodedImage = $finalImage->encode($encoder);

        $filename = time() . '_' . uniqid() . '.' . $extension;
        Storage::disk('public')->put($directory . '/' . $filename, $encodedImage->toString());
        return $directory . '/' . $filename;
    }

    /**
     * Compress WebP images specially
     */
    private function compressWebP($image, $file, $directory)
    {
        // WebP generally has better compression, so we can be less aggressive
        $quality = 85;
        $compressedImagePath = null;

        while ($quality >= 20) {
            $encoder = $this->getEncoder('webp', $quality);
            $encodedImage = $image->encode($encoder);
            $size = strlen($encodedImage->toString());

            if ($size <= 100 * 1024) {
                $filename = time() . '_' . uniqid() . '.webp';
                Storage::disk('public')->put($directory . '/' . $filename, $encodedImage->toString());
                return $directory . '/' . $filename;
            }

            $quality -= 5;
        }

        // If still too big, resize
        $resizeFactors = [0.8, 0.7, 0.6, 0.5];

        foreach ($resizeFactors as $factor) {
            $width = (int) ($image->width() * $factor);
            $height = (int) ($image->height() * $factor);

            $resizedImage = $image->scaleDown($width, $height);

            $quality = 80;
            while ($quality >= 10) {
                $encoder = $this->getEncoder('webp', $quality);
                $encodedImage = $resizedImage->encode($encoder);
                $size = strlen($encodedImage->toString());

                if ($size <= 100 * 1024) {
                    $filename = time() . '_' . uniqid() . '.webp';
                    Storage::disk('public')->put($directory . '/' . $filename, $encodedImage->toString());
                    return $directory . '/' . $filename;
                }

                $quality -= 5;
            }
        }

        // Force smallest size if still too big
        $finalImage = $image->scaleDown(800, 600);
        $encoder = $this->getEncoder('webp', 10);
        $encodedImage = $finalImage->encode($encoder);

        $filename = time() . '_' . uniqid() . '.webp';
        Storage::disk('public')->put($directory . '/' . $filename, $encodedImage->toString());
        return $directory . '/' . $filename;
    }
}