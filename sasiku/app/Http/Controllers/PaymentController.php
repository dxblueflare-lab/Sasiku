<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Display payment page for an order
     */
    public function index(Order $order): View
    {
        // Verify ownership
        if (auth()->id() !== $order->user_id) {
            abort(403);
        }

        // Check if order is already paid
        if (in_array($order->status, ['diproses', 'dikirim', 'selesai'])) {
            return redirect()->route('customer.orders.show', $order)
                ->with('info', 'Pesanan ini sudah dibayar.');
        }

        $order->load('items');

        return view('payment', compact('order'));
    }

    /**
     * Process payment (dummy implementation)
     */
    public function process(Request $request, Order $order): JsonResponse
    {
        // Verify ownership
        if (auth()->id() !== $order->user_id) {
            abort(403);
        }

        // Check if order is already paid
        if (in_array($order->status, ['diproses', 'dikirim', 'selesai'])) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan ini sudah dibayar.',
            ], 400);
        }

        $paymentMethod = $request->input('payment_method');

        // Simulate payment processing delay
        sleep(2);

        // Update order status
        $order->update([
            'status' => 'diproses',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil!',
            'redirect' => route('payment.success', $order),
        ]);
    }

    /**
     * Display payment success page
     */
    public function success(Order $order): View
    {
        // Verify ownership
        if (auth()->id() !== $order->user_id) {
            abort(403);
        }

        $order->load('items');

        return view('payment-success', compact('order'));
    }
}
