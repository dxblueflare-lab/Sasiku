<table>
    <thead>
        <tr>
            <th>ID Pesanan</th>
            <th>Nama Pelanggan</th>
            <th>Email</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status</th>
            <th>Metode Pembayaran</th>
            <th>Nama Penerima</th>
            <th>Alamat Pengiriman</th>
            <th>No. Telepon</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->user->name ?? '-' }}</td>
            <td>{{ $order->user->email ?? '-' }}</td>
            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>{{ $order->payment_method ?? '-' }}</td>
            <td>{{ $order->shipping_name ?? '-' }}</td>
            <td>{{ $order->shipping_address ?? '-' }}</td>
            <td>{{ $order->shipping_phone ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>