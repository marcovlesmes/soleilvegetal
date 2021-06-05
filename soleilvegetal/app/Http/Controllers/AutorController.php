<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use App\Models\CartItem;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $autor = Autor::find($id);
        $items = $autor->artwork->where('exposed', '=', true);
        $autors = Autor::paginate(10);
        $cart = collect([]);
        if (Auth()->check()) {
            $cart = CartItem::where('user_id', '=', Auth()->user()->id)->get();
            $subtotal = $cart->sum(function($item){
                return $item->artwork->price;
            });
            $cart->subtotal = $subtotal;
            $cart->open = $request->session()->get('cart-open') ? 'true' : 'false';
        }
        return view('home', compact('autors', 'items', 'cart'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
