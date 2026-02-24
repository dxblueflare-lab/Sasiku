import { useState } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { 
  Building2, 
  MapPin, 
  Phone, 
  User,
  Truck,
  Utensils,
  ChevronRight,
  Navigation,
  TrendingUp
} from 'lucide-react';
import type { Agent, Driver } from '@/types';
import { getDriversByAgent } from '@/data/mockData';
import { cn } from '@/lib/utils';

interface AgentPanelProps {
  agents: Agent[];
  drivers: Driver[];
  onAgentSelect?: (agent: Agent) => void;
  selectedAgentId?: string | null;
}

export default function AgentPanel({ 
  agents, 
  onAgentSelect,
  selectedAgentId 
}: AgentPanelProps) {
  const [activeTab, setActiveTab] = useState('semua');

  const getStatusColor = (status: Agent['status']) => {
    switch (status) {
      case 'Aktif':
        return 'bg-green-100 text-green-700 border-green-200';
      case 'Nonaktif':
        return 'bg-gray-100 text-gray-700 border-gray-200';
      case 'Maintenance':
        return 'bg-yellow-100 text-yellow-700 border-yellow-200';
    }
  };

  const filteredAgents = agents.filter(a => {
    if (activeTab === 'semua') return true;
    if (activeTab === 'aktif') return a.status === 'Aktif';
    if (activeTab === 'maintenance') return a.status === 'Maintenance';
    return true;
  });

  const totalKapasitas = agents.reduce((acc, a) => acc + parseInt(a.kapasitas.replace(/\D/g, '')), 0);
  const totalArmada = agents.reduce((acc, a) => acc + a.armada, 0);

  return (
    <div className="space-y-6 animate-in fade-in duration-500">
      {/* Header */}
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-bold">Manajemen Agen Distribusi</h1>
          <p className="text-muted-foreground">
            Kelola {agents.length} agen distribusi di seluruh wilayah
          </p>
        </div>
        <Button className="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800">
          <Building2 className="h-4 w-4 mr-2" />
          Tambah Agen
        </Button>
      </div>

      {/* Summary Cards */}
      <div className="grid gap-4 md:grid-cols-4">
        <Card className="bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200">
          <CardContent className="p-6">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-sm text-blue-600 font-medium">Total Agen</p>
                <p className="text-3xl font-bold text-blue-900">{agents.length}</p>
              </div>
              <div className="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                <Building2 className="h-6 w-6 text-white" />
              </div>
            </div>
          </CardContent>
        </Card>

        <Card className="bg-gradient-to-br from-green-50 to-green-100 border-green-200">
          <CardContent className="p-6">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-sm text-green-600 font-medium">Total Kapasitas</p>
                <p className="text-3xl font-bold text-green-900">{totalKapasitas.toLocaleString()}</p>
                <p className="text-xs text-green-600">porsi/hari</p>
              </div>
              <div className="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center shadow-lg shadow-green-500/30">
                <Utensils className="h-6 w-6 text-white" />
              </div>
            </div>
          </CardContent>
        </Card>

        <Card className="bg-gradient-to-br from-orange-50 to-orange-100 border-orange-200">
          <CardContent className="p-6">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-sm text-orange-600 font-medium">Total Armada</p>
                <p className="text-3xl font-bold text-orange-900">{totalArmada}</p>
                <p className="text-xs text-orange-600">kendaraan</p>
              </div>
              <div className="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/30">
                <Truck className="h-6 w-6 text-white" />
              </div>
            </div>
          </CardContent>
        </Card>

        <Card className="bg-gradient-to-br from-purple-50 to-purple-100 border-purple-200">
          <CardContent className="p-6">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-sm text-purple-600 font-medium">Agen Aktif</p>
                <p className="text-3xl font-bold text-purple-900">
                  {agents.filter(a => a.status === 'Aktif').length}
                </p>
                <p className="text-xs text-purple-600">
                  {Math.round((agents.filter(a => a.status === 'Aktif').length / agents.length) * 100)}% operasional
                </p>
              </div>
              <div className="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/30">
                <TrendingUp className="h-6 w-6 text-white" />
              </div>
            </div>
          </CardContent>
        </Card>
      </div>

      {/* Tabs and Content */}
      <Tabs value={activeTab} onValueChange={setActiveTab} className="w-full">
        <TabsList className="grid w-full max-w-md grid-cols-3">
          <TabsTrigger value="semua">Semua Agen</TabsTrigger>
          <TabsTrigger value="aktif">Aktif</TabsTrigger>
          <TabsTrigger value="maintenance">Maintenance</TabsTrigger>
        </TabsList>

        <TabsContent value={activeTab} className="mt-6">
          <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            {filteredAgents.map((agent) => {
              const isSelected = selectedAgentId === agent.id;
              const agentDrivers = getDriversByAgent(agent.id);
              const activeDrivers = agentDrivers.filter(d => d.status === 'Sedang Mengantar').length;

              return (
                <Card 
                  key={agent.id}
                  onClick={() => onAgentSelect?.(agent)}
                  className={cn(
                    "cursor-pointer transition-all duration-300 hover:shadow-xl group",
                    isSelected 
                      ? "ring-2 ring-blue-500 shadow-lg" 
                      : "hover:scale-[1.02]"
                  )}
                >
                  <CardHeader className="pb-3">
                    <div className="flex items-start justify-between">
                      <div className="flex items-center gap-3">
                        <div className="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                          <Building2 className="h-6 w-6 text-white" />
                        </div>
                        <div>
                          <CardTitle className="text-lg">{agent.nama}</CardTitle>
                          <p className="text-xs text-muted-foreground">{agent.id}</p>
                        </div>
                      </div>
                      <Badge className={getStatusColor(agent.status)}>
                        {agent.status}
                      </Badge>
                    </div>
                  </CardHeader>
                  <CardContent className="space-y-4">
                    <div className="space-y-2">
                      <div className="flex items-start gap-2 text-sm">
                        <MapPin className="h-4 w-4 text-muted-foreground mt-0.5" />
                        <span className="text-muted-foreground">{agent.alamat}</span>
                      </div>
                      <div className="flex items-center gap-2 text-sm">
                        <Phone className="h-4 w-4 text-muted-foreground" />
                        <span className="text-muted-foreground">{agent.telepon}</span>
                      </div>
                      <div className="flex items-center gap-2 text-sm">
                        <User className="h-4 w-4 text-muted-foreground" />
                        <span className="text-muted-foreground">{agent.penanggungJawab}</span>
                      </div>
                    </div>

                    <div className="grid grid-cols-3 gap-2 pt-3 border-t">
                      <div className="text-center">
                        <p className="text-lg font-bold text-blue-600">{agent.armada}</p>
                        <p className="text-xs text-muted-foreground">Armada</p>
                      </div>
                      <div className="text-center border-x">
                        <p className="text-lg font-bold text-green-600">
                          {parseInt(agent.kapasitas.replace(/\D/g, '')).toLocaleString()}
                        </p>
                        <p className="text-xs text-muted-foreground">Kapasitas</p>
                      </div>
                      <div className="text-center">
                        <p className="text-lg font-bold text-orange-600">{activeDrivers}</p>
                        <p className="text-xs text-muted-foreground">Aktif</p>
                      </div>
                    </div>

                    <div className="pt-2">
                      <p className="text-xs text-muted-foreground mb-2">Coverage Area:</p>
                      <div className="flex flex-wrap gap-1">
                        {agent.coverage.map((area, idx) => (
                          <Badge key={idx} variant="secondary" className="text-xs">
                            {area}
                          </Badge>
                        ))}
                      </div>
                    </div>

                    <Button variant="ghost" className="w-full group-hover:bg-blue-50">
                      Lihat Detail
                      <ChevronRight className="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform" />
                    </Button>
                  </CardContent>
                </Card>
              );
            })}
          </div>
        </TabsContent>
      </Tabs>

      {/* Coverage Map Preview */}
      <Card className="mt-6">
        <CardHeader>
          <CardTitle className="flex items-center gap-2">
            <Navigation className="h-5 w-5 text-blue-600" />
            Peta Sebaran Agen
          </CardTitle>
        </CardHeader>
        <CardContent>
          <div className="bg-gray-100 rounded-xl h-64 flex items-center justify-center">
            <div className="text-center text-muted-foreground">
              <MapPin className="h-12 w-12 mx-auto mb-2 opacity-50" />
              <p>Peta interaktif sebaran agen</p>
              <p className="text-sm">Klik pada card agen untuk melihat lokasi detail</p>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  );
}
