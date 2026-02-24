import type { Driver, Pesantren, Pengiriman, Notifikasi, DashboardStats } from '@/types';
import { agents, getAgentById } from './agentsData';

export { agents, getAgentById };

// Generate 40 drivers (2-3 per agent)
export const drivers: Driver[] = [
  // AGN-SBY-01
  { id: 'DRV001', nama: 'Ahmad Subandi', noTelepon: '081234567001', platNomor: 'L 1001 AB', jenisKendaraan: 'Pickup', kapasitasKendaraan: 500, status: 'Sedang Mengantar', lokasi: { lat: -7.2000, lng: 112.6800 }, agenId: 'AGN-SBY-01', rating: 4.8, totalPengiriman: 156 },
  { id: 'DRV002', nama: 'Budi Santoso', noTelepon: '081234567002', platNomor: 'L 1002 CD', jenisKendaraan: 'Elf', kapasitasKendaraan: 800, status: 'Tersedia', lokasi: { lat: -7.1800, lng: 112.6600 }, agenId: 'AGN-SBY-01', rating: 4.9, totalPengiriman: 203 },
  { id: 'DRV003', nama: 'Candra Wijaya', noTelepon: '081234567003', platNomor: 'L 1003 EF', jenisKendaraan: 'Pickup', kapasitasKendaraan: 600, status: 'Tersedia', lokasi: { lat: -7.2200, lng: 112.7000 }, agenId: 'AGN-SBY-01', rating: 4.7, totalPengiriman: 178 },
  
  // AGN-SBY-02
  { id: 'DRV004', nama: 'Dedi Kurniawan', noTelepon: '081234567004', platNomor: 'L 1004 GH', jenisKendaraan: 'Elf', kapasitasKendaraan: 1000, status: 'Sedang Mengantar', lokasi: { lat: -7.4500, lng: 112.7200 }, agenId: 'AGN-SBY-02', rating: 4.6, totalPengiriman: 134 },
  { id: 'DRV005', nama: 'Eko Prasetyo', noTelepon: '081234567005', platNomor: 'L 1005 IJ', jenisKendaraan: 'Pickup', kapasitasKendaraan: 550, status: 'Sedang Mengantar', lokasi: { lat: -7.4800, lng: 112.7500 }, agenId: 'AGN-SBY-02', rating: 4.9, totalPengiriman: 189 },
  { id: 'DRV006', nama: 'Fajar Nugroho', noTelepon: '081234567006', platNomor: 'L 1006 KL', jenisKendaraan: 'Pickup', kapasitasKendaraan: 500, status: 'Tersedia', lokasi: { lat: -7.4200, lng: 112.7000 }, agenId: 'AGN-SBY-02', rating: 4.5, totalPengiriman: 98 },
  
  // AGN-PSR-01
  { id: 'DRV007', nama: 'Guntur Wibowo', noTelepon: '081234567007', platNomor: 'N 1001 MN', jenisKendaraan: 'Pickup', kapasitasKendaraan: 600, status: 'Tersedia', lokasi: { lat: -7.6500, lng: 112.9000 }, agenId: 'AGN-PSR-01', rating: 4.8, totalPengiriman: 145 },
  { id: 'DRV008', nama: 'Hadi Sucipto', noTelepon: '081234567008', platNomor: 'N 1002 OP', jenisKendaraan: 'Elf', kapasitasKendaraan: 800, status: 'Tersedia', lokasi: { lat: -7.6300, lng: 112.8800 }, agenId: 'AGN-PSR-01', rating: 4.7, totalPengiriman: 167 },
  
  // AGN-PBL-01
  { id: 'DRV009', nama: 'Indra Gunawan', noTelepon: '081234567009', platNomor: 'P 1001 QR', jenisKendaraan: 'Pickup', kapasitasKendaraan: 500, status: 'Sedang Mengantar', lokasi: { lat: -7.7800, lng: 113.2000 }, agenId: 'AGN-PBL-01', rating: 4.9, totalPengiriman: 198 },
  { id: 'DRV010', nama: 'Joko Susilo', noTelepon: '081234567010', platNomor: 'P 1002 ST', jenisKendaraan: 'Elf', kapasitasKendaraan: 900, status: 'Tersedia', lokasi: { lat: -7.7600, lng: 113.1800 }, agenId: 'AGN-PBL-01', rating: 4.6, totalPengiriman: 145 },
  
  // AGN-MLG-01
  { id: 'DRV011', nama: 'Kusumo Adi', noTelepon: '081234567011', platNomor: 'N 2001 UV', jenisKendaraan: 'Truck Kecil', kapasitasKendaraan: 1200, status: 'Sedang Mengantar', lokasi: { lat: -7.9800, lng: 112.6300 }, agenId: 'AGN-MLG-01', rating: 4.8, totalPengiriman: 245 },
  { id: 'DRV012', nama: 'Lukman Hakim', noTelepon: '081234567012', platNomor: 'N 2002 WX', jenisKendaraan: 'Pickup', kapasitasKendaraan: 600, status: 'Tersedia', lokasi: { lat: -7.9500, lng: 112.6000 }, agenId: 'AGN-MLG-01', rating: 4.7, totalPengiriman: 167 },
  { id: 'DRV013', nama: 'Mulyono', noTelepon: '081234567013', platNomor: 'N 2003 YZ', jenisKendaraan: 'Elf', kapasitasKendaraan: 1000, status: 'Tersedia', lokasi: { lat: -7.9900, lng: 112.6500 }, agenId: 'AGN-MLG-01', rating: 4.9, totalPengiriman: 201 },
  
  // AGN-BLT-01
  { id: 'DRV014', nama: 'Nasiruddin', noTelepon: '081234567014', platNomor: 'N 3001 AA', jenisKendaraan: 'Pickup', kapasitasKendaraan: 500, status: 'Tersedia', lokasi: { lat: -8.1000, lng: 112.1600 }, agenId: 'AGN-BLT-01', rating: 4.6, totalPengiriman: 134 },
  { id: 'DRV015', nama: 'Oman Fathur', noTelepon: '081234567015', platNomor: 'N 3002 BB', jenisKendaraan: 'Elf', kapasitasKendaraan: 800, status: 'Tersedia', lokasi: { lat: -8.0800, lng: 112.1400 }, agenId: 'AGN-BLT-01', rating: 4.8, totalPengiriman: 156 },
  
  // AGN-JBR-01
  { id: 'DRV016', nama: 'Pandji Sakti', noTelepon: '081234567016', platNomor: 'J 1001 CC', jenisKendaraan: 'Truck Kecil', kapasitasKendaraan: 1100, status: 'Sedang Mengantar', lokasi: { lat: -8.1800, lng: 113.6800 }, agenId: 'AGN-JBR-01', rating: 4.9, totalPengiriman: 223 },
  { id: 'DRV017', nama: 'Qomaruddin', noTelepon: '081234567017', platNomor: 'J 1002 DD', jenisKendaraan: 'Pickup', kapasitasKendaraan: 600, status: 'Tersedia', lokasi: { lat: -8.1500, lng: 113.6500 }, agenId: 'AGN-JBR-01', rating: 4.7, totalPengiriman: 178 },
  { id: 'DRV018', nama: 'Rachmad Hidayat', noTelepon: '081234567018', platNomor: 'J 1003 EE', jenisKendaraan: 'Elf', kapasitasKendaraan: 900, status: 'Tersedia', lokasi: { lat: -8.2000, lng: 113.7200 }, agenId: 'AGN-JBR-01', rating: 4.8, totalPengiriman: 189 },
  
  // AGN-LMJ-01
  { id: 'DRV019', nama: 'Samsul Arifin', noTelepon: '081234567019', platNomor: 'J 2001 FF', jenisKendaraan: 'Pickup', kapasitasKendaraan: 550, status: 'Tersedia', lokasi: { lat: -8.1300, lng: 113.2000 }, agenId: 'AGN-LMJ-01', rating: 4.6, totalPengiriman: 145 },
  { id: 'DRV020', nama: 'Taufik Hidayat', noTelepon: '081234567020', platNomor: 'J 2002 GG', jenisKendaraan: 'Elf', kapasitasKendaraan: 850, status: 'Sedang Mengantar', lokasi: { lat: -8.1500, lng: 113.2200 }, agenId: 'AGN-LMJ-01', rating: 4.9, totalPengiriman: 198 },
  
  // AGN-BDW-01
  { id: 'DRV021', nama: 'Umar Fauzi', noTelepon: '081234567021', platNomor: 'S 1001 HH', jenisKendaraan: 'Pickup', kapasitasKendaraan: 600, status: 'Tersedia', lokasi: { lat: -7.9200, lng: 113.8000 }, agenId: 'AGN-BDW-01', rating: 4.7, totalPengiriman: 167 },
  { id: 'DRV022', nama: 'Vicky Pratama', noTelepon: '081234567022', platNomor: 'S 1002 II', jenisKendaraan: 'Elf', kapasitasKendaraan: 900, status: 'Tersedia', lokasi: { lat: -7.9000, lng: 113.7800 }, agenId: 'AGN-BDW-01', rating: 4.8, totalPengiriman: 189 },
  
  // AGN-STB-01
  { id: 'DRV023', nama: 'Wahyu Setiawan', noTelepon: '081234567023', platNomor: 'S 2001 JJ', jenisKendaraan: 'Pickup', kapasitasKendaraan: 550, status: 'Sedang Mengantar', lokasi: { lat: -7.7200, lng: 114.0000 }, agenId: 'AGN-STB-01', rating: 4.8, totalPengiriman: 178 },
  { id: 'DRV024', nama: 'Yusuf Maulana', noTelepon: '081234567024', platNomor: 'S 2002 KK', jenisKendaraan: 'Elf', kapasitasKendaraan: 850, status: 'Tersedia', lokasi: { lat: -7.6800, lng: 113.9800 }, agenId: 'AGN-STB-01', rating: 4.7, totalPengiriman: 156 },
  
  // AGN-BJN-01
  { id: 'DRV025', nama: 'Zainal Abidin', noTelepon: '081234567025', platNomor: 'B 1001 LL', jenisKendaraan: 'Pickup', kapasitasKendaraan: 600, status: 'Tersedia', lokasi: { lat: -7.1600, lng: 111.8800 }, agenId: 'AGN-BJN-01', rating: 4.6, totalPengiriman: 145 },
  { id: 'DRV026', nama: 'Abdul Rahman', noTelepon: '081234567026', platNomor: 'B 1002 MM', jenisKendaraan: 'Elf', kapasitasKendaraan: 800, status: 'Tersedia', lokasi: { lat: -7.1300, lng: 111.8500 }, agenId: 'AGN-BJN-01', rating: 4.8, totalPengiriman: 178 },
  
  // AGN-PON-01
  { id: 'DRV027', nama: 'Bambang Irawan', noTelepon: '081234567027', platNomor: 'AE 1001 NN', jenisKendaraan: 'Pickup', kapasitasKendaraan: 600, status: 'Sedang Mengantar', lokasi: { lat: -7.8800, lng: 111.4600 }, agenId: 'AGN-PON-01', rating: 4.9, totalPengiriman: 201 },
  { id: 'DRV028', nama: 'Darmawan', noTelepon: '081234567028', platNomor: 'AE 1002 OO', jenisKendaraan: 'Elf', kapasitasKendaraan: 900, status: 'Tersedia', lokasi: { lat: -7.8500, lng: 111.4300 }, agenId: 'AGN-PON-01', rating: 4.7, totalPengiriman: 167 },
  { id: 'DRV029', nama: 'Edi Supriyanto', noTelepon: '081234567029', platNomor: 'AE 1003 PP', jenisKendaraan: 'Truck Kecil', kapasitasKendaraan: 1100, status: 'Tersedia', lokasi: { lat: -7.9000, lng: 111.4900 }, agenId: 'AGN-PON-01', rating: 4.8, totalPengiriman: 189 },
  
  // AGN-WNS-01
  { id: 'DRV030', nama: 'Fathur Rozi', noTelepon: '081234567030', platNomor: 'R 1001 QQ', jenisKendaraan: 'Pickup', kapasitasKendaraan: 500, status: 'Tersedia', lokasi: { lat: -7.3700, lng: 109.9000 }, agenId: 'AGN-WNS-01', rating: 4.7, totalPengiriman: 134 },
  { id: 'DRV031', nama: 'Gatot Kaca', noTelepon: '081234567031', platNomor: 'R 1002 RR', jenisKendaraan: 'Elf', kapasitasKendaraan: 800, status: 'Tersedia', lokasi: { lat: -7.3500, lng: 109.8800 }, agenId: 'AGN-WNS-01', rating: 4.8, totalPengiriman: 156 },
  
  // AGN-BKL-01
  { id: 'DRV032', nama: 'Hamzah Fauzan', noTelepon: '081234567032', platNomor: 'M 1001 SS', jenisKendaraan: 'Pickup', kapasitasKendaraan: 600, status: 'Sedang Mengantar', lokasi: { lat: -7.0500, lng: 112.7400 }, agenId: 'AGN-BKL-01', rating: 4.8, totalPengiriman: 189 },
  { id: 'DRV033', nama: 'Irfan Hakim', noTelepon: '081234567033', platNomor: 'M 1002 TT', jenisKendaraan: 'Elf', kapasitasKendaraan: 900, status: 'Tersedia', lokasi: { lat: -7.0100, lng: 112.7200 }, agenId: 'AGN-BKL-01', rating: 4.7, totalPengiriman: 167 },
  { id: 'DRV034', nama: 'Jamaluddin', noTelepon: '081234567034', platNomor: 'M 1003 UU', jenisKendaraan: 'Truck Kecil', kapasitasKendaraan: 1200, status: 'Tersedia', lokasi: { lat: -7.0800, lng: 112.7600 }, agenId: 'AGN-BKL-01', rating: 4.9, totalPengiriman: 212 },
  
  // AGN-SPG-01
  { id: 'DRV035', nama: 'Khoirul Anam', noTelepon: '081234567035', platNomor: 'M 2001 VV', jenisKendaraan: 'Pickup', kapasitasKendaraan: 600, status: 'Tersedia', lokasi: { lat: -7.0600, lng: 113.2400 }, agenId: 'AGN-SPG-01', rating: 4.7, totalPengiriman: 178 },
  { id: 'DRV036', nama: 'Lutfi Hakim', noTelepon: '081234567036', platNomor: 'M 2002 WW', jenisKendaraan: 'Elf', kapasitasKendaraan: 900, status: 'Sedang Mengantar', lokasi: { lat: -7.0300, lng: 113.2200 }, agenId: 'AGN-SPG-01', rating: 4.8, totalPengiriman: 198 },
  { id: 'DRV037', nama: 'Mashudi', noTelepon: '081234567037', platNomor: 'M 2003 XX', jenisKendaraan: 'Truck Kecil', kapasitasKendaraan: 1100, status: 'Tersedia', lokasi: { lat: -7.0900, lng: 113.2600 }, agenId: 'AGN-SPG-01', rating: 4.6, totalPengiriman: 156 },
  
  // AGN-PMS-01
  { id: 'DRV038', nama: 'Nurul Huda', noTelepon: '081234567038', platNomor: 'M 3001 YY', jenisKendaraan: 'Truck Kecil', kapasitasKendaraan: 1300, status: 'Sedang Mengantar', lokasi: { lat: -7.1800, lng: 113.4500 }, agenId: 'AGN-PMS-01', rating: 4.9, totalPengiriman: 245 },
  { id: 'DRV039', nama: 'Oby Setiawan', noTelepon: '081234567039', platNomor: 'M 3002 ZZ', jenisKendaraan: 'Pickup', kapasitasKendaraan: 600, status: 'Tersedia', lokasi: { lat: -7.1400, lng: 113.4200 }, agenId: 'AGN-PMS-01', rating: 4.7, totalPengiriman: 178 },
  { id: 'DRV040', nama: 'Paryono', noTelepon: '081234567040', platNomor: 'M 3003 AAA', jenisKendaraan: 'Elf', kapasitasKendaraan: 1000, status: 'Tersedia', lokasi: { lat: -7.2000, lng: 113.4800 }, agenId: 'AGN-PMS-01', rating: 4.8, totalPengiriman: 201 },
];

