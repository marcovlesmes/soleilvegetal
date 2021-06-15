<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function store(Request $request) {
        Validator::make($request->all(), [
            'state' => 'required|regex:/^[a-zA-Z\s]+$/',
            'city' => 'required|regex:/^[a-zA-Z\s]+$/',
            'street' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'number' => 'required|alpha_num',
            'complement'=> 'required|numeric',
            'detail' => 'nullable|regex:/^[a-zA-Z0-9\s.#()-]+$/'
        ])->validate();

        $address = new Address();
        $address->user_id = Auth()->user()->id;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->street = $request->street;
        $address->number = $request->number;
        $address->complement = $request->complement;
        $address->detail = $request->detail;
        $address->primary = true;
        $address->save();

        return redirect()->route('checkout');
    }
}
