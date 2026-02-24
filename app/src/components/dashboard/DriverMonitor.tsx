import { useState, useEffect } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { 
  MapPin, 
  Navigation, 
  Clock, 
  Star,
  Truck,
  ChevronRight
} from 'lucide-react';
import type { Driver } from '@/types';
import { getPengirimanByDriver } from '@/data/mockData';
import { cn } from '@/lib/utils';

interface DriverMonitorProps {
  drivers: Driver[];
  onDriverSelect?: (driver: Driver) => void;
  selectedDriverId?: string | null;
}

export default function DriverMonitor({ 
  drivers, 
  onDriverSelect,
  selectedDriverId 
}: DriverMonitorProps) {
  const [activeDrivers, setActiveDrivers] = useState<Driver[]>([]);

  useEffect(() => {
    // Sort drivers: active first, then by rating
    const sorted = [...drivers].sort((a, b) => {
      if (a.status === 'Sedang Mengantar' && b.status !== 'Sedang Mengantar') return -1;
      if (a.status !== 'Sedang Mengantar' && b.status === 'Sedang Mengantar') return 1;
      return b.rating - a.rating;
    });
    setActiveDrivers(sorted);
  }, [drivers]);

  const getStatusColor = (status: Driver['status']) => {
    switch (status) {
      case 'Sedang Mengantar':
        return 'bg-green-500';
      case 'Tersedia':
        return 'bg-blue-500';
      case 'Istirahat':
        return 'bg-yellow-500';
      case 'Maintenance':
        return 'bg-red-500';
      default:
        return 'bg-gray-500';
    }
  };

  const getStatusBadge = (status: Driver['status']) => {
    switch (status) {
      case 'Sedang Mengantar':
        return <Badge className="bg-green-100 text-green-700 hover:bg-green-100">Mengantar</Badge>;
      case 'Tersedia':
        return <Badge className="bg-blue-100 text-blue-700 hover:bg-blue-100">Tersedia</Badge>;
      case 'Istirahat':
        return <Badge className="bg-yellow-100 text-yellow-700 hover:bg-yellow-100">Istirahat</Badge>;
      case 'Maintenance':
        return <Badge className="bg-red-100 text-red-700 hover:bg-red-100">Maintenance</Badge>;
    }
  };

  return (
    <Card className="h-full">
      <CardHeader>
        <CardTitle className="flex items-center gap-2">
          <Truck className="h-5 w-5" />
          Monitoring Driver
          <Badge variant="secondary" className="ml-auto">
            {activeDrivers.filter(d => d.status === 'Sedang Mengantar').length} Aktif
          </Badge>
        </CardTitle>
      </CardHeader>
      <CardContent className="p-0">
        <ScrollArea className="h-[500px]">
          <div className="space-y-2 p-4">
            {activeDrivers.map((driver) => {
              const isSelected = selectedDriverId === driver.id;
              const activeDelivery = getPengirimanByDriver(driver.id).find(
                p => p.status === 'Dalam Perjalanan'
              );

              return (
                <div
                  key={driver.id}
                  onClick={() => onDriverSelect?.(driver)}
                  className={cn(
                    "p-3 rounded-lg border cursor-pointer transition-all hover:shadow-md",
                    isSelected 
                      ? "border-blue-500 bg-blue-50" 
                      : "border-gray-200 hover:border-gray-300"
                  )}
                >
                  <div className="flex items-start gap-3">
                    <div className="relative">
                      <Avatar className="h-10 w-10">
                        <AvatarFallback className="bg-gradient-to-br from-blue-500 to-purple-600 text-white text-sm">
                          {driver.nama.split(' ').map(n => n[0]).join('').slice(0, 2)}
                        </AvatarFallback>
                      </Avatar>
                      <div className={cn(
                        "absolute -bottom-1 -right-1 w-3 h-3 rounded-full border-2 border-white",
                        getStatusColor(driver.status)
                      )} />
                    </div>

                    <div className="flex-1 min-w-0">
                      <div className="flex items-center justify-between">
                        <h4 className="font-medium text-sm truncate">{driver.nama}</h4>
                        {getStatusBadge(driver.status)}
                      </div>

                      <div className="flex items-center gap-2 mt-1 text-xs text-muted-foreground">
                        <span className="flex items-center gap-1">
                          <Truck className="h-3 w-3" />
                          {driver.platNomor}
                        </span>
                        <span>•</span>
                        <span className="flex items-center gap-1">
                          <Star className="h-3 w-3 text-yellow-500" />
                          {driver.rating}
                        </span>
                      </div>

                      {driver.lokasi && (
                        <div className="flex items-center gap-1 mt-1 text-xs text-muted-foreground">
                          <MapPin className="h-3 w-3" />
                          <span className="truncate">
                            {driver.lokasi.lat.toFixed(4)}, {driver.lokasi.lng.toFixed(4)}
                          </span>
                        </div>
                      )}

                      {activeDelivery && (
                        <div className="mt-2 p-2 bg-blue-50 rounded text-xs">
                          <div className="flex items-center gap-1 text-blue-700 font-medium">
                            <Navigation className="h-3 w-3" />
                            Pengiriman Aktif
                          </div>
                          <div className="text-blue-600 mt-1">
                            {activeDelivery.kodePengiriman} • {activeDelivery.jumlahPorsi} porsi
                          </div>
                          <div className="flex items-center gap-1 text-blue-600 mt-1">
                            <Clock className="h-3 w-3" />
                            Est. {activeDelivery.estimasiWaktu} menit
                          </div>
                        </div>
                      )}
                    </div>

                    <ChevronRight className="h-4 w-4 text-gray-400" />
                  </div>
                </div>
              );
            })}
          </div>
        </ScrollArea>
      </CardContent>
    </Card>
  );
}
