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
        // $request->account_number_ach; // Identificador de la transacci??n.
        // $request->account_type_ach; // 	Identificador de la transacci??n.
        $transaction->additional_value = $request->additional_value; //	Valor Adicional no comisionable.
        // $request->administrative_fee; // Valor de la tarifa administrativa
        // $request->administrative_fee_base; // 	Valor base de la tarifa administrativa
        // $request->administrative_fee_tax; // Valor del impuesto de la tarifa administrativa
        // $request->airline_code; // C??digo de la aerol??nea
        $transaction->attempts = $request->attempts; // Numero de intentos del env??o de la confirmaci??n.
        $transaction->authorization_code = $request->authorization_code; // C??digo de autorizaci??n de la venta
        $transaction->bank_id = $request->bank_id; // Identificador del banco
        $transaction->billing_address = $request->billing_address; // La direcci??n de facturaci??n
        $transaction->billing_city = $request->billing_city; // La ciudad de facturaci??n.
        $transaction->billing_country = $request->billing_country; // El c??digo ISO del pa??s asociado a la direcci??n de facturaci??n.
        $transaction->commision_pol = $request->commision_pol; // Valor de la comisi??n
        $transaction->commision_pol_currency = $request->commision_pol_currency; // Moneda de la comisi??n
        $transaction->currency = $request->currency; // La moneda respectiva en la que se realiza el pago. El proceso de conciliaci??n se hace en pesos a la tasa representativa del d??a.
        $transaction->cus = $request->cus; // El cus, c??digo ??nico de seguimiento, es la referencia del pago dentro del Banco, aplica solo para pagos con PSE
        $transaction->customer_number = $request->customer_number; // Numero de cliente.
        $transaction->date = $request->date; // Fecha de la operaci??n.
        $transaction->description = $request->description; // Es la descripci??n de la venta.
        $transaction->email_buyer = $request->email_buyer; // 	Campo que contiene el correo electr??nico del comprador para notificarle el resultado de la transacci??n por correo electr??nico. Se recomienda hacer una validaci??n si se toma este dato en un formulario.
        $transaction->error_code_bank = $request->error_code_bank; // C??digo de error del banco.
        $transaction->error_message_bank = $request->error_message_bank; // Mensaje de error del banco
        $transaction->exchange_rate = $request->exchange_rate; // Valor de la tasa de cambio.
        // $request->extra1; // Campo adicional para enviar informaci??n sobre la compra. Ej. Descripci??n de la compra en caso de querer visualizarla en la p??gina de confirmaci??n.
        // $request->extra2; // Campo adicional para enviar informaci??n sobre la compra. Ej. C??digos internos de los productos.
        $transaction->installments_number = $request->installments_number; // N??mero de cuotas en las cuales se difiri?? el pago con tarjeta cr??dito.
        $transaction->ip = $request->ip; // Direcci??n ip desde donde se realiz?? la transacci??n.
        $transaction->nickname_buyer = $request->nickname_buyer; // Nombre corto del comprador.
        $transaction->nickname_seller = $request->nickname_seller; // Nombre corto del vendedor.
        $transaction->merchant_id = $request->merchant_id; // Es el n??mero identificador del comercio en el sistema de PayU, este n??mero lo encontrar?? en el correo de creaci??n de la cuenta.
        $transaction->office_phone = $request->office_phone; // El tel??fono diurno del comprador.
        $transaction->payment_method = $request->payment_method; // 	El identificador interno del medio de pago utilizado.
        $transaction->payment_method_id = $request->payment_method_id; // Identificador del medio de pago.
        $transaction->payment_method_name = $request->payment_method_name; // Medio de pago con el cual se hizo el pago. Por ejemplo VISA.
        $transaction->payment_method_type = $request->payment_method_type; // El tipo de medio de pago utilizado para el pago
        $transaction->payment_request_state = $request->payment_request_state; // Estado de la solicitud de pago.
        $transaction->pse_bank = $request->pse_bank; // El nombre del banco, aplica solo para pagos con PSE.
        $transaction->pseReference1 = $request->pseReference1; // Referencia no. 1 para pagos con PSE.
        $transaction->pseReference2 = $request->pseReference2; // Referencia no. 2 para pagos con PSE.
        $transaction->pseReference3 = $request->pseReference3; // Referencia no. 3 para pagos con PSE.
        $transaction->phone = $request->phone; // 	El tel??fono de residencia del comprador.
        $transaction->risk = $request->risk; // Riesgo asociado a la transacci??n
        $transaction->response_code_pol = $request->response_code_pol; // El c??digo de respuesta de PayU.
        $transaction->response_message_pol = $request->response_message_pol; // El mensaje de respuesta de PAYU.
        $transaction->reference_sale = $request->reference_sale; // Es la referencia de la venta o pedido. Deber ser ??nico por cada transacci??n que se env??a al sistema.
        $transaction->reference_pol = $request->reference_pol; // La referencia o n??mero de la transacci??n generado en PayU.
        $transaction->shipping_address = $request->shipping_address; // La direcci??n de entrega de la mercanc??a.
        $transaction->shipping_city = $request->shipping_city; // La ciudad de entrega de la mercanc??a.
        $transaction->shipping_country = $request->shipping_country; // El c??digo ISO asociado al pa??s de entrega de la mercanc??a.
        $transaction->sign = $request->sign; // Es la firma digital creada para cada uno de las transacciones.
        $transaction->state_pol = $request->state_pol; // Estado de la transacci??n
        $transaction->tax = $request->tax; // Es el valor del IVA de la transacci??n, si se env??a el IVA nulo el sistema aplicar?? el 19% autom??ticamente. Puede contener dos d??gitos decimales. Ej: 19000.00. En caso de no tener IVA debe enviarse en 0.
        $transaction->test = $request->test; // Variable para poder identificar si la operaci??n fue una prueba.
        $transaction->transaction_bank_id = $request->transaction_bank_id; // Identificador de la transacci??n en el sistema del banco.
        $transaction->transaction_date = $request->transaction_date; // La fecha en que se realiz?? la transacci??n.
        $transaction->transaction_id = $request->transaction_id; // Identificador de la transacci??n.
        $transaction->travel_agency_authorization_code = $request->travel_agency_authorization_code; // C??digo de autorizaci??n de la agencia de viajes
        $transaction->value = $request->value; // Es el monto total de la transacci??n. Puede contener dos d??gitos decimales. Ej. 10000.00 ?? 10000
        $transaction->save();

        $buyItItems = $this->decodeReferenceSaleCode($request->reference_sale);
        foreach($buyItItems->items_id as $item) {
            $item = CartItem::where('user_id', $buyItItems->user_id)->where('artwork_id', $item->id)->first();
            $item->buyit = true;
            $item->save();
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
