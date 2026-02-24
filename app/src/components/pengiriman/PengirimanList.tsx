import { useState } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { 
  Truck, 
  MapPin, 
  Clock, 
  Utensils,
  CheckCircle2,
  Navigation,
  Package,
  MoreHorizontal
} from 'lucide-react';
import type { Pengiriman } from '@/types';
import { getDriverById, getPesantrenById } from '@/data/mockData';
import { cn } from '@/lib/utils';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';

interface PengirimanListProps {
  pengiriman: Pengiriman[];
  onPengirimanSelect?: (pengiriman: Pengiriman) => void;
  selectedPengirimanId?: string | null;
}

export default function PengirimanList({ 
  pengiriman, 
  onPengirimanSelect,
  selectedPengirimanId 
}: PengirimanListProps) {
  const [activeTab, setActiveTab] = useState('semua');

  const getStatusBadge = (status: Pengiriman['status']) => {
    switch (status) {
      case 'Menunggu':
        return <Badge className="bg-gray-100 text-gray-700 hover:bg-gray-100">Menunggu</Badge>;
      case 'Dalam Perjalanan':
        return <Badge className="bg-blue-100 text-blue-700 hover:bg-blue-100">Dalam Perjalanan</Badge>;
      case 'Sampai Tujuan':
        return <Badge className="bg-orange-100 text-orange-700 hover:bg-orange-100">Sampai Tujuan</Badge>;
      case 'Selesai':
        return <Badge className="bg-green-100 text-green-700 hover:bg-green-100">Selesai</Badge>;
      case 'Dibatalkan':
        return <Badge className="bg-red-100 text-red-700 hover:bg-red-100">Dibatalkan</Badge>;
    }
  };

  const getStatusIcon = (status: Pengiriman['status']) => {
    switch (status) {
      case 'Menunggu':
        return <Clock className="h-4 w-4 text-gray-500" />;
      case 'Dalam Perjalanan':
        return <Navigation className="h-4 w-4 text-blue-500" />;
      case 'Sampai Tujuan':
        return <MapPin className="h-4 w-4 text-orange-500" />;
      case 'Selesai':
        return <CheckCircle2 className="h-4 w-4 text-green-500" />;
      case 'Dibatalkan':
        return <Package className="h-4 w-4 text-red-500" />;
    }
  };

  const filteredPengiriman = pengiriman.filter(p => {
    if (activeTab === 'semua') return true;
    if (activeTab === 'aktif') return p.status === 'Dalam Perjalanan' || p.status === 'Sampai Tujuan';
    if (activeTab === 'selesai') return p.status === 'Selesai';
    if (activeTab === 'menunggu') return p.status === 'Menunggu';
    return true;
  });

  return (
    <Card className="h-full">
      <CardHeader>
        <CardTitle className="flex items-center gap-2">
          <Package className="h-5 w-5" />
          Daftar Pengiriman
          <Badge variant="secondary" className="ml-auto">
            {filteredPengiriman.length}
          </Badge>
        </CardTitle>
      </CardHeader>
      <CardContent className="p-0">
        <Tabs value={activeTab} onValueChange={setActiveTab} className="w-full">
          <TabsList className="w-full grid grid-cols-4 mx-4 mb-2">
            <TabsTrigger value="semua">Semua</TabsTrigger>
            <TabsTrigger value="aktif">Aktif</TabsTrigger>
            <TabsTrigger value="selesai">Selesai</TabsTrigger>
            <TabsTrigger value="menunggu">Menunggu</TabsTrigger>
          </TabsList>

          <TabsContent value={activeTab} className="mt-0">
            <ScrollArea className="h-[450px]">
              <div className="space-y-2 p-4">
                {filteredPengiriman.map((p) => {
                  const isSelected = selectedPengirimanId === p.id;
                  const driver = getDriverById(p.driverId);
                  const pesantren = getPesantrenById(p.pesantrenId);

                  return (
                    <div
                      key={p.id}
                      onClick={() => onPengirimanSelect?.(p)}
                      className={cn(
                        "p-3 rounded-lg border cursor-pointer transition-all hover:shadow-md",
                        isSelected 
                          ? "border-blue-500 bg-blue-50" 
                          : "border-gray-200 hover:border-gray-300"
                      )}
                    >
                      <div className="flex items-start justify-between">
                        <div className="flex items-center gap-2">
                          {getStatusIcon(p.status)}
                          <span className="font-medium text-sm">{p.kodePengiriman}</span>
                        </div>
                        <div className="flex items-center gap-2">
                          {getStatusBadge(p.status)}
                          <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                              <Button variant="ghost" size="icon" className="h-6 w-6">
                                <MoreHorizontal className="h-3 w-3" />
                              </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                              <DropdownMenuItem>Lihat Detail</DropdownMenuItem>
                              <DropdownMenuItem>Lacak Driver</DropdownMenuItem>
                              <DropdownMenuItem>Hubungi Driver</DropdownMenuItem>
                            </DropdownMenuContent>
                          </DropdownMenu>
                        </div>
                      </div>

                      <div className="mt-2 space-y-1">
                        <div className="flex items-center gap-2 text-xs text-muted-foreground">
                          <MapPin className="h-3 w-3" />
                          <span className="truncate">{pesantren?.nama}</span>
                        </div>
                        
                        <div className="flex items-center gap-2 text-xs text-muted-foreground">
                          <Truck className="h-3 w-3" />
                          <span>{driver?.nama} • {driver?.platNomor}</span>
                        </div>

                        <div className="flex items-center gap-2 text-xs text-muted-foreground">
                          <Utensils className="h-3 w-3" />
                          <span>{p.jumlahPorsi.toLocaleString()} porsi</span>
                        </div>

                        <div className="flex items-center gap-2 text-xs text-muted-foreground">
                          <Clock className="h-3 w-3" />
                          <span>
                            {p.waktuBerangkat} 
                            {p.waktuSampai && ` - ${p.waktuSampai}`}
                            {!p.waktuSampai && p.status === 'Dalam Perjalanan' && (
                              <span className="text-blue-600 ml-1">
                                (Est. {p.estimasiWaktu} menit)
                              </span>
                            )}
                          </span>
                        </div>
                      </div>

                      {p.menu && p.menu.length > 0 && (
                        <div className="mt-2 flex flex-wrap gap-1">
                          {p.menu.slice(0, 3).map((item, idx) => (
                            <Badge key={idx} variant="outline" className="text-xs">
                              {item}
                            </Badge>
                          ))}
                          {p.menu.length > 3 && (
                            <Badge variant="outline" className="text-xs">
                              +{p.menu.length - 3}
                            </Badge>
                          )}
                        </div>
                      )}
                    </div>
                  );
                })}

                {filteredPengiriman.length === 0 && (
                  <div className="text-center py-8 text-muted-foreground">
                    <Package className="h-12 w-12 mx-auto mb-2 opacity-50" />
                    <p>Tidak ada pengiriman</p>
                  </div>
                )}
              </div>
            </ScrollArea>
          </TabsContent>
        </Tabs>
      </CardContent>
    </Card>
  );
}
