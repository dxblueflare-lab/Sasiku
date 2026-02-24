import { ImageIcon } from 'lucide-react';

interface ImagePlaceholderProps {
  size?: 'sm' | 'md' | 'lg';
  message?: string;
}

const ImagePlaceholder = ({ size = 'md', message = 'Gambar tidak tersedia' }: ImagePlaceholderProps) => {
  const sizeClasses = {
    sm: 'w-16 h-16',
    md: 'w-24 h-24',
    lg: 'w-32 h-32'
  };

  return (
    <div className={`flex flex-col items-center justify-center bg-gray-100 ${sizeClasses[size]} rounded-lg`}>
      <ImageIcon className="w-1/3 h-1/3 text-gray-400" />
      <span className="text-xs text-gray-500 mt-1 text-center">{message}</span>
    </div>
  );
};

export default ImagePlaceholder;