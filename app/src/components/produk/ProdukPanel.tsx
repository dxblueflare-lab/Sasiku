import { useState, useRef, ChangeEvent } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Badge } from '@/components/ui/badge';
import { 
  Plus, 
  Image as ImageIcon, 
  Package, 
  Utensils, 
  Trash2, 
  Eye,
  AlertCircle,
  Loader2
} from 'lucide-react';

interface Produk {
  id: string;
  nama: string;
  deskripsi: string;
  harga: number;
  kategori: string;
  gambar: string | null;
  tanggalDibuat: string;
}

export default function ProdukPanel() {
  const [produkList, setProdukList] = useState<Produk[]>([]);
  const [formData, setFormData] = useState({
    nama: '',
    deskripsi: '',
    harga: 0,
    kategori: ''
  });
  const [gambarPreview, setGambarPreview] = useState<string | null>(null);
  const [gambarFile, setGambarFile] = useState<File | null>(null);
  const [uploadError, setUploadError] = useState<string | null>(null);
  const [isProcessing, setIsProcessing] = useState(false);
  const fileInputRef = useRef<HTMLInputElement>(null);

  const handleInputChange = (e: ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: name === 'harga' ? Number(value) : value
    }));
  };

  const handleImageChange = (e: ChangeEvent<HTMLInputElement>) => {
    setUploadError(null); // Reset error
    
    if (e.target.files && e.target.files[0]) {
      const file = e.target.files[0];
      
      // Validasi ukuran file (maksimal 5MB)
      if (file.size > 5 * 1024 * 1024) {
        setUploadError('Ukuran file terlalu besar. Maksimal 5MB.');
        return;
      }
      
      // Validasi tipe file
      if (!file.type.match('image.*')) {
        setUploadError('Format file tidak didukung. Harap pilih file gambar.');
        return;
      }
      
      setGambarFile(file);
      
      // Create preview
      const reader = new FileReader();
      reader.onloadend = () => {
        setGambarPreview(reader.result as string);
      };
      reader.onerror = () => {
        setUploadError('Gagal membaca file gambar.');
      };
      reader.readAsDataURL(file);
    }
  };

  const triggerFileInput = () => {
    if (fileInputRef.current) {
      fileInputRef.current.click();
    }
  };

  const removeImage = () => {
    setGambarPreview(null);
    setGambarFile(null);
    setUploadError(null);
    if (fileInputRef.current) {
      fileInputRef.current.value = '';
    }
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    // Validasi form
    if (!formData.nama.trim()) {
      setUploadError('Nama menu wajib diisi.');
      return;
    }
    
    if (!gambarFile) {
      setUploadError('Gambar menu wajib diupload.');
      return;
    }
    
    setIsProcessing(true);
    try {
      const newProduk: Produk = {
        id: `PRD${Date.now()}`,
        nama: formData.nama,
        deskripsi: formData.deskripsi,
        harga: formData.harga,
        kategori: formData.kategori || 'Umum',
        gambar: gambarPreview,
        tanggalDibuat: new Date().toISOString()
      };

      setProdukList(prev => [...prev, newProduk]);
      
      // Reset form
      setFormData({
        nama: '',
        deskripsi: '',
        harga: 0,
        kategori: ''
      });
      setGambarPreview(null);
      setGambarFile(null);
      setUploadError(null);
      if (fileInputRef.current) {
        fileInputRef.current.value = '';
      }
    } catch (error) {
      console.error('Error submitting product:', error);
      setUploadError('Gagal menambahkan menu. Silakan coba lagi.');
    } finally {
      setIsProcessing(false);
    }
  };

  const handleDeleteProduk = (id: string) => {
    setProdukList(prev => prev.filter(produk => produk.id !== id));
  };

  return (
    <div className="space-y-6 animate-in fade-in duration-500">
      {/* Header */}
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-bold">Manajemen Menu Makanan</h1>
          <p className="text-muted-foreground">
            Kelola menu makanan yang akan didistribusikan ke pondok pesantren
          </p>
        </div>
        <Button className="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800">
          <Package className="h-4 w-4 mr-2" />
          Ekspor Data
        </Button>
      </div>

      {/* Form Upload Produk */}
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center gap-2">
            <Plus className="h-5 w-5 text-blue-600" />
            Tambah Menu Makanan Baru
          </CardTitle>
        </CardHeader>
        <CardContent>
          <form onSubmit={handleSubmit} className="space-y-6">
            {uploadError && (
              <div className="flex items-center gap-2 p-3 bg-red-50 border border-red-200 rounded-md text-red-700">
                <AlertCircle className="h-4 w-4" />
                <span>{uploadError}</span>
              </div>
            )}
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div className="space-y-2">
                <Label htmlFor="nama">Nama Menu *</Label>
                <Input
                  id="nama"
                  name="nama"
                  value={formData.nama}
                  onChange={handleInputChange}
                  placeholder="Contoh: Nasi Goreng Spesial"
                  required
                />
              </div>
              
              <div className="space-y-2">
                <Label htmlFor="kategori">Kategori</Label>
                <Input
                  id="kategori"
                  name="kategori"
                  value={formData.kategori}
                  onChange={handleInputChange}
                  placeholder="Contoh: Makanan Pokok, Lauk Pauk, Sayuran"
                />
              </div>
              
              <div className="space-y-2">
                <Label htmlFor="harga">Harga/Kapasitas</Label>
                <Input
                  id="harga"
                  name="harga"
                  type="number"
                  value={formData.harga}
                  onChange={handleInputChange}
                  placeholder="Jumlah porsi atau harga"
                />
              </div>
              
              <div className="space-y-2">
                <Label htmlFor="gambar">Gambar Menu *</Label>
                <div className="flex items-center gap-4">
                  <Button
                    type="button"
                    onClick={triggerFileInput}
                    variant="outline"
                    className="flex items-center gap-2"
                    disabled={isProcessing}
                  >
                    {isProcessing ? (
                      <>
                        <Loader2 className="h-4 w-4 animate-spin" />
                        Memproses...
                      </>
                    ) : (
                      <>
                        <ImageIcon className="h-4 w-4" />
                        Pilih Gambar
                      </>
                    )}
                  </Button>
                  <input
                    type="file"
                    ref={fileInputRef}
                    onChange={handleImageChange}
                    accept="image/*"
                    className="hidden"
                    disabled={isProcessing}
                  />
                  {gambarPreview && (
                    <Button
                      type="button"
                      onClick={removeImage}
                      variant="outline"
                      size="sm"
                      className="text-red-600 hover:text-red-700"
                      disabled={isProcessing}
                    >
                      <Trash2 className="h-4 w-4" />
                    </Button>
                  )}
                </div>
                
                {gambarPreview && (
                  <div className="mt-2">
                    <Label>Pratinjau Gambar:</Label>
                    <div className="mt-2 border rounded-lg p-2 inline-block bg-white">
                      <img 
                        src={gambarPreview} 
                        alt="Pratinjau menu" 
                        className="max-h-40 object-contain"
                        onError={(e) => {
                          console.error('Gagal memuat gambar:', e);
                        }}
                      />
                    </div>
                  </div>
                )}
              </div>
            </div>
            
            <div className="space-y-2">
              <Label htmlFor="deskripsi">Deskripsi</Label>
              <Textarea
                id="deskripsi"
                name="deskripsi"
                value={formData.deskripsi}
                onChange={handleInputChange}
                placeholder="Deskripsikan menu makanan ini..."
                rows={3}
              />
            </div>
            
            <div className="flex justify-end">
              <Button 
                type="submit" 
                className="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800"
                disabled={isProcessing}
              >
                {isProcessing ? (
                  <>
                    <Loader2 className="h-4 w-4 mr-2 animate-spin" />
                    Memproses...
                  </>
                ) : (
                  <>
                    <Plus className="h-4 w-4 mr-2" />
                    Tambah Menu
                  </>
                )}
              </Button>
            </div>
          </form>
        </CardContent>
      </Card>

      {/* Daftar Produk */}
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center gap-2">
            <Package className="h-5 w-5 text-blue-600" />
            Daftar Menu Makanan
            <Badge variant="secondary" className="ml-2">
              {produkList.length} item
            </Badge>
          </CardTitle>
        </CardHeader>
        <CardContent>
          {produkList.length === 0 ? (
            <div className="text-center py-10 text-muted-foreground">
              <Package className="h-12 w-12 mx-auto mb-3 opacity-50" />
              <p>Belum ada menu makanan yang ditambahkan</p>
              <p className="text-sm">Tambahkan menu pertama Anda menggunakan formulir di atas</p>
            </div>
          ) : (
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              {produkList.map((produk) => (
                <Card key={produk.id} className="overflow-hidden">
                  <div className="relative">
                    {produk.gambar ? (
                      <img 
                        src={produk.gambar} 
                        alt={produk.nama} 
                        className="w-full h-48 object-cover"
                        onError={(e) => {
                          console.error(`Gagal memuat gambar untuk produk ${produk.nama}:`, e);
                          // Ganti dengan placeholder jika gambar gagal dimuat
                          (e.target as HTMLImageElement).src = `data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 24 24" fill="none" stroke="%239ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>`;
                        }}
                        onLoad={(e) => {
                          // Gambar berhasil dimuat
                          console.log(`Gambar untuk produk ${produk.nama} berhasil dimuat`);
                        }}
                      />
                    ) : (
                      <div className="w-full h-48 bg-gray-100 flex items-center justify-center">
                        <ImageIcon className="h-12 w-12 text-gray-400" />
                      </div>
                    )}
                    <div className="absolute top-2 right-2 flex gap-1">
                      <Button size="sm" variant="secondary" className="opacity-90 hover:opacity-100">
                        <Eye className="h-4 w-4" />
                      </Button>
                      <Button 
                        size="sm" 
                        variant="destructive" 
                        onClick={() => handleDeleteProduk(produk.id)}
                        className="opacity-90 hover:opacity-100"
                      >
                        <Trash2 className="h-4 w-4" />
                      </Button>
                    </div>
                  </div>
                  
                  <CardContent className="p-4">
                    <div className="flex justify-between items-start">
                      <h3 className="font-semibold text-lg truncate">{produk.nama}</h3>
                      <Badge variant="outline">{produk.kategori}</Badge>
                    </div>
                    
                    <p className="text-sm text-muted-foreground mt-1 line-clamp-2">
                      {produk.deskripsi}
                    </p>
                    
                    <div className="mt-3 flex justify-between items-center">
                      <span className="font-medium">
                        {produk.harga > 0 ? `Rp ${produk.harga.toLocaleString()}` : 'Gratis'}
                      </span>
                      <span className="text-xs text-muted-foreground">
                        {new Date(produk.tanggalDibuat).toLocaleDateString('id-ID')}
                      </span>
                    </div>
                  </CardContent>
                </Card>
              ))}
            </div>
          )}
        </CardContent>
      </Card>
    </div>
  );
}