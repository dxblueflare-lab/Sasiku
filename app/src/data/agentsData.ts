import type { Agent } from '@/types';

export const agents: Agent[] = [
  {
    id: 'AGN-SBY-01',
    nama: 'Agen Surabaya Utara',
    alamat: 'Jl. Raya Gresik Km. 12, Kebomas, Gresik',
    koordinat: { lat: -7.1569, lng: 112.6550 },
    coverage: ['Gresik', 'Lamongan'],
    kapasitas: '6000 porsi/hari',
    armada: 10,
    status: 'Aktif',
    telepon: '031-1234567',
    penanggungJawab: 'H. Ahmad Surya'
  },
  {
    id: 'AGN-SBY-02',
    nama: 'Agen Surabaya Selatan',
    alamat: 'Jl. Ahmad Yani No. 145, Sidoarjo',
    koordinat: { lat: -7.4478, lng: 112.7183 },
    coverage: ['Mojokerto', 'Jombang'],
    kapasitas: '7000 porsi/hari',
    armada: 12,
    status: 'Aktif',
    telepon: '031-2345678',
    penanggungJawab: 'H. Budi Santoso'
  },
  {
    id: 'AGN-PSR-01',
    nama: 'Agen Pasuruan',
    alamat: 'Jl. Panglima Sudirman No. 88, Pasuruan',
    koordinat: { lat: -7.6469, lng: 112.9040 },
    coverage: ['Pasuruan'],
    kapasitas: '3000 porsi/hari',
    armada: 5,
    status: 'Aktif',
    telepon: '0343-123456',
    penanggungJawab: 'H. Candra Wijaya'
  },
  {
    id: 'AGN-PBL-01',
    nama: 'Agen Probolinggo',
    alamat: 'Jl. Suroyo No. 45, Probolinggo',
    koordinat: { lat: -7.7764, lng: 113.2037 },
    coverage: ['Probolinggo'],
    kapasitas: '5000 porsi/hari',
    armada: 8,
    status: 'Aktif',
    telepon: '0335-234567',
    penanggungJawab: 'H. Dedi Kurniawan'
  },
  {
    id: 'AGN-MLG-01',
    nama: 'Agen Malang Pusat',
    alamat: 'Jl. Soekarno Hatta No. 78, Malang',
    koordinat: { lat: -7.9666, lng: 112.6326 },
    coverage: ['Malang'],
    kapasitas: '7000 porsi/hari',
    armada: 12,
    status: 'Aktif',
    telepon: '0341-345678',
    penanggungJawab: 'H. Eko Prasetyo'
  },
  {
    id: 'AGN-BLT-01',
    nama: 'Agen Blitar',
    alamat: 'Jl. Merdeka No. 23, Blitar',
    koordinat: { lat: -8.0950, lng: 112.1600 },
    coverage: ['Blitar', 'Kediri'],
    kapasitas: '4000 porsi/hari',
    armada: 6,
    status: 'Aktif',
    telepon: '0342-456789',
    penanggungJawab: 'H. Fajar Nugroho'
  },
  {
    id: 'AGN-JBR-01',
    nama: 'Agen Jember',
    alamat: 'Jl. Gajah Mada No. 67, Jember',
    koordinat: { lat: -8.1720, lng: 113.6995 },
    coverage: ['Jember'],
    kapasitas: '6000 porsi/hari',
    armada: 10,
    status: 'Aktif',
    telepon: '0331-567890',
    penanggungJawab: 'H. Guntur Wibowo'
  },
  {
    id: 'AGN-LMJ-01',
    nama: 'Agen Lumajang',
    alamat: 'Jl. Sudirman No. 89, Lumajang',
    koordinat: { lat: -8.1333, lng: 113.2167 },
    coverage: ['Lumajang'],
    kapasitas: '5500 porsi/hari',
    armada: 9,
    status: 'Aktif',
    telepon: '0334-678901',
    penanggungJawab: 'H. Hadi Sucipto'
  },
  {
    id: 'AGN-BDW-01',
    nama: 'Agen Bondowoso',
    alamat: 'Jl. Diponegoro No. 34, Bondowoso',
    koordinat: { lat: -7.9135, lng: 113.8210 },
    coverage: ['Bondowoso'],
    kapasitas: '5500 porsi/hari',
    armada: 9,
    status: 'Aktif',
    telepon: '0332-789012',
    penanggungJawab: 'H. Indra Gunawan'
  },
  {
    id: 'AGN-STB-01',
    nama: 'Agen Situbondo',
    alamat: 'Jl. Veteran No. 56, Situbondo',
    koordinat: { lat: -7.7060, lng: 114.0090 },
    coverage: ['Situbondo', 'Banyuwangi'],
    kapasitas: '6000 porsi/hari',
    armada: 10,
    status: 'Aktif',
    telepon: '0338-890123',
    penanggungJawab: 'H. Joko Susilo'
  },
  {
    id: 'AGN-BJN-01',
    nama: 'Agen Bojonegoro',
    alamat: 'Jl. Pemuda No. 12, Bojonegoro',
    koordinat: { lat: -7.1500, lng: 111.8833 },
    coverage: ['Bojonegoro'],
    kapasitas: '5000 porsi/hari',
    armada: 8,
    status: 'Aktif',
    telepon: '0353-901234',
    penanggungJawab: 'H. Kusumo Adi'
  },
  {
    id: 'AGN-PON-01',
    nama: 'Agen Ponorogo',
    alamat: 'Jl. Slamet Riyadi No. 45, Ponorogo',
    koordinat: { lat: -7.8720, lng: 111.4615 },
    coverage: ['Ponorogo', 'Magetan', 'Trenggalek', 'Tulungagung'],
    kapasitas: '6000 porsi/hari',
    armada: 10,
    status: 'Aktif',
    telepon: '0352-012345',
    penanggungJawab: 'H. Lukman Hakim'
  },
  {
    id: 'AGN-WNS-01',
    nama: 'Agen Wonosobo',
    alamat: 'Jl. DI Panjaitan No. 23, Wonosobo',
    koordinat: { lat: -7.3636, lng: 109.9000 },
    coverage: ['Wonosobo', 'Magelang'],
    kapasitas: '3000 porsi/hari',
    armada: 5,
    status: 'Aktif',
    telepon: '0286-123456',
    penanggungJawab: 'H. Mulyono'
  },
  {
    id: 'AGN-BKL-01',
    nama: 'Agen Bangkalan',
    alamat: 'Jl. KH. Moh. Kholil No. 67, Bangkalan',
    koordinat: { lat: -7.0319, lng: 112.7456 },
    coverage: ['Bangkalan'],
    kapasitas: '6000 porsi/hari',
    armada: 10,
    status: 'Aktif',
    telepon: '031-9876543',
    penanggungJawab: 'H. Nasiruddin'
  },
  {
    id: 'AGN-SPG-01',
    nama: 'Agen Sampang',
    alamat: 'Jl. Trunojoyo No. 78, Sampang',
    koordinat: { lat: -7.0500, lng: 113.2500 },
    coverage: ['Sampang'],
    kapasitas: '6000 porsi/hari',
    armada: 10,
    status: 'Aktif',
    telepon: '0323-234567',
    penanggungJawab: 'H. Oman Fathur'
  },
  {
    id: 'AGN-PMS-01',
    nama: 'Agen Pamekasan',
    alamat: 'Jl. Sultan Agung No. 34, Pamekasan',
    koordinat: { lat: -7.1667, lng: 113.4667 },
    coverage: ['Pamekasan', 'Sumenep'],
    kapasitas: '8000 porsi/hari',
    armada: 14,
    status: 'Aktif',
    telepon: '0324-345678',
    penanggungJawab: 'H. Pandji Sakti'
  }
];

export const getAgentById = (id: string): Agent | undefined => agents.find(a => a.id === id);
export const getAgentsByStatus = (status: Agent['status']): Agent[] => agents.filter(a => a.status === status);
export const getTotalArmada = (): number => agents.reduce((acc, a) => acc + a.armada, 0);
export const getTotalKapasitas = (): number => agents.reduce((acc, a) => acc + parseInt(a.kapasitas.replace(/\D/g, '')), 0);
