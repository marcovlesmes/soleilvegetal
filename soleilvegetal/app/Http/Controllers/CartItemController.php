<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Artwork;
use App\Models\Autor;
use App\Models\CartItem;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use stdClass;

class CartItemController extends Controller
{
    private function createOrder($items, $addresses) {
        $items_id = $items->map(function ($item) {
            return $item['artwork_id'];
        });
        $referenceCode = 'U' . Auth()->user()->id . 'D' . Carbon::now()->format('YmdHis') . 'I' . $items_id->implode('I');
        $signature = md5(config('app.payu.apikey') . '~' . config('app.payu.merchant') . '~' . $referenceCode . '~' . $items->subtotal . '~COP');
        $address = $addresses->first();

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
              ->put('buyerFullName', Auth()->user()->name)
              ->put('buyerEmail', Auth()->user()->email)
              ->put('responseUrl', route('confirmation'))
              ->put('confirmationUrl', route('response'))
              ->put('shippingAddress', $address->street . ' ' . $address->number . '#' . $address->complement)
              ->put('shippingCity', $address->city)
              ->put('shippingCountry', 'Colombia')
              ->put('telephone', '3192901753');
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
        $user_id = Auth::user()->id;
        $items = CartItem::where('user_id', '=', $user_id)->get();
        $subtotal = $items->sum(function($item){
            return $item->artwork->price;
        });
        $items->subtotal = $subtotal;
        $addresses = Address::where('user_id', '=', $user_id)->get();
        $order = null;
        if ($addresses->count() > 0) {
            $order = $this->createOrder($items, $addresses);
        }
        return view('checkout', compact('items', 'addresses', 'order'));
    }

    public function payuConfirmation(Request $request) {
        return view('confirmation');
    }

