<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart', compact('cart'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request)
    {
        $cart = Session::get('cart', []);
        $product_id = $request->product_id;

        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] += $request->quantity;
        } else {
            $cart[$product_id] = [
                'name' => $request->product_name,
                'price' => $request->price,
                'quantity' => $request->quantity
            ];
        }

        Session::put('cart', $cart);
        return redirect()->route('cart.index');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($id)
    {
        $cart = Session::get('cart', []);
        unset($cart[$id]);
        Session::put('cart', $cart);
        return redirect()->route('cart.index');
    }

    // Cập nhật số lượng sản phẩm
    public function updateCart(Request $request)
    {
        $cart = Session::get('cart', []);
        foreach ($request->quantities as $id => $quantity) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = max(1, $quantity);
            }
        }
        Session::put('cart', $cart);
        return redirect()->route('cart.index');
    }
}
