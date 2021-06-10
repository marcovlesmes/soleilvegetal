<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Autor;
use App\Models\CartItem;
use App\Models\Technique;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $autor_id = $request->autor;
        if ($request->autor == 'new') {
            $autor = new Autor();
            $autor->name = $request->new_artist;
            $autor->created_at = Carbon::now();
            $autor->save();
            $autor_id = $autor->id;
        }

        $technique_id = $request->technique;
        if ($request->technique == 'new') {
            $technique = new Technique();
            $technique->name = $request->new_technique;
            $technique->created_at = Carbon::now();
            $technique->save();
            $technique_id = $technique->id;
        }

        $item = new Artwork();
        $item->name = $request->name;
        $item->year = $request->year;
        $item->format = $request->format;
        $item->edition = $request->edition;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->exposed = $request->exposed == 'on' ? true: false;
        $item->created_at = Carbon::now();
        $item->save();

        $item->autor()->sync([$autor_id]);
        $item->technique()->sync([$technique_id]);
        

        return redirect()->route('artworks.list');
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
        $next = collect(['action' => route('artworks.update', $id), 'method' => 'PUT']);
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
        $autor_id = $request->autor;
        if ($request->autor == 'new') {
            $autor = new Autor();
            $autor->name = $request->new_artist;
            $autor->created_at = Carbon::now();
            $autor->save();
            $autor_id = $autor->id;
        }

        $technique_id = $request->technique;
        if ($request->technique == 'new') {
            $technique = new Technique();
            $technique->name = $request->new_technique;
            $technique->created_at = Carbon::now();
            $technique->save();
            $technique_id = $technique->id;
        }

        $item = Artwork::find($id);
        $item->name = $request->name;
        $item->year = $request->year;
        $item->format = $request->format;
        $item->edition = $request->edition;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->exposed = $request->exposed == 'on' ? true: false;
        $item->updated_at = Carbon::now();
        $item->save();

        $item->autor()->sync([$autor_id]);
        $item->technique()->sync([$technique_id]);
        
        return redirect()->route('artworks.list');
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
