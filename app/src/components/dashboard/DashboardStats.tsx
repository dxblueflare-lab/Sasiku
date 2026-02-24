import { 
  Truck, 
  MapPin, 
  Utensils, 
  Clock, 
  Star,
  CheckCircle2,
  Navigation,
  TrendingUp
} from 'lucide-react';
import StatCard from './StatCard';
import type { DashboardStats as DashboardStatsType } from '@/types';

interface DashboardStatsProps {
  stats: DashboardStatsType;
}

export default function DashboardStats({ stats }: DashboardStatsProps) {
  return (
    <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
      <StatCard
        title="Pengiriman Hari Ini"
        value={stats.totalPengirimanHariIni}
        description={`${stats.pengirimanSelesai} selesai, ${stats.pengirimanDalamPerjalanan} dalam perjalanan`}
        icon={Truck}
        trend={{ value: 12, isPositive: true }}
        iconClassName="bg-gradient-to-br from-blue-500 to-blue-600 shadow-blue-500/30"
        gradient="from-blue-50 to-blue-100/50"
      />
      
      <StatCard
        title="Total Porsi"
        value={stats.totalPorsiHariIni.toLocaleString()}
        description="Porsi makanan terdistribusi"
        icon={Utensils}
        trend={{ value: 8, isPositive: true }}
        iconClassName="bg-gradient-to-br from-green-500 to-green-600 shadow-green-500/30"
        gradient="from-green-50 to-green-100/50"
      />
      
      <StatCard
        title="Driver Aktif"
        value={`${stats.driverAktif}/${stats.driverTotal}`}
        description={`${Math.round((stats.driverAktif / stats.driverTotal) * 100)}% armada aktif`}
        icon={Navigation}
        trend={{ value: 5, isPositive: true }}
        iconClassName="bg-gradient-to-br from-orange-500 to-orange-600 shadow-orange-500/30"
        gradient="from-orange-50 to-orange-100/50"
      />
      
      <StatCard
        title="Pesantren Terlayani"
        value={`${stats.pesantrenTerlayani}/${stats.pesantrenTotal}`}
        description={`${Math.round((stats.pesantrenTerlayani / stats.pesantrenTotal) * 100)}% cakupan layanan`}
        icon={MapPin}
        trend={{ value: 3, isPositive: true }}
        iconClassName="bg-gradient-to-br from-purple-500 to-purple-600 shadow-purple-500/30"
        gradient="from-purple-50 to-purple-100/50"
      />
      
      <StatCard
        title="Rata-rata Waktu"
        value={`${stats.rataRataWaktuPengiriman} menit`}
        description="Dari berangkat sampai tujuan"
        icon={Clock}
        trend={{ value: 5, isPositive: true }}
        iconClassName="bg-gradient-to-br from-yellow-500 to-yellow-600 shadow-yellow-500/30"
        gradient="from-yellow-50 to-yellow-100/50"
      />
      
      <StatCard
        title="Tingkat Kepuasan"
        value={`${stats.tingkatKepuasan}/5.0`}
        description="Berdasarkan feedback pesantren"
        icon={Star}
        trend={{ value: 2, isPositive: true }}
        iconClassName="bg-gradient-to-br from-amber-500 to-amber-600 shadow-amber-500/30"
        gradient="from-amber-50 to-amber-100/50"
      />
      
      <StatCard
        title="Pengiriman Selesai"
        value={stats.pengirimanSelesai}
        description="Hari ini"
        icon={CheckCircle2}
        iconClassName="bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-emerald-500/30"
        gradient="from-emerald-50 to-emerald-100/50"
      />
      
      <StatCard
        title="Dalam Perjalanan"
        value={stats.pengirimanDalamPerjalanan}
        description="Sedang menuju lokasi"
        icon={TrendingUp}
        iconClassName="bg-gradient-to-br from-cyan-500 to-cyan-600 shadow-cyan-500/30"
        gradient="from-cyan-50 to-cyan-100/50"
      />
    </div>
  );
}
