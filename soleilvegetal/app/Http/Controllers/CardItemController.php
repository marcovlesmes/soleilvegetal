<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Artwork;
use App\Models\Autor;
use App\Models\CartItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CardItemController extends Controller
{
    private function createOrder($items) {
        $items_id = $items->map(function ($item) {
            return $item['id'];
        });
        $referenceCode = 'U' . Auth()->user()->id . 'D' . Carbon::now()->format('YmdHis') . 'I' . $items_id->implode('I');
        $signature = md5(config('apikey') . '~' . config('merchant') . '~' . $referenceCode . '~' . $items->subtotal . '~COP');
        
        $order = collect([]);
        $order->put('merchantId', config('app.payu.merchant'))
              ->put('accountId', config('app.payu.account'))
              ->put('description', 'Pago en tienda virtual')
              ->put('referenceCode', $referenceCode)
              ->put('amount', $items->subtotal)
              ->put('tax', 0)
              ->put('taxReturnBase', 0)
              ->put('currency', 'COP')
              ->put('signature', $signature)
              ->put('test', '0')
              ->put('buyerEmail', Auth()->user()->email)
              ->put('responseUrl', route('confirmation'))
              ->put('confirmationUrl', route('response'));
        return $order;
    }

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
        // Create order
        $order = $this->createOrder($items);
        return view('checkout', compact('items', 'addresses', 'order'));
    }

    public function payuConfirmation(Request $request) {
        return view('confirmation');
    }

    public function payuResponse(Request $request) {
        // save response
        // Clean cart
    }
}
