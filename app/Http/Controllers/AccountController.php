<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $orders = Order::with('product')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(8);

        $stats = [
            'total' => Order::where('user_id', $user->id)->count(),
            'pending' => Order::where('user_id', $user->id)
                ->where('status', 'menunggu')->count(),
            'processing' => Order::where('user_id', $user->id)
                ->where('status', 'diproses')->count(),
            'completed' => Order::where('user_id', $user->id)
                ->where('status', 'selesai')->count(),
        ];

        return view('account.index', compact(
            'user',
            'orders',
            'stats'
        ));
    }

    public function showOrder(Request $request, int $id): View
    {
        $order = Order::with('product')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return view('account.order-detail', compact('order'));
    }

    public function readNotification(
        Request $request,
        string $id
    ): RedirectResponse {
        $notification = $request->user()
            ->notifications()
            ->whereKey($id)
            ->firstOrFail();

        $notification->markAsRead();

        $orderId = $notification->data['order_id'] ?? null;

        if ($orderId) {
            return redirect()->route(
                'account.orders.show',
                $orderId
            );
        }

        return redirect()->route('account.index');
    }

    // CEK NOTIFIKASI TERBARU
    public function notificationStatus(Request $request): JsonResponse
    {
        $user = $request->user();

        $latestNotification = $user->notifications()
            ->latest()
            ->first();

        return response()->json([
            'unread_count' => $user->unreadNotifications()->count(),

            'latest' => $latestNotification ? [
                'id' => $latestNotification->id,
                'message' => $latestNotification->data['message']
                    ?? 'Ada pembaruan pesanan Anda.',
                'order_id' => $latestNotification->data['order_id'] ?? null,
            ] : null,
        ]);
    }
}
