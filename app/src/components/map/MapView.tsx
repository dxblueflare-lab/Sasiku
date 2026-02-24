import { useEffect, useState, useRef } from 'react';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import type { Agent, Driver, Pesantren, Pengiriman } from '@/types';

// Fix Leaflet default marker icons
import icon from 'leaflet/dist/images/marker-icon.png';
import iconShadow from 'leaflet/dist/images/marker-shadow.png';

let DefaultIcon = L.icon({
  iconUrl: icon,
  shadowUrl: iconShadow,
  iconSize: [25, 41],
  iconAnchor: [12, 41]
});

L.Marker.prototype.options.icon = DefaultIcon;

interface MapViewProps {
  agents?: Agent[];
  drivers?: Driver[];
  pesantren?: Pesantren[];
  pengiriman?: Pengiriman[];
  selectedAgent?: string | null;
  selectedDriver?: string | null;
  selectedPesantren?: string | null;
  showRoutes?: boolean;
  height?: string;
  onAgentClick?: (agent: Agent) => void;
  onDriverClick?: (driver: Driver) => void;
  onPesantrenClick?: (pesantren: Pesantren) => void;
}

export default function MapView({
  agents = [],
  drivers = [],
  pesantren = [],
  pengiriman = [],
  selectedAgent = null,
  selectedDriver = null,
  selectedPesantren = null,
  showRoutes = true,
  height = '600px',
  onAgentClick,
  onDriverClick,
  onPesantrenClick
}: MapViewProps) {
  const mapRef = useRef<L.Map | null>(null);
  const mapContainerRef = useRef<HTMLDivElement>(null);
  const markersRef = useRef<L.LayerGroup | null>(null);
  const routesRef = useRef<L.LayerGroup | null>(null);
  const [isInitialized, setIsInitialized] = useState(false);

  // Initialize map
  useEffect(() => {
    if (mapContainerRef.current && !mapRef.current) {
      const map = L.map(mapContainerRef.current).setView([-7.5, 112.5], 8);
      
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
      }).addTo(map);

      markersRef.current = L.layerGroup().addTo(map);
      routesRef.current = L.layerGroup().addTo(map);
      mapRef.current = map;
      setIsInitialized(true);
    }

    return () => {
      if (mapRef.current) {
        mapRef.current.remove();
        mapRef.current = null;
        markersRef.current = null;
        routesRef.current = null;
      }
    };
  }, []);

  // Update markers
  useEffect(() => {
    if (!isInitialized || !markersRef.current || !mapRef.current) return;

    markersRef.current.clearLayers();

    // Agent markers - Blue
    agents.forEach(agent => {
      const isSelected = selectedAgent === agent.id;
      const marker = L.circleMarker([agent.koordinat.lat, agent.koordinat.lng], {
        radius: isSelected ? 15 : 10,
        fillColor: '#3b82f6',
        color: '#1d4ed8',
        weight: isSelected ? 3 : 2,
        opacity: 1,
        fillOpacity: 0.8
      });

      const popupContent = `
        <div style="min-width: 200px;">
          <h3 style="margin: 0 0 8px 0; font-weight: bold; color: #1d4ed8;">${agent.nama}</h3>
          <p style="margin: 4px 0; font-size: 12px;"><strong>Alamat:</strong> ${agent.alamat}</p>
          <p style="margin: 4px 0; font-size: 12px;"><strong>Kapasitas:</strong> ${agent.kapasitas}</p>
          <p style="margin: 4px 0; font-size: 12px;"><strong>Armada:</strong> ${agent.armada} kendaraan</p>
          <p style="margin: 4px 0; font-size: 12px;"><strong>Status:</strong> <span style="color: ${agent.status === 'Aktif' ? '#22c55e' : '#ef4444'};">${agent.status}</span></p>
        </div>
      `;

      marker.bindPopup(popupContent);
      marker.on('click', () => onAgentClick?.(agent));
      markersRef.current?.addLayer(marker);
    });

    // Driver markers - Green with pulse effect for active
    drivers.forEach(driver => {
      if (!driver.lokasi) return;
      const isSelected = selectedDriver === driver.id;
      const isActive = driver.status === 'Sedang Mengantar';
      
      const marker = L.circleMarker([driver.lokasi.lat, driver.lokasi.lng], {
        radius: isSelected ? 12 : 8,
        fillColor: isActive ? '#22c55e' : '#6b7280',
        color: isActive ? '#16a34a' : '#4b5563',
        weight: isSelected ? 3 : 2,
        opacity: 1,
        fillOpacity: 0.9
      });

      const popupContent = `
        <div style="min-width: 200px;">
          <h3 style="margin: 0 0 8px 0; font-weight: bold; color: ${isActive ? '#16a34a' : '#4b5563'};">${driver.nama}</h3>
          <p style="margin: 4px 0; font-size: 12px;"><strong>Plat:</strong> ${driver.platNomor}</p>
          <p style="margin: 4px 0; font-size: 12px;"><strong>Kendaraan:</strong> ${driver.jenisKendaraan}</p>
          <p style="margin: 4px 0; font-size: 12px;"><strong>Kapasitas:</strong> ${driver.kapasitasKendaraan} porsi</p>
          <p style="margin: 4px 0; font-size: 12px;"><strong>Status:</strong> <span style="color: ${isActive ? '#22c55e' : '#6b7280'};">${driver.status}</span></p>
          <p style="margin: 4px 0; font-size: 12px;"><strong>Rating:</strong> ⭐ ${driver.rating}</p>
        </div>
      `;

      marker.bindPopup(popupContent);
      marker.on('click', () => onDriverClick?.(driver));
      markersRef.current?.addLayer(marker);
    });

    // Pesantren markers - Orange
    pesantren.forEach(p => {
      if (!p.koordinat) return;
      const isSelected = selectedPesantren === p.id;
      const marker = L.circleMarker([p.koordinat.lat, p.koordinat.lng], {
        radius: isSelected ? 10 : 6,
        fillColor: p.beroperasi ? '#f97316' : '#9ca3af',
        color: p.beroperasi ? '#ea580c' : '#6b7280',
        weight: isSelected ? 3 : 2,
        opacity: 1,
        fillOpacity: 0.8
      });

      const popupContent = `
        <div style="min-width: 200px;">
          <h3 style="margin: 0 0 8px 0; font-weight: bold; color: ${p.beroperasi ? '#ea580c' : '#6b7280'};">${p.nama}</h3>
          <p style="margin: 4px 0; font-size: 12px;"><strong>Yayasan:</strong> ${p.yayasan}</p>
          <p style="margin: 4px 0; font-size: 12px;"><strong>Alamat:</strong> ${p.desa}, ${p.kecamatan}, ${p.kabupaten}</p>
          <p style="margin: 4px 0; font-size: 12px;"><strong>Relawan:</strong> ${p.jumlahRelawan} orang</p>
          <p style="margin: 4px 0; font-size: 12px;"><strong>Penerima Manfaat:</strong> ${p.jumlahPenerimaManfaat.toLocaleString()} orang</p>
          <p style="margin: 4px 0; font-size: 12px;"><strong>Status:</strong> <span style="color: ${p.beroperasi ? '#22c55e' : '#ef4444'};">${p.beroperasi ? 'Beroperasi' : 'Belum Beroperasi'}</span></p>
        </div>
      `;

      marker.bindPopup(popupContent);
      marker.on('click', () => onPesantrenClick?.(p));
      markersRef.current?.addLayer(marker);
    });

  }, [agents, drivers, pesantren, selectedAgent, selectedDriver, selectedPesantren, isInitialized, onAgentClick, onDriverClick, onPesantrenClick]);

  // Update routes
  useEffect(() => {
    if (!isInitialized || !routesRef.current || !mapRef.current) return;

    routesRef.current.clearLayers();

    if (showRoutes && pengiriman.length > 0) {
      pengiriman.forEach(p => {
        if (p.rute && p.rute.length >= 2) {
          const latlngs = p.rute.map(r => [r.lat, r.lng] as L.LatLngExpression);
          const polyline = L.polyline(latlngs, {
            color: p.status === 'Selesai' ? '#22c55e' : p.status === 'Dalam Perjalanan' ? '#3b82f6' : '#f59e0b',
            weight: 3,
            opacity: 0.7,
            dashArray: p.status === 'Dalam Perjalanan' ? '10, 10' : undefined
          });
          
          polyline.bindPopup(`
            <div style="min-width: 150px;">
              <p style="margin: 0; font-weight: bold;">${p.kodePengiriman}</p>
              <p style="margin: 4px 0; font-size: 12px;">Status: ${p.status}</p>
              <p style="margin: 4px 0; font-size: 12px;">Jarak: ${p.jarak} km</p>
            </div>
          `);
          
          routesRef.current?.addLayer(polyline);
        }
      });
    }
  }, [pengiriman, showRoutes, isInitialized]);

  // Fit bounds to show all markers
  useEffect(() => {
    if (!isInitialized || !mapRef.current) return;

    const allPoints: L.LatLngExpression[] = [];
    agents.forEach(a => allPoints.push([a.koordinat.lat, a.koordinat.lng]));
    drivers.forEach(d => d.lokasi && allPoints.push([d.lokasi.lat, d.lokasi.lng]));
    pesantren.forEach(p => p.koordinat && allPoints.push([p.koordinat.lat, p.koordinat.lng]));

    if (allPoints.length > 0) {
      const bounds = L.latLngBounds(allPoints);
      mapRef.current.fitBounds(bounds, { padding: [50, 50] });
    }
  }, [agents, drivers, pesantren, isInitialized]);

  return (
    <div 
      ref={mapContainerRef} 
      style={{ height, width: '100%', borderRadius: '8px' }}
      className="shadow-lg"
    />
  );
}