    public function payuResponse(Request $request) {
        $transaction = new Transaction();
        // $request->account_number_ach; // Identificador de la transacción.
        // $request->account_type_ach; // 	Identificador de la transacción.
        $transaction->additional_value = $request->additional_value; //	Valor Adicional no comisionable.
        // $request->administrative_fee; // Valor de la tarifa administrativa
        // $request->administrative_fee_base; // 	Valor base de la tarifa administrativa
        // $request->administrative_fee_tax; // Valor del impuesto de la tarifa administrativa
        // $request->airline_code; // Código de la aerolínea
        $transaction->attempts = $request->attempts; // Numero de intentos del envío de la confirmación.
        $transaction->authorization_code = $request->authorization_code; // Código de autorización de la venta
        $transaction->bank_id = $request->bank_id; // Identificador del banco
        $transaction->billing_address = $request->billing_address; // La dirección de facturación
        $transaction->billing_city = $request->billing_city; // La ciudad de facturación.
        $transaction->billing_country = $request->billing_country; // El código ISO del país asociado a la dirección de facturación.
        $transaction->commision_pol = $request->commision_pol; // Valor de la comisión
        $transaction->commision_pol_currency = $request->commision_pol_currency; // Moneda de la comisión
        $transaction->currency = $request->currency; // La moneda respectiva en la que se realiza el pago. El proceso de conciliación se hace en pesos a la tasa representativa del día.
        $transaction->cus = $request->cus; // El cus, código único de seguimiento, es la referencia del pago dentro del Banco, aplica solo para pagos con PSE
        $transaction->customer_number = $request->customer_number; // Numero de cliente.
        $transaction->date = $request->date; // Fecha de la operación.
        $transaction->description = $request->description; // Es la descripción de la venta.
        $transaction->email_buyer = $request->email_buyer; // 	Campo que contiene el correo electrónico del comprador para notificarle el resultado de la transacción por correo electrónico. Se recomienda hacer una validación si se toma este dato en un formulario.
        $transaction->error_code_bank = $request->error_code_bank; // Código de error del banco.
        $transaction->error_message_bank = $request->error_message_bank; // Mensaje de error del banco
        $transaction->exchange_rate = $request->exchange_rate; // Valor de la tasa de cambio.
        // $request->extra1; // Campo adicional para enviar información sobre la compra. Ej. Descripción de la compra en caso de querer visualizarla en la página de confirmación.
        // $request->extra2; // Campo adicional para enviar información sobre la compra. Ej. Códigos internos de los productos.
        $transaction->installments_number = $request->installments_number; // Número de cuotas en las cuales se difirió el pago con tarjeta crédito.
        $transaction->ip = $request->ip; // Dirección ip desde donde se realizó la transacción.
        $transaction->nickname_buyer = $request->nickname_buyer; // Nombre corto del comprador.
        $transaction->nickname_seller = $request->nickname_seller; // Nombre corto del vendedor.
        $transaction->merchant_id = $request->merchant_id; // Es el número identificador del comercio en el sistema de PayU, este número lo encontrará en el correo de creación de la cuenta.
        $transaction->office_phone = $request->office_phone; // El teléfono diurno del comprador.
        $transaction->payment_method = $request->payment_method; // 	El identificador interno del medio de pago utilizado.
        $transaction->payment_method_id = $request->payment_method_id; // Identificador del medio de pago.
        $transaction->payment_method_name = $request->payment_method_name; // Medio de pago con el cual se hizo el pago. Por ejemplo VISA.
        $transaction->payment_method_type = $request->payment_method_type; // El tipo de medio de pago utilizado para el pago
        $transaction->payment_request_state = $request->payment_request_state; // Estado de la solicitud de pago.
        $transaction->pse_bank = $request->pse_bank; // El nombre del banco, aplica solo para pagos con PSE.
        $transaction->pseReference1 = $request->pseReference1; // Referencia no. 1 para pagos con PSE.
        $transaction->pseReference2 = $request->pseReference2; // Referencia no. 2 para pagos con PSE.
        $transaction->pseReference3 = $request->pseReference3; // Referencia no. 3 para pagos con PSE.
        $transaction->phone = $request->phone; // 	El teléfono de residencia del comprador.
        $transaction->risk = $request->risk; // Riesgo asociado a la transacción
        $transaction->response_code_pol = $request->response_code_pol; // El código de respuesta de PayU.
        $transaction->response_message_pol = $request->response_message_pol; // El mensaje de respuesta de PAYU.
        $transaction->reference_sale = $request->reference_sale; // Es la referencia de la venta o pedido. Deber ser único por cada transacción que se envía al sistema.
        $transaction->reference_pol = $request->reference_pol; // La referencia o número de la transacción generado en PayU.
        $transaction->shipping_address = $request->shipping_address; // La dirección de entrega de la mercancía.
        $transaction->shipping_city = $request->shipping_city; // La ciudad de entrega de la mercancía.
        $transaction->shipping_country = $request->shipping_country; // El código ISO asociado al país de entrega de la mercancía.
        $transaction->sign = $request->sign; // Es la firma digital creada para cada uno de las transacciones.
        $transaction->state_pol = $request->state_pol; // Estado de la transacción
        $transaction->tax = $request->tax; // Es el valor del IVA de la transacción, si se envía el IVA nulo el sistema aplicará el 19% automáticamente. Puede contener dos dígitos decimales. Ej: 19000.00. En caso de no tener IVA debe enviarse en 0.
        $transaction->test = $request->test; // Variable para poder identificar si la operación fue una prueba.
        $transaction->transaction_bank_id = $request->transaction_bank_id; // Identificador de la transacción en el sistema del banco.
        $transaction->transaction_date = $request->transaction_date; // La fecha en que se realizó la transacción.
        $transaction->transaction_id = $request->transaction_id; // Identificador de la transacción.
        $transaction->travel_agency_authorization_code = $request->travel_agency_authorization_code; // Código de autorización de la agencia de viajes
        $transaction->value = $request->value; // Es el monto total de la transacción. Puede contener dos dígitos decimales. Ej. 10000.00 ó 10000
        $transaction->save();

        $buyItItems = $this->decodeReferenceSaleCode($request->reference_sale);
        foreach($buyItItems->items_id as $item) {
            CartItem::where('user_id', $buyItItems->user_id)->where('artwork_id', $item->id)->delete();
        }

        return response()->json(['success' => 'success'], 200);
    }

    private function decodeReferenceSaleCode($reference_code) {
        $a = [];
        preg_match('/(^U\d+)(D\d+)([I\d]+)/', $reference_code, $a);
        $user = trim($a[1], 'U');
        $date = trim($a[2], 'D');
        $items_id = [];
        $id = null;
        foreach ($code = str_split($reference_code) as $index => $caracter) {
            if ($caracter == 'I') {
                if ($id != null) {
                    array_push($items_id, $id);
                }
                $id = '';
            } elseif (gettype($id) == 'string') {
                $id .= $caracter;
            }
            if ($index == count($code) - 1) {
                array_push($items_id, $id);
            }
        }

        $items = collect([
            'user_id' => $user,
            'date' => $date,
            'items_id' => collect($items_id)
        ]);
        
        return $items;
    }
}
