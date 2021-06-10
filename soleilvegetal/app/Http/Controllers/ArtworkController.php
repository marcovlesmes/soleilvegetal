<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Autor;
use App\Models\CartItem;
use App\Models\Technique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $autors = Autor::paginate(10);
        $items = Artwork::where('exposed', '=', true)->paginate(20);
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
        return view('home', compact('autors', 'items', 'cart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Nueva Obra';
        $artists = Autor::get();
        $techniques = Technique::get();
        $item = new Artwork();
        $next = collect(['action' => route('artworks.store'), 'method' => 'POST']);
        return view('admin.artworks.create', compact('title', 'artists', 'techniques', 'item', 'next'));
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
        $item = Artwork::find($id);
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

        return view('detail', compact('item', 'cart'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Nueva Obra';
        $artists = Autor::get();
        $techniques = Technique::get();
        $item = Artwork::find($id);
        $next = collect(['action' => route('artworks.update', $id), 'method' => 'PUT/PATCH']);
        return view('admin.artworks.create', compact('title', 'artists', 'techniques', 'item', 'next'));
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

    public function list() {
        $title = 'Obras';
        $items = Artwork::paginate(20);
        return view('admin.artworks.list', compact('title', 'items'));
    }
}
