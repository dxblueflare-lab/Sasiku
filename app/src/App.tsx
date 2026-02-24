import { useState, useEffect } from 'react';
import { 
  LayoutDashboard, 
  Map, 
  Truck, 
  FileText, 
  Bell, 
  Settings,
  Menu,
  X,
  LogOut,
  User,
  ChevronDown,
  Building2,
  Package,
  TrendingUp,
  MapPin
} from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { cn } from '@/lib/utils';

// Components
import MapView from '@/components/map/MapView';
import DashboardStats from '@/components/dashboard/DashboardStats';
import DriverMonitor from '@/components/dashboard/DriverMonitor';
import PengirimanList from '@/components/pengiriman/PengirimanList';
import NotificationPanel from '@/components/dashboard/NotificationPanel';
import LaporanPanel from '@/components/laporan/LaporanPanel';
import AgentPanel from '@/components/agen/AgentPanel';

// Data
import { 
  agents,
  drivers, 
  pesantrenList, 
  pengirimanList, 
  notifikasiList,
  dashboardStats 
} from '@/data/mockData';

// Types
import type { Notifikasi } from '@/types';

type ViewType = 'dashboard' | 'map' | 'drivers' | 'pengiriman' | 'laporan' | 'agen';

function App() {
  const [currentView, setCurrentView] = useState<ViewType>('dashboard');
  const [sidebarOpen, setSidebarOpen] = useState(true);
  const [selectedAgent, setSelectedAgent] = useState<string | null>(null);
  const [selectedDriver, setSelectedDriver] = useState<string | null>(null);
  const [selectedPesantren, setSelectedPesantren] = useState<string | null>(null);
  const [selectedPengiriman, setSelectedPengiriman] = useState<string | null>(null);
  const [notifications, setNotifications] = useState<Notifikasi[]>(notifikasiList);
  const [currentTime, setCurrentTime] = useState(new Date());

  // Update time every minute
  useEffect(() => {
    const timer = setInterval(() => {
      setCurrentTime(new Date());
    }, 60000);
    return () => clearInterval(timer);
  }, []);

  const unreadNotifications = notifications.filter(n => !n.dibaca).length;

  const handleMarkAsRead = (id: string) => {
    setNotifications(prev => 
      prev.map(n => n.id === id ? { ...n, dibaca: true } : n)
    );
  };

  const handleMarkAllAsRead = () => {
    setNotifications(prev => 
      prev.map(n => ({ ...n, dibaca: true }))
    );
  };

  const handleClearNotification = (id: string) => {
    setNotifications(prev => prev.filter(n => n.id !== id));
  };

  const navItems = [
    { id: 'dashboard' as ViewType, label: 'Dashboard', icon: LayoutDashboard },
    { id: 'map' as ViewType, label: 'Peta Distribusi', icon: Map },
    { id: 'agen' as ViewType, label: 'Manajemen Agen', icon: Building2 },
    { id: 'drivers' as ViewType, label: 'Monitoring Driver', icon: Truck },
    { id: 'pengiriman' as ViewType, label: 'Pengiriman', icon: Package },
    { id: 'laporan' as ViewType, label: 'Laporan', icon: FileText },
  ];

  const renderContent = () => {
    switch (currentView) {
      case 'dashboard':
        return (
          <div className="space-y-6 animate-in fade-in duration-500">
            {/* Header Section */}
            <div className="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white p-8">
              <div className="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl" />
              <div className="absolute bottom-0 left-0 w-48 h-48 bg-blue-400/20 rounded-full translate-y-1/2 -translate-x-1/2 blur-2xl" />
              <div className="relative z-10">
                <div className="flex items-center justify-between">
                  <div>
                    <h1 className="text-3xl font-bold mb-2">Dashboard Monitoring SPPG</h1>
                    <p className="text-blue-100">
                      {currentTime.toLocaleDateString('id-ID', { 
                        weekday: 'long', 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric' 
                      })}
                    </p>
                  </div>
                  <div className="flex items-center gap-3">
                    <Badge className="bg-green-500/20 text-green-100 border-green-400/30 backdrop-blur">
                      <span className="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse" />
                      Sistem Aktif
                    </Badge>
                  </div>
                </div>
                
                {/* Quick Stats */}
                <div className="grid grid-cols-4 gap-4 mt-6">
                  <div className="bg-white/10 backdrop-blur rounded-xl p-4">
                    <div className="flex items-center gap-2 text-blue-100 mb-1">
                      <Building2 className="h-4 w-4" />
                      <span className="text-sm">Total Agen</span>
                    </div>
                    <p className="text-2xl font-bold">{agents.length}</p>
                  </div>
                  <div className="bg-white/10 backdrop-blur rounded-xl p-4">
                    <div className="flex items-center gap-2 text-blue-100 mb-1">
                      <Truck className="h-4 w-4" />
                      <span className="text-sm">Total Driver</span>
                    </div>
                    <p className="text-2xl font-bold">{drivers.length}</p>
                  </div>
                  <div className="bg-white/10 backdrop-blur rounded-xl p-4">
                    <div className="flex items-center gap-2 text-blue-100 mb-1">
                      <MapPin className="h-4 w-4" />
                      <span className="text-sm">Pesantren</span>
                    </div>
                    <p className="text-2xl font-bold">{pesantrenList.length}</p>
                  </div>
                  <div className="bg-white/10 backdrop-blur rounded-xl p-4">
                    <div className="flex items-center gap-2 text-blue-100 mb-1">
                      <TrendingUp className="h-4 w-4" />
                      <span className="text-sm">Kepuasan</span>
                    </div>
                    <p className="text-2xl font-bold">{dashboardStats.tingkatKepuasan}</p>
                  </div>
                </div>
              </div>
            </div>

            <DashboardStats stats={dashboardStats} />

            <div className="grid gap-6 lg:grid-cols-3">
              <div className="lg:col-span-2">
                <div className="bg-white rounded-xl shadow-sm border p-4">
                  <h3 className="font-semibold mb-4 flex items-center gap-2">
                    <Map className="h-5 w-5 text-blue-600" />
                    Peta Distribusi Real-Time
                  </h3>
                  <MapView 
                    agents={agents}
                    drivers={drivers}
                    pesantren={pesantrenList}
                    pengiriman={pengirimanList}
                    selectedAgent={selectedAgent}
                    selectedDriver={selectedDriver}
                    selectedPesantren={selectedPesantren}
                    showRoutes={true}
                    height="450px"
                    onAgentClick={(agent) => setSelectedAgent(agent.id)}
                    onDriverClick={(driver) => setSelectedDriver(driver.id)}
                    onPesantrenClick={(pesantren) => setSelectedPesantren(pesantren.id)}
                  />
                </div>
              </div>
              <div className="space-y-4">
                <NotificationPanel 
                  notifikasi={notifications}
                  onMarkAsRead={handleMarkAsRead}
                  onMarkAllAsRead={handleMarkAllAsRead}
                  onClear={handleClearNotification}
                />
              </div>
            </div>

            <div className="grid gap-6 lg:grid-cols-2">
              <DriverMonitor 
                drivers={drivers}
                onDriverSelect={(driver) => setSelectedDriver(driver.id)}
                selectedDriverId={selectedDriver}
              />
              <PengirimanList 
                pengiriman={pengirimanList}
                onPengirimanSelect={(p) => setSelectedPengiriman(p.id)}
                selectedPengirimanId={selectedPengiriman}
              />
            </div>
          </div>
        );

      case 'map':
        return (
          <div className="space-y-6 animate-in fade-in duration-500">
            <div className="flex items-center justify-between">
              <div>
                <h1 className="text-3xl font-bold">Peta Distribusi</h1>
                <p className="text-muted-foreground">
                  Pantau lokasi agen, driver, dan pesantren secara real-time
                </p>
              </div>
            </div>

            <div className="grid gap-6 lg:grid-cols-4">
              <div className="lg:col-span-3">
                <div className="bg-white rounded-xl shadow-sm border p-4">
                  <MapView 
                    agents={agents}
                    drivers={drivers}
                    pesantren={pesantrenList}
                    pengiriman={pengirimanList}
                    selectedAgent={selectedAgent}
                    selectedDriver={selectedDriver}
                    selectedPesantren={selectedPesantren}
                    showRoutes={true}
                    height="700px"
                    onAgentClick={(agent) => setSelectedAgent(agent.id)}
                    onDriverClick={(driver) => setSelectedDriver(driver.id)}
                    onPesantrenClick={(pesantren) => setSelectedPesantren(pesantren.id)}
                  />
                </div>
              </div>
              <div className="space-y-4">
                <div className="bg-white p-4 rounded-xl border shadow-sm">
                  <h3 className="font-semibold mb-3">Legenda</h3>
                  <div className="space-y-2 text-sm">
                    <div className="flex items-center gap-2">
                      <div className="w-4 h-4 rounded-full bg-blue-500 shadow-lg shadow-blue-500/30" />
                      <span>Agen Distribusi</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <div className="w-4 h-4 rounded-full bg-green-500 shadow-lg shadow-green-500/30" />
                      <span>Driver Aktif</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <div className="w-4 h-4 rounded-full bg-gray-500" />
                      <span>Driver Nonaktif</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <div className="w-4 h-4 rounded-full bg-orange-500 shadow-lg shadow-orange-500/30" />
                      <span>Pesantren Aktif</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <div className="w-4 h-4 rounded-full bg-gray-400" />
                      <span>Pesantren Nonaktif</span>
                    </div>
                  </div>
                </div>

                <div className="bg-white p-4 rounded-xl border shadow-sm">
                  <h3 className="font-semibold mb-3">Filter</h3>
                  <div className="space-y-2">
                    <label className="flex items-center gap-2 text-sm cursor-pointer hover:bg-gray-50 p-1 rounded">
                      <input type="checkbox" defaultChecked className="rounded text-blue-600" />
                      Tampilkan Agen
                    </label>
                    <label className="flex items-center gap-2 text-sm cursor-pointer hover:bg-gray-50 p-1 rounded">
                      <input type="checkbox" defaultChecked className="rounded text-blue-600" />
                      Tampilkan Driver
                    </label>
                    <label className="flex items-center gap-2 text-sm cursor-pointer hover:bg-gray-50 p-1 rounded">
                      <input type="checkbox" defaultChecked className="rounded text-blue-600" />
                      Tampilkan Pesantren
                    </label>
                    <label className="flex items-center gap-2 text-sm cursor-pointer hover:bg-gray-50 p-1 rounded">
                      <input type="checkbox" defaultChecked className="rounded text-blue-600" />
                      Tampilkan Rute
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        );

      case 'agen':
        return (
          <AgentPanel 
            agents={agents}
            drivers={drivers}
            onAgentSelect={(agent) => setSelectedAgent(agent.id)}
            selectedAgentId={selectedAgent}
          />
        );

      case 'drivers':
        return (
          <div className="space-y-6 animate-in fade-in duration-500">
            <div className="flex items-center justify-between">
              <div>
                <h1 className="text-3xl font-bold">Monitoring Driver</h1>
                <p className="text-muted-foreground">
                  Pantau lokasi dan status driver secara real-time
                </p>
              </div>
              <Button className="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800">
                <Truck className="h-4 w-4 mr-2" />
                Tambah Driver
              </Button>
            </div>

            <div className="grid gap-6 lg:grid-cols-3">
              <div className="lg:col-span-2">
                <div className="bg-white rounded-xl shadow-sm border p-4">
                  <MapView 
                    drivers={drivers}
                    pengiriman={pengirimanList}
                    selectedDriver={selectedDriver}
                    showRoutes={true}
                    height="600px"
                    onDriverClick={(driver) => setSelectedDriver(driver.id)}
                  />
                </div>
              </div>
              <div>
                <DriverMonitor 
                  drivers={drivers}
                  onDriverSelect={(driver) => setSelectedDriver(driver.id)}
                  selectedDriverId={selectedDriver}
                />
              </div>
            </div>
          </div>
        );

      case 'pengiriman':
        return (
          <div className="space-y-6 animate-in fade-in duration-500">
            <div className="flex items-center justify-between">
              <div>
                <h1 className="text-3xl font-bold">Daftar Pengiriman</h1>
                <p className="text-muted-foreground">
                  Kelola dan pantau semua pengiriman
                </p>
              </div>
              <Button className="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800">
                <Package className="h-4 w-4 mr-2" />
                Buat Pengiriman Baru
              </Button>
            </div>

            <div className="grid gap-6 lg:grid-cols-2">
              <PengirimanList 
                pengiriman={pengirimanList}
                onPengirimanSelect={(p) => setSelectedPengiriman(p.id)}
                selectedPengirimanId={selectedPengiriman}
              />
              <div className="space-y-4">
                <div className="bg-white rounded-xl shadow-sm border p-4">
                  <MapView 
                    pengiriman={pengirimanList}
                    showRoutes={true}
                    height="400px"
                  />
                </div>
                <NotificationPanel 
                  notifikasi={notifications}
                  onMarkAsRead={handleMarkAsRead}
                  onMarkAllAsRead={handleMarkAllAsRead}
                  onClear={handleClearNotification}
                />
              </div>
            </div>
          </div>
        );

      case 'laporan':
        return (
          <LaporanPanel pengiriman={pengirimanList} />
        );

      default:
        return null;
    }
  };

  return (
    <div className="min-h-screen bg-gray-50/50 flex">
      {/* Sidebar */}
      <aside 
        className={cn(
          "bg-white border-r transition-all duration-300 flex flex-col shadow-sm",
          sidebarOpen ? "w-72" : "w-20"
        )}
      >
        {/* Logo */}
        <div className="h-20 flex items-center justify-between px-4 border-b">
          {sidebarOpen && (
            <div className="flex items-center gap-3">
              <div className="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/20">
                <Truck className="h-5 w-5 text-white" />
              </div>
              <div>
                <span className="font-bold text-lg block leading-tight">SPPG</span>
                <span className="text-xs text-muted-foreground">Distribution</span>
              </div>
            </div>
          )}
          <Button 
            variant="ghost" 
            size="icon" 
            onClick={() => setSidebarOpen(!sidebarOpen)}
            className="hover:bg-gray-100"
          >
            {sidebarOpen ? <X className="h-4 w-4" /> : <Menu className="h-4 w-4" />}
          </Button>
        </div>

        {/* Navigation */}
        <nav className="flex-1 p-3 space-y-1">
          {navItems.map((item) => {
            const Icon = item.icon;
            const isActive = currentView === item.id;
            
            return (
              <button
                key={item.id}
                onClick={() => setCurrentView(item.id)}
                className={cn(
                  "w-full flex items-center gap-3 px-3 py-3 rounded-xl transition-all text-left",
                  isActive 
                    ? "bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-600/20" 
                    : "text-gray-600 hover:bg-gray-100",
                  !sidebarOpen && "justify-center px-2"
                )}
              >
                <Icon className="h-5 w-5 flex-shrink-0" />
                {sidebarOpen && (
                  <>
                    <span className="flex-1 font-medium">{item.label}</span>
                    {item.id === 'pengiriman' && unreadNotifications > 0 && (
                      <Badge className="bg-red-500 text-white text-xs">
                        {unreadNotifications}
                      </Badge>
                    )}
                  </>
                )}
              </button>
            );
          })}
        </nav>

        {/* Bottom Actions */}
        <div className="p-3 border-t space-y-1">
          <button
            className={cn(
              "w-full flex items-center gap-3 px-3 py-3 rounded-xl transition-colors text-left text-gray-600 hover:bg-gray-100",
              !sidebarOpen && "justify-center px-2"
            )}
          >
            <Settings className="h-5 w-5 flex-shrink-0" />
            {sidebarOpen && <span className="font-medium">Pengaturan</span>}
          </button>
          <button
            className={cn(
              "w-full flex items-center gap-3 px-3 py-3 rounded-xl transition-colors text-left text-red-600 hover:bg-red-50",
              !sidebarOpen && "justify-center px-2"
            )}
          >
            <LogOut className="h-5 w-5 flex-shrink-0" />
            {sidebarOpen && <span className="font-medium">Keluar</span>}
          </button>
        </div>
      </aside>

      {/* Main Content */}
      <main className="flex-1 flex flex-col min-w-0">
        {/* Header */}
        <header className="h-20 bg-white border-b flex items-center justify-between px-6 shadow-sm">
          <div className="flex items-center gap-4">
            <h2 className="text-xl font-semibold">
              {navItems.find(n => n.id === currentView)?.label}
            </h2>
          </div>

          <div className="flex items-center gap-4">
            {/* Notifications */}
            <DropdownMenu>
              <DropdownMenuTrigger asChild>
                <Button variant="ghost" size="icon" className="relative hover:bg-gray-100">
                  <Bell className="h-5 w-5" />
                  {unreadNotifications > 0 && (
                    <span className="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center animate-pulse">
                      {unreadNotifications}
                    </span>
                  )}
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent align="end" className="w-80">
                <DropdownMenuLabel>Notifikasi</DropdownMenuLabel>
                <DropdownMenuSeparator />
                <div className="max-h-64 overflow-auto">
                  {notifications.slice(0, 5).map((notif) => (
                    <DropdownMenuItem key={notif.id} className="flex flex-col items-start py-2">
                      <span className="font-medium text-sm">{notif.judul}</span>
                      <span className="text-xs text-muted-foreground">{notif.pesan}</span>
                    </DropdownMenuItem>
                  ))}
                </div>
              </DropdownMenuContent>
            </DropdownMenu>

            {/* User Profile */}
            <DropdownMenu>
              <DropdownMenuTrigger asChild>
                <Button variant="ghost" className="flex items-center gap-3 hover:bg-gray-100">
                  <Avatar className="h-9 w-9">
                    <AvatarFallback className="bg-gradient-to-br from-blue-600 to-indigo-700 text-white text-sm font-medium">
                      AD
                    </AvatarFallback>
                  </Avatar>
                  <div className="text-left hidden sm:block">
                    <p className="text-sm font-medium">Admin SPPG</p>
                    <p className="text-xs text-muted-foreground">admin@sppg.go.id</p>
                  </div>
                  <ChevronDown className="h-4 w-4 text-gray-400" />
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent align="end" className="w-56">
                <DropdownMenuLabel>Akun Saya</DropdownMenuLabel>
                <DropdownMenuSeparator />
                <DropdownMenuItem>
                  <User className="h-4 w-4 mr-2" />
                  Profil
                </DropdownMenuItem>
                <DropdownMenuItem>
                  <Settings className="h-4 w-4 mr-2" />
                  Pengaturan
                </DropdownMenuItem>
                <DropdownMenuSeparator />
                <DropdownMenuItem className="text-red-600">
                  <LogOut className="h-4 w-4 mr-2" />
                  Keluar
                </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          </div>
        </header>

        {/* Page Content */}
        <div className="flex-1 overflow-auto p-6">
          {renderContent()}
        </div>
      </main>
    </div>
  );
}

export default App;