// Sample pesantren data (20 representative)
export const pesantrenList: Pesantren[] = [
  { id: 'PSN001', no: 1, nama: 'YAY. DarunNajah', yayasan: 'YAY. DarunNajah', desa: 'Ploso', kecamatan: 'Ploso', kabupaten: 'Jombang', koordinat: { lat: -7.5000, lng: 112.4000 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 2839, zona: 4, status: 'Aktif' },
  { id: 'PSN002', no: 2, nama: 'Kalimasada', yayasan: 'Kalimasada', desa: 'Bangsri', kecamatan: 'Plandaan', kabupaten: 'Jombang', koordinat: { lat: -7.5200, lng: 112.4200 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 1003, zona: 4, status: 'Aktif' },
  { id: 'PSN003', no: 3, nama: 'YAY Riyadlatul Falah Wal Hikmah', yayasan: 'YAY Riyadlatul Falah Wal Hikmah', desa: 'Tondowulan', kecamatan: 'Plandaan', kabupaten: 'Jombang', koordinat: { lat: -7.5400, lng: 112.4400 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 2325, zona: 4, status: 'Aktif' },
  { id: 'PSN004', no: 5, nama: 'YAYASAN MIFTAHUL ULUM AL-YASINI', yayasan: 'YAYASAN MIFTAHUL ULUM AL-YASINI', desa: 'Sambisirah', kecamatan: 'Wonorejo', kabupaten: 'Pasuruan', koordinat: { lat: -7.6500, lng: 112.8500 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 2445, zona: 4, status: 'Aktif' },
  { id: 'PSN005', no: 6, nama: 'Yayasan Aqobah Jundul Jazil', yayasan: 'Yayasan Aqobah Jundul Jazil', desa: 'Kwaron', kecamatan: 'Diwek', kabupaten: 'Jombang', koordinat: { lat: -7.5800, lng: 112.3800 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 1778, zona: 4, status: 'Aktif' },
  { id: 'PSN006', no: 7, nama: 'Roudlotun Nasyiin', yayasan: 'Perkumpulan Pendidikan Dan Sosial Roudlotun Nasyiin', desa: 'Beratkulon', kecamatan: 'Kemlagi', kabupaten: 'Mojokerto', koordinat: { lat: -7.3800, lng: 112.5500 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 2649, status: 'Aktif' },
  { id: 'PSN007', no: 11, nama: 'Yayasan Nurul Ulum Blitar', yayasan: 'Yayasan Nurul Ulum Blitar', desa: 'Kedungbunder', kecamatan: 'Sutojayan', kabupaten: 'Blitar', koordinat: { lat: -8.1000, lng: 112.2000 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 2305, zona: 5, status: 'Aktif' },
  { id: 'PSN008', no: 12, nama: 'Pesantren Kh Mohamad Dawami', yayasan: 'Pesantren Kh Mohamad Dawami Nurhadi', desa: 'Plumpungrejo', kecamatan: 'Kademangan', kabupaten: 'Blitar', koordinat: { lat: -8.1200, lng: 112.2200 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 3200, zona: 5, status: 'Aktif' },
  { id: 'PSN009', no: 13, nama: 'Sunan Kalijogo', yayasan: 'Sunan Kalijogo', desa: 'Sukolilo', kecamatan: 'Jabung', kabupaten: 'Malang', koordinat: { lat: -8.0500, lng: 112.7500 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 2619, zona: 4, status: 'Aktif' },
  { id: 'PSN010', no: 14, nama: 'Ppai Al Aziz', yayasan: 'Ppai Al Aziz', desa: 'Amandanom', kecamatan: 'Dampit', kabupaten: 'Malang', koordinat: { lat: -8.2000, lng: 112.8000 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 2441, zona: 4, status: 'Aktif' },
  { id: 'PSN011', no: 19, nama: 'Yayasan Nurul Islam Al Muniri', yayasan: 'Yayasan Nurul Islam Al Muniri', desa: 'Sumbertlaseh', kecamatan: 'Dander', kabupaten: 'Bojonegoro', koordinat: { lat: -7.2500, lng: 111.9000 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 1520, status: 'Aktif' },
  { id: 'PSN012', no: 26, nama: 'Yay. Pondok Pesantren Qomaruddin', yayasan: 'Yay. Pondok Pesantren Qomaruddin', desa: 'Bungah', kecamatan: 'Bungah', kabupaten: 'Gresik', koordinat: { lat: -7.1000, lng: 112.6000 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 2375, status: 'Aktif' },
  { id: 'PSN013', no: 33, nama: 'Tarbiyatul Ulum Sumursongo', yayasan: 'Tarbiyatul Ulum Sumursongo', desa: 'Sumursongo', kecamatan: 'Karas', kabupaten: 'Magetan', koordinat: { lat: -7.6500, lng: 111.3000 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 2006, zona: 6, status: 'Aktif' },
  { id: 'PSN014', no: 43, nama: 'Hosnul Khatimah', yayasan: 'Hosnul Khatimah', desa: 'Aengmerah', kecamatan: 'Batuputih', kabupaten: 'Sumenep', koordinat: { lat: -6.9500, lng: 113.8500 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 1517, status: 'Aktif' },
  { id: 'PSN015', no: 55, nama: 'Al Muntahy', yayasan: 'Al Muntahy', desa: 'Kembang Jeruk', kecamatan: 'Banyuates', kabupaten: 'Sampang', koordinat: { lat: -7.0500, lng: 113.2500 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 3515, status: 'Aktif' },
  { id: 'PSN016', no: 66, nama: 'At Tarbiyah Linnasyiin', yayasan: 'At Tarbiyah Linnasyiin', desa: 'Wonorejo', kecamatan: 'Kedungjajang', kabupaten: 'Lumajang', koordinat: { lat: -8.1500, lng: 113.2000 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 2752, zona: 2, status: 'Aktif' },
  { id: 'PSN017', no: 72, nama: 'Pondok Pesantren Salafiyah Syafiiyah', yayasan: 'Pondok Pesantren Salafiyah Syafiiyah Sukorejo 1', desa: 'Sumberejo', kecamatan: 'Banyuputih', kabupaten: 'Situbondo', koordinat: { lat: -7.7500, lng: 113.9000 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 2000, zona: 1, status: 'Aktif' },
  { id: 'PSN018', no: 77, nama: 'Nurul Jadid 1', yayasan: 'Nurul Jadid 1', desa: 'Karanganyar', kecamatan: 'Paiton', kabupaten: 'Probolinggo', koordinat: { lat: -7.7000, lng: 113.5000 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 2467, status: 'Aktif' },
  { id: 'PSN019', no: 81, nama: 'YAYASAN Al Yaqien Wassurur', yayasan: 'YAYASAN SOSIAL DAN PENDIDIKAN Al Yaqien Wassurur (AWS)', desa: 'Mlokorejo', kecamatan: 'Puger', kabupaten: 'Jember', koordinat: { lat: -8.3000, lng: 113.4000 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 2189, zona: 2, status: 'Aktif' },
  { id: 'PSN020', no: 87, nama: 'YPP DARUL FALAH', yayasan: 'YPP DARUL FALAH', desa: 'Ramban Kulon', kecamatan: 'Cermee', kabupaten: 'Bondowoso', koordinat: { lat: -7.9500, lng: 113.8000 }, beroperasi: true, jumlahRelawan: 44, jumlahPenerimaManfaat: 3295, status: 'Aktif' },
];

// Sample pengiriman data
export const pengirimanList: Pengiriman[] = [
  {
    id: 'PNG001',
    kodePengiriman: 'DLV-20260108-001',
    driverId: 'DRV001',
    agenId: 'AGN-SBY-01',
    pesantrenId: 'PSN012',
    jumlahPorsi: 500,
    menu: ['Nasi', 'Ayam Goreng', 'Sayur Lodeh', 'Buah'],
    tanggalKirim: '2026-01-08',
    waktuBerangkat: '06:30:00',
    status: 'Dalam Perjalanan',
    keterangan: 'Pengiriman pagi',
    rute: [
      { lat: -7.1569, lng: 112.6550, timestamp: '2026-01-08T06:30:00Z', kecepatan: 0 },
      { lat: -7.1800, lng: 112.6600, timestamp: '2026-01-08T06:35:00Z', kecepatan: 40 },
      { lat: -7.2000, lng: 112.6500, timestamp: '2026-01-08T06:40:00Z', kecepatan: 45 }
    ],
    estimasiWaktu: 45,
    jarak: 12.5
  },
  {
    id: 'PNG002',
    kodePengiriman: 'DLV-20260108-002',
    driverId: 'DRV011',
    agenId: 'AGN-MLG-01',
    pesantrenId: 'PSN009',
    jumlahPorsi: 600,
    menu: ['Nasi', 'Ikan Bakar', 'Tumis Kangkung', 'Buah'],
    tanggalKirim: '2026-01-08',
    waktuBerangkat: '07:00:00',
    status: 'Sampai Tujuan',
    waktuSampai: '08:15:00',
    keterangan: 'Pengiriman berhasil',
    rute: [
      { lat: -7.9666, lng: 112.6326, timestamp: '2026-01-08T07:00:00Z', kecepatan: 0 },
      { lat: -7.9800, lng: 112.6500, timestamp: '2026-01-08T07:10:00Z', kecepatan: 50 },
      { lat: -8.0000, lng: 112.7000, timestamp: '2026-01-08T07:25:00Z', kecepatan: 55 },
      { lat: -8.0500, lng: 112.7500, timestamp: '2026-01-08T08:15:00Z', kecepatan: 0 }
    ],
    estimasiWaktu: 60,
    jarak: 25.3
  },
  {
    id: 'PNG003',
    kodePengiriman: 'DLV-20260108-003',
    driverId: 'DRV016',
    agenId: 'AGN-JBR-01',
    pesantrenId: 'PSN019',
    jumlahPorsi: 550,
    menu: ['Nasi', 'Rendang', 'Sayur Asem', 'Buah'],
    tanggalKirim: '2026-01-08',
    waktuBerangkat: '06:45:00',
    status: 'Dalam Perjalanan',
    keterangan: 'Menuju lokasi',
    rute: [
      { lat: -8.1720, lng: 113.6995, timestamp: '2026-01-08T06:45:00Z', kecepatan: 0 },
      { lat: -8.2000, lng: 113.6500, timestamp: '2026-01-08T06:55:00Z', kecepatan: 55 },
      { lat: -8.2500, lng: 113.5500, timestamp: '2026-01-08T07:10:00Z', kecepatan: 60 }
    ],
    estimasiWaktu: 50,
    jarak: 18.7
  },
  {
    id: 'PNG004',
    kodePengiriman: 'DLV-20260108-004',
    driverId: 'DRV038',
    agenId: 'AGN-PMS-01',
    pesantrenId: 'PSN014',
    jumlahPorsi: 800,
    menu: ['Nasi', 'Ayam Bakar', 'Capcay', 'Buah'],
    tanggalKirim: '2026-01-08',
    waktuBerangkat: '05:30:00',
    status: 'Selesai',
    waktuSampai: '08:30:00',
    keterangan: 'Pengiriman selesai dengan baik',
    rute: [
      { lat: -7.1667, lng: 113.4667, timestamp: '2026-01-08T05:30:00Z', kecepatan: 0 },
      { lat: -7.0500, lng: 113.2500, timestamp: '2026-01-08T06:30:00Z', kecepatan: 45 },
      { lat: -6.9500, lng: 113.8500, timestamp: '2026-01-08T08:30:00Z', kecepatan: 0 }
    ],
    estimasiWaktu: 180,
    jarak: 85.2,
    rating: 5,
    feedback: 'Pengiriman tepat waktu, makanan masih hangat'
  },
  {
    id: 'PNG005',
    kodePengiriman: 'DLV-20260108-005',
    driverId: 'DRV027',
    agenId: 'AGN-PON-01',
    pesantrenId: 'PSN013',
    jumlahPorsi: 700,
    menu: ['Nasi', 'Sate Ayam', 'Sayur Sop', 'Buah'],
    tanggalKirim: '2026-01-08',
    waktuBerangkat: '07:30:00',
    status: 'Dalam Perjalanan',
    keterangan: 'Dalam perjalanan ke lokasi',
    rute: [
      { lat: -7.8720, lng: 111.4615, timestamp: '2026-01-08T07:30:00Z', kecepatan: 0 },
      { lat: -7.8000, lng: 111.3500, timestamp: '2026-01-08T07:45:00Z', kecepatan: 50 },
      { lat: -7.7000, lng: 111.3200, timestamp: '2026-01-08T07:55:00Z', kecepatan: 55 }
    ],
    estimasiWaktu: 40,
    jarak: 15.4
  }
];

export const notifikasiList: Notifikasi[] = [
  {
    id: 'NOT001',
    judul: 'Pengiriman Selesai',
    pesan: 'Pengiriman DLV-20260108-004 telah selesai dengan rating 5 bintang',
    tipe: 'success',
    timestamp: '2026-01-08T08:35:00Z',
    dibaca: false,
    relatedId: 'PNG004',
    relatedType: 'pengiriman'
  },
  {
    id: 'NOT002',
    judul: 'Driver Dalam Perjalanan',
    pesan: 'Driver Ahmad Subandi sedang menuju Yay. Pondok Pesantren Qomaruddin',
    tipe: 'info',
    timestamp: '2026-01-08T06:35:00Z',
    dibaca: true,
    relatedId: 'PNG001',
    relatedType: 'pengiriman'
  },
  {
    id: 'NOT003',
    judul: 'Pengiriman Sampai Tujuan',
    pesan: 'Pengiriman DLV-20260108-002 telah sampai di Sunan Kalijogo',
    tipe: 'success',
    timestamp: '2026-01-08T08:20:00Z',
    dibaca: false,
    relatedId: 'PNG002',
    relatedType: 'pengiriman'
  },
  {
    id: 'NOT004',
    judul: 'Perlu Perhatian',
    pesan: 'Estimasi waktu pengiriman DLV-20260108-005 terlambat 15 menit',
    tipe: 'warning',
    timestamp: '2026-01-08T08:00:00Z',
    dibaca: false,
    relatedId: 'PNG005',
    relatedType: 'pengiriman'
  },
  {
    id: 'NOT005',
    judul: 'Driver Baru Tersedia',
    pesan: 'Driver Joko Susilo kini tersedia untuk pengiriman',
    tipe: 'info',
    timestamp: '2026-01-08T07:00:00Z',
    dibaca: true,
    relatedId: 'DRV024',
    relatedType: 'driver'
  }
];

export const dashboardStats: DashboardStats = {
  totalPengirimanHariIni: 45,
  totalPorsiHariIni: 28500,
  driverAktif: 38,
  driverTotal: 40,
  pesantrenTerlayani: 87,
  pesantrenTotal: 101,
  pengirimanDalamPerjalanan: 12,
  pengirimanSelesai: 28,
  rataRataWaktuPengiriman: 52,
  tingkatKepuasan: 4.7
};

// Helper functions
export const getDriverById = (id: string): Driver | undefined => drivers.find(d => d.id === id);
export const getPesantrenById = (id: string): Pesantren | undefined => pesantrenList.find(p => p.id === id);
export const getPengirimanById = (id: string): Pengiriman | undefined => pengirimanList.find(p => p.id === id);
export const getDriversByAgent = (agentId: string): Driver[] => drivers.filter(d => d.agenId === agentId);
export const getPengirimanByDriver = (driverId: string): Pengiriman[] => pengirimanList.filter(p => p.driverId === driverId);
export const getPengirimanByStatus = (status: Pengiriman['status']): Pengiriman[] => pengirimanList.filter(p => p.status === status);
