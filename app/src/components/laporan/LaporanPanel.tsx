import { useState } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { 
  Download, 
  Calendar,
  BarChart3,
  PieChart,
  Truck,
  Utensils,
  Clock,
  Star
} from 'lucide-react';
import { 
  BarChart, 
  Bar, 
  XAxis, 
  YAxis, 
  CartesianGrid, 
  Tooltip, 
  ResponsiveContainer,
  LineChart,
  Line,
  PieChart as RePieChart,
  Pie,
  Cell
} from 'recharts';
import type { Pengiriman } from '@/types';

interface LaporanPanelProps {
  pengiriman: Pengiriman[];
}

// const COLORS = ['#3b82f6', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6'];

export default function LaporanPanel({ pengiriman }: LaporanPanelProps) {
  // eslint-disable-next-line @typescript-eslint/no-unused-vars
  const [_period, _setPeriod] = useState('harian');

  // Mock data for charts
  const dailyData = [
    { name: 'Senin', pengiriman: 42, porsi: 26500 },
    { name: 'Selasa', pengiriman: 45, porsi: 28500 },
    { name: 'Rabu', pengiriman: 38, porsi: 24200 },
    { name: 'Kamis', pengiriman: 50, porsi: 31800 },
    { name: 'Jumat', pengiriman: 48, porsi: 30500 },
    { name: 'Sabtu', pengiriman: 35, porsi: 22100 },
    { name: 'Minggu', pengiriman: 30, porsi: 18900 },
  ];

  const statusData = [
    { name: 'Selesai', value: 28, color: '#22c55e' },
    { name: 'Dalam Perjalanan', value: 12, color: '#3b82f6' },
    { name: 'Menunggu', value: 5, color: '#f59e0b' },
  ];

  const agentData = [
    { name: 'Surabaya Utara', pengiriman: 8 },
    { name: 'Surabaya Selatan', pengiriman: 12 },
    { name: 'Malang', pengiriman: 15 },
    { name: 'Jember', pengiriman: 10 },
    { name: 'Madura', pengiriman: 18 },
  ];

  const performanceData = [
    { name: 'Minggu 1', kepuasan: 4.5, ketepatan: 92 },
    { name: 'Minggu 2', kepuasan: 4.6, ketepatan: 94 },
    { name: 'Minggu 3', kepuasan: 4.7, ketepatan: 95 },
    { name: 'Minggu 4', kepuasan: 4.8, ketepatan: 96 },
  ];

  return (
    <div className="space-y-4">
      <div className="flex items-center justify-between">
        <div>
          <h2 className="text-2xl font-bold">Laporan & Analitik</h2>
          <p className="text-muted-foreground">Ringkasan kinerja distribusi</p>
        </div>
        <div className="flex gap-2">
          <Button variant="outline" size="sm">
            <Calendar className="h-4 w-4 mr-2" />
            Pilih Periode
          </Button>
          <Button variant="outline" size="sm">
            <Download className="h-4 w-4 mr-2" />
            Export PDF
          </Button>
        </div>
      </div>

      <Tabs defaultValue="ringkasan" className="w-full">
        <TabsList className="grid w-full grid-cols-4">
          <TabsTrigger value="ringkasan">Ringkasan</TabsTrigger>
          <TabsTrigger value="pengiriman">Pengiriman</TabsTrigger>
          <TabsTrigger value="kinerja">Kinerja</TabsTrigger>
          <TabsTrigger value="detail">Detail</TabsTrigger>
        </TabsList>

        <TabsContent value="ringkasan" className="space-y-4">
          <div className="grid gap-4 md:grid-cols-4">
            <Card>
              <CardHeader className="pb-2">
                <CardTitle className="text-sm font-medium flex items-center gap-2">
                  <Truck className="h-4 w-4 text-blue-500" />
                  Total Pengiriman
                </CardTitle>
              </CardHeader>
              <CardContent>
                <div className="text-2xl font-bold">288</div>
                <p className="text-xs text-muted-foreground">Bulan ini</p>
              </CardContent>
            </Card>

            <Card>
              <CardHeader className="pb-2">
                <CardTitle className="text-sm font-medium flex items-center gap-2">
                  <Utensils className="h-4 w-4 text-green-500" />
                  Total Porsi
                </CardTitle>
              </CardHeader>
              <CardContent>
                <div className="text-2xl font-bold">182,500</div>
                <p className="text-xs text-muted-foreground">Bulan ini</p>
              </CardContent>
            </Card>

            <Card>
              <CardHeader className="pb-2">
                <CardTitle className="text-sm font-medium flex items-center gap-2">
                  <Clock className="h-4 w-4 text-orange-500" />
                  Rata-rata Waktu
                </CardTitle>
              </CardHeader>
              <CardContent>
                <div className="text-2xl font-bold">52 menit</div>
                <p className="text-xs text-muted-foreground">Per pengiriman</p>
              </CardContent>
            </Card>

            <Card>
              <CardHeader className="pb-2">
                <CardTitle className="text-sm font-medium flex items-center gap-2">
                  <Star className="h-4 w-4 text-yellow-500" />
                  Kepuasan
                </CardTitle>
              </CardHeader>
              <CardContent>
                <div className="text-2xl font-bold">4.7/5.0</div>
                <p className="text-xs text-muted-foreground">Dari feedback</p>
              </CardContent>
            </Card>
          </div>

          <div className="grid gap-4 md:grid-cols-2">
            <Card>
              <CardHeader>
                <CardTitle className="text-base flex items-center gap-2">
                  <BarChart3 className="h-4 w-4" />
                  Pengiriman Harian
                </CardTitle>
              </CardHeader>
              <CardContent>
                <ResponsiveContainer width="100%" height={250}>
                  <BarChart data={dailyData}>
                    <CartesianGrid strokeDasharray="3 3" />
                    <XAxis dataKey="name" fontSize={12} />
                    <YAxis fontSize={12} />
                    <Tooltip />
                    <Bar dataKey="pengiriman" fill="#3b82f6" radius={[4, 4, 0, 0]} />
                  </BarChart>
                </ResponsiveContainer>
              </CardContent>
            </Card>

            <Card>
              <CardHeader>
                <CardTitle className="text-base flex items-center gap-2">
                  <PieChart className="h-4 w-4" />
                  Status Pengiriman
                </CardTitle>
              </CardHeader>
              <CardContent>
                <ResponsiveContainer width="100%" height={250}>
                  <RePieChart>
                    <Pie
                      data={statusData}
                      cx="50%"
                      cy="50%"
                      innerRadius={60}
                      outerRadius={80}
                      paddingAngle={5}
                      dataKey="value"
                    >
                      {statusData.map((entry, index) => (
                        <Cell key={`cell-${index}`} fill={entry.color} />
                      ))}
                    </Pie>
                    <Tooltip />
                  </RePieChart>
                </ResponsiveContainer>
                <div className="flex justify-center gap-4 mt-2">
                  {statusData.map((item) => (
                    <div key={item.name} className="flex items-center gap-1">
                      <div 
                        className="w-3 h-3 rounded-full" 
                        style={{ backgroundColor: item.color }}
                      />
                      <span className="text-xs">{item.name}</span>
                    </div>
                  ))}
                </div>
              </CardContent>
            </Card>
          </div>
        </TabsContent>

        <TabsContent value="pengiriman" className="space-y-4">
          <Card>
            <CardHeader>
              <CardTitle>Pengiriman per Agen</CardTitle>
            </CardHeader>
            <CardContent>
              <ResponsiveContainer width="100%" height={300}>
                <BarChart data={agentData} layout="vertical">
                  <CartesianGrid strokeDasharray="3 3" />
                  <XAxis type="number" fontSize={12} />
                  <YAxis dataKey="name" type="category" fontSize={12} width={120} />
                  <Tooltip />
                  <Bar dataKey="pengiriman" fill="#3b82f6" radius={[0, 4, 4, 0]} />
                </BarChart>
              </ResponsiveContainer>
            </CardContent>
          </Card>
        </TabsContent>

        <TabsContent value="kinerja" className="space-y-4">
          <Card>
            <CardHeader>
              <CardTitle>Tren Kepuasan & Ketepatan Waktu</CardTitle>
            </CardHeader>
            <CardContent>
              <ResponsiveContainer width="100%" height={300}>
                <LineChart data={performanceData}>
                  <CartesianGrid strokeDasharray="3 3" />
                  <XAxis dataKey="name" fontSize={12} />
                  <YAxis yAxisId="left" fontSize={12} domain={[4, 5]} />
                  <YAxis yAxisId="right" orientation="right" fontSize={12} domain={[90, 100]} />
                  <Tooltip />
                  <Line 
                    yAxisId="left" 
                    type="monotone" 
                    dataKey="kepuasan" 
                    stroke="#8b5cf6" 
                    strokeWidth={2}
                    name="Kepuasan"
                  />
                  <Line 
                    yAxisId="right" 
                    type="monotone" 
                    dataKey="ketepatan" 
                    stroke="#22c55e" 
                    strokeWidth={2}
                    name="Ketepatan (%)"
                  />
                </LineChart>
              </ResponsiveContainer>
            </CardContent>
          </Card>
        </TabsContent>

        <TabsContent value="detail" className="space-y-4">
          <Card>
            <CardHeader>
              <CardTitle>Detail Pengiriman Terbaru</CardTitle>
            </CardHeader>
            <CardContent>
              <div className="overflow-x-auto">
                <table className="w-full text-sm">
                  <thead>
                    <tr className="border-b">
                      <th className="text-left p-2">Kode</th>
                      <th className="text-left p-2">Driver</th>
                      <th className="text-left p-2">Pesantren</th>
                      <th className="text-left p-2">Porsi</th>
                      <th className="text-left p-2">Status</th>
                      <th className="text-left p-2">Waktu</th>
                    </tr>
                  </thead>
                  <tbody>
                    {pengiriman.slice(0, 5).map((p) => (
                      <tr key={p.id} className="border-b">
                        <td className="p-2 font-medium">{p.kodePengiriman}</td>
                        <td className="p-2">{p.driverId}</td>
                        <td className="p-2">{p.pesantrenId}</td>
                        <td className="p-2">{p.jumlahPorsi}</td>
                        <td className="p-2">
                          <Badge 
                            variant={p.status === 'Selesai' ? 'default' : 'secondary'}
                          >
                            {p.status}
                          </Badge>
                        </td>
                        <td className="p-2">{p.waktuBerangkat}</td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </CardContent>
          </Card>
        </TabsContent>
      </Tabs>
    </div>
  );
}
