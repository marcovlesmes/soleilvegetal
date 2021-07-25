<?php

namespace App\Http\Controllers;

use \App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use stdClass;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $items = DB::table('carousel')->where('active', '=', true)->get();
        $autors = DB::table('autors')->get();
        $cart = collect([]);
        $cart->open = 'false';
        if (Auth()->check()) {
            $cart = CartItem::where('user_id', '=', Auth()->user()->id)->get();
            $subtotal = $cart->sum(function($item){
                return $item->artwork->price;
            });
            $cart->subtotal = $subtotal;
            $cart->open = $request->session()->get('cart-open') ? 'true' : 'false';
        }
        return view('welcome', compact('autors', 'items', 'cart'));
    }

    public function set_language($language) {
        if (! in_array($language, ['en', 'es'])) {
            abort(400);
        }
        App::setLocale($language);
        
        return redirect()->route('index');
    }
}
