/**
 * Utility functions for handling image uploads and processing
 */

/**
 * Convert image file to base64 string
 */
export const convertImageToBase64 = (file: File): Promise<string> => {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onloadend = () => {
      if (typeof reader.result === 'string') {
        resolve(reader.result);
      } else {
        reject(new Error('Failed to convert image to base64'));
      }
    };
    reader.onerror = () => {
      reject(new Error('Error reading image file'));
    };
    reader.readAsDataURL(file);
  });
};

/**
 * Validate image file
 */
export const validateImageFile = (file: File): { isValid: boolean; error?: string } => {
  // Check file type
  if (!file.type.match('image.*')) {
    return { 
      isValid: false, 
      error: 'Format file tidak didukung. Harap pilih file gambar (JPEG, PNG, GIF, dll).' 
    };
  }

  // Check file size (max 5MB)
  if (file.size > 5 * 1024 * 1024) {
    return { 
      isValid: false, 
      error: 'Ukuran file terlalu besar. Maksimal 5MB.' 
    };
  }

  return { isValid: true };
};

/**
 * Resize image to optimize for display
 */
export const resizeImage = (dataUrl: string, maxWidth: number = 800, maxHeight: number = 600): Promise<string> => {
  return new Promise((resolve, reject) => {
    const img = new Image();
    img.onload = () => {
      // Calculate new dimensions maintaining aspect ratio
      let { width, height } = img;
      if (width > maxWidth) {
        height *= maxWidth / width;
        width = maxWidth;
      }
      if (height > maxHeight) {
        width *= maxHeight / height;
        height = maxHeight;
      }

      // Create canvas and draw resized image
      const canvas = document.createElement('canvas');
      canvas.width = width;
      canvas.height = height;
      const ctx = canvas.getContext('2d');
      if (!ctx) {
        reject(new Error('Could not get canvas context'));
        return;
      }
      
      ctx.drawImage(img, 0, 0, width, height);
      
      // Convert back to data URL
      const resizedDataUrl = canvas.toDataURL('image/jpeg', 0.8);
      resolve(resizedDataUrl);
    };
    img.onerror = () => {
      reject(new Error('Could not load image for resizing'));
    };
    img.src = dataUrl;
  });
};