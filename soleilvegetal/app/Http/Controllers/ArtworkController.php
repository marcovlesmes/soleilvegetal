<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Autor;
use App\Models\CartItem;
use App\Models\Image;
use App\Models\Technique;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ArtworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if ($language = Session::get('locale')) {
            App::setLocale($language);
        }
        $autorsFiltered = $request->autors;
        $validator = Validator::make(
            [
                'autors' => $autorsFiltered,
                'techniques' => $request->techniques
            ],
            [
                'autors' => 'nullable|regex:/^[0-9&]+$/',
                'techniques' => 'nullable|regex:/^[0-9&]+$/'
        ]);

        if ($validator->fails()) {
            return redirect()->route('artworks.index');
        }

        $autors = Autor::get();
        $techniques = Technique::get();
        $items = Artwork::with('autor')->where('exposed', '=', true)->whereHas('autor', function ($query) use ($autorsFiltered) {
            $query->whereNotIn('autor_id', explode('&', $autorsFiltered));
        })->paginate(21);
        
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
        return view('home', compact('autors', 'techniques', 'items', 'cart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($language = Session::get('locale')) {
            App::setLocale($language);
        }
        $title = 'Nueva Obra';
        $artists = Autor::orderBy('name')->get();
        $techniques = Technique::orderBy('name')->get();
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
            $autor->name = $request->new_autor;
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
        $item->exposed = $request->exposed == 'on' ? true : false;
        $item->created_at = Carbon::now();
        $item->save();

        $item->autor()->sync([$autor_id]);
        $item->technique()->sync([$technique_id]);
        
        if ($request->hasFile('imageFile')) {
            $priority = 0;
            foreach ($request->file('imageFile') as $image) {
                $path = Storage::putFile('public', $image);
                $image = new Image();
                $image->artwork_id = $item->id;
                $image->image_source = $path;
                $image->priority = $priority;
                $image->created_at = Carbon::now();
                $image->save();
            }
        }

        return redirect()->route('artworks.list')->with('success', 'Obra agregada con exito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($language = Session::get('locale')) {
            App::setLocale($language);
        }
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
        if ($language = Session::get('locale')) {
            App::setLocale($language);
        }
        $title = 'Editar Obra';
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

        if ($deleteImages = json_decode($request->deleteImages)) {
            $images = Image::whereIn('id', $deleteImages)->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete($image->image_source);
                $image->delete();
            }
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

        if ($request->hasFile('imageFile')) {
            $priority = 0;
            foreach ($request->file('imageFile') as $image) {
                $path = Storage::putFile('public', $image);
                $image = new Image();
                $image->artwork_id = $item->id;
                $image->image_source = $path;
                $image->priority = $priority;
                $image->created_at = Carbon::now();
                $image->save();
            }
        }
        
        return redirect()->route('artworks.list')->with('success', 'Obra editada con exito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($language = Session::get('locale')) {
            App::setLocale($language);
        }
        $images = Image::where('artwork_id', $id)->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete($image->image_source);
                $image->delete();
            }
        Artwork::find($id)->delete();
        return back()->with('success', 'La obra ha sido eliminada correctamente.');
    }

    public function list() {
        if ($language = Session::get('locale')) {
            App::setLocale($language);
        }
        $title = 'Obras';
        $items = Artwork::paginate(20);
        return view('admin.artworks.list', compact('title', 'items'));
    }

    public function search(Request $request, $keyword) {
        if ($language = Session::get('locale')) {
            App::setLocale($language);
        }
        $validator = Validator::make(['keyword' => $keyword], ['keyword' => 'required|regex:/^[a-z& ]+$/']);
        if ($validator->fails()) {
            return redirect()->route('artworks.index');
        }
        $autors = Autor::get();
        $techniques = Technique::get();
        $items = Artwork::where('name', 'like', "%$keyword%")->get();
        $autors_search = Autor::where('name', 'like', "%$keyword%")->get();
        $techniques_search = Technique::where('name', 'like', "%$keyword%")->get();

        $autors_search->each(function ($autors) use ($items) {
            $autors->artwork->each(function ($autor) use ($items) {
                $items->push($autor);
            });
        });
        $techniques_search->each(function ($techniques) use ($items) {
            $techniques->artwork->each(function ($technique) use ($items) {
                $items->push($technique);
            });
        });

        $cart = collect([]);
        $cart->open = 'false';
        if (Auth()->check()) {
            $cart = CartItem::where('user_id', '=', Auth()->user()->id)->get();
            $subtotal = $cart->sum(function($item) {
                return $item->artwork->price;
            });
            $cart->subtotal = $subtotal;
            $cart->open = $request->session()->get('cart-open') ? 'true' : 'false';
        }
        return view('home', compact('autors', 'techniques', 'items', 'cart'));
    }
}
