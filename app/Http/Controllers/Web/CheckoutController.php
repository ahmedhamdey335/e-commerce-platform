<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        $user = Auth::user();
        $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect('/cart')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $addresses = Address::where('user_id', $user->id)->get();

        return view('checkout.index', compact('cartItems', 'subtotal', 'addresses'));
    }

    /**
     * Process the checkout and create an order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'nullable|exists:addresses,id',
            'new_address' => 'required_without:address_id|string|max:255',
            'city' => 'required_without:address_id|string|max:255',
            'postal_code' => 'required_without:address_id|string|max:20',
            'country' => 'required_without:address_id|string|max:255',
        ]);

        $user = Auth::user();
        $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect('/cart')->with('error', 'Your cart is empty.');
        }

        // Determine final shipping address string
        if ($request->address_id) {
            $addressModel = Address::where('user_id', $user->id)->findOrFail($request->address_id);
            $shippingAddress = "{$addressModel->address}, {$addressModel->city}, {$addressModel->postal_code}, {$addressModel->country}";
        } else {
            $shippingAddress = "{$request->new_address}, {$request->city}, {$request->postal_code}, {$request->country}";
            // Optionally save this new address for the user
            if ($request->boolean('save_address')) {
                Address::create([
                    'user_id' => $user->id,
                    'title' => 'Home',
                    'address' => $request->new_address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'country' => $request->country,
                ]);
            }
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        $totalPrice = $subtotal + 5.00 + ($subtotal * 0.1); // Shipping + Tax

        DB::beginTransaction();

        try {
            // Check stock before creating order
            foreach ($cartItems as $item) {
                if ($item->quantity > $item->product->stock) {
                    throw new \Exception("Product '{$item->product->name}' does not have enough stock.");
                }
            }

            // Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'address' => $shippingAddress,
            ]);

            // Create Order Items and Update Stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Deduct stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear Cart
            CartItem::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect('/checkout/success')->with('order_id', $order->id);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/cart')->with('error', $e->getMessage());
        }
    }

    /**
     * Display order success page.
     */
    public function success()
    {
        if (!session('order_id')) {
            return redirect('/');
        }
        return view('checkout.success');
    }
}
