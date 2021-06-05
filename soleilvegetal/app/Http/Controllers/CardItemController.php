<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Artwork;
use App\Models\Autor;
use App\Models\CartItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CardItemController extends Controller
{
    public function store(Request $request) {
        if (!Auth()->check()) {
            return redirect()->route('login');
        }

        Validator::make($request->all(), [
            'id' => 'unique:cart_items,artwork_id,NULL,id,user_id,' . Auth()->user()->id
        ], ['id.unique' => 'Ya existe este articulo en el carro de compras.'])->validate();
        $cartItem = new CartItem();
        $cartItem->artwork_id = $request->id;
        $cartItem->user_id = Auth()->user()->id;
        $cartItem->quantity = 1;
        $cartItem->created_at = Carbon::now();
        $cartItem->save();

        $request->session()->put('cart-open', true);
        return redirect()->route('artworks.index');
    }

    public function destroy(Request $request, $id) {
        CartItem::where('id', '=', $request->id)
                ->where('user_id', '=', $id)
                ->delete();
        $request->session()->put('cart-open', false);
        return redirect()->route('artworks.index');
    }

    public function checkout(Request $request) {
        // Check what is in the cart
        $user_id = Auth::user()->id;
        $items = CartItem::where('user_id', '=', $user_id)->get();
        $subtotal = $items->sum(function($item){
            return $item->artwork->price;
        });
        $items->subtotal = $subtotal;
        // Check user address
        $addresses = Address::where('user_id', '=', $user_id)->get();
        // Create a view
        return view('checkout', compact('items', 'addresses'));
    }

    public function create_order() {
        // Create order
        // PayU integration
        // Clean cart
    }
}
