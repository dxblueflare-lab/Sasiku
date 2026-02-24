// Types for SPPG Distribution Monitoring System

export interface Agent {
  id: string;
  nama: string;
  alamat: string;
  koordinat: {
    lat: number;
    lng: number;
  };
  coverage: string[];
  kapasitas: string;
  armada: number;
  status: 'Aktif' | 'Nonaktif' | 'Maintenance';
  telepon?: string;
  penanggungJawab?: string;
}

export interface Driver {
  id: string;
  nama: string;
  noTelepon: string;
  platNomor: string;
  jenisKendaraan: string;
  kapasitasKendaraan: number;
  status: 'Tersedia' | 'Sedang Mengantar' | 'Istirahat' | 'Maintenance';
  lokasi?: {
    lat: number;
    lng: number;
  };
  agenId: string;
  rating: number;
  totalPengiriman: number;
}

export interface Pesantren {
  id: string;
  no: number;
  nama: string;
  yayasan: string;
  desa: string;
  kecamatan: string;
  kabupaten: string;
  koordinat?: {
    lat: number;
    lng: number;
  };
  beroperasi: boolean;
  jumlahRelawan: number;
  jumlahPenerimaManfaat: number;
  zona?: number;
  status: 'Aktif' | 'Belum Beroperasi' | 'Maintenance';
}

export interface Pengiriman {
  id: string;
  kodePengiriman: string;
  driverId: string;
  driver?: Driver;
  agenId: string;
  agen?: Agent;
  pesantrenId: string;
  pesantren?: Pesantren;
  jumlahPorsi: number;
  menu: string[];
  tanggalKirim: string;
  waktuBerangkat?: string;
  waktuSampai?: string;
  status: 'Menunggu' | 'Dalam Perjalanan' | 'Sampai Tujuan' | 'Selesai' | 'Dibatalkan';
  keterangan?: string;
  buktiPengiriman?: string[];
  rating?: number;
  feedback?: string;
  rute: RutePoint[];
  estimasiWaktu: number; // dalam menit
  jarak: number; // dalam km
}

export interface RutePoint {
  lat: number;
  lng: number;
  timestamp: string;
  kecepatan?: number;
}

export interface Laporan {
  id: string;
  jenis: 'harian' | 'mingguan' | 'bulanan';
  periode: string;
  totalPengiriman: number;
  totalPorsi: number;
  totalPesantrenTerlayani: number;
  totalDriverAktif: number;
  rataRataWaktuPengiriman: number;
  tingkatKepuasan: number;
  detailPengiriman: Pengiriman[];
  createdAt: string;
}

export interface Notifikasi {
  id: string;
  judul: string;
  pesan: string;
  tipe: 'info' | 'warning' | 'success' | 'error';
  timestamp: string;
  dibaca: boolean;
  relatedId?: string;
  relatedType?: 'pengiriman' | 'driver' | 'pesantren';
}

export interface DashboardStats {
  totalPengirimanHariIni: number;
  totalPorsiHariIni: number;
  driverAktif: number;
  driverTotal: number;
  pesantrenTerlayani: number;
  pesantrenTotal: number;
  pengirimanDalamPerjalanan: number;
  pengirimanSelesai: number;
  rataRataWaktuPengiriman: number;
  tingkatKepuasan: number;
}
