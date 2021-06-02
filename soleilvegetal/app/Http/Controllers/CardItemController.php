<?php

namespace App\Http\Controllers;

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
            'id' => Rule::unique('cart_items')->where(function($query) {
                return $query->where('user_id', '=', Auth()->user()->id);
            })
        ], ['id.unique' => 'Ya existe este articulo en el carro de compras.'])->validate();
        $cartItem = new CartItem();
        $cartItem->artwork_id = $request->id;
        $cartItem->user_id = Auth()->user()->id;
        $cartItem->quantity = 1;
        $cartItem->created_at = Carbon::now();
        $cartItem->save();

        return redirect()->route('artworks.index');
    }

    public function destroy(Request $request) {
        CartItem::where('id', '=', $request->id)->delete();
        return redirect()->route('artworks.index');
    }

    public function checkout(Request $request) {
        // Check what is in the cart
        // Create a view
        dd($request->all());
    }

    public function create_order() {
        // Create order
        // PayU integration
        // Clean cart
    }
}
