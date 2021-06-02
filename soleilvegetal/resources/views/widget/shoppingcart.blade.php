<nav
    class=" group fixed right-0 top-0 bg-white h-full flex flex-col max-w-sm items-center z-50 p-3 overflow-y-scroll">
    <div class="flex w-full justify-between">
        <h2 class="text-gray-400 text-2xl font-serif">Carrito de compras</h2>
        <span id="closeCart" class="text-sm ml-8 mr-3 cursor-pointer">X</span>
    </div>
    <hr class="border border-gray-200 w-full my-5">
    <div class="divide-y divide-gray-200">
        @if (count($cart) > 0)
            @foreach ($cart as $item)
            <div class="flex justify-evenly my-5 py-3">
                <img  class="w-2/5 p-3 row-span-2" src="{{asset($item->artwork->image->first()->image_source) }}" alt="">
                <ul class="mx-3">
                    <li class="text-primary">{{ $item->artwork->name }}</li>
                    <li>${{ $item->artwork->price }}</li>
                    <li><a class="text-linky" href="#">Quitar</a></li>
                </ul>
            </div>
            @endforeach
            <form id="delete-form" class="hidden" action="{{ route('cartItems.destroy', Auth()->user()->id) }}" method="post">
            @csrf
            @method('DELETE')
            <input type="text" name="id" id="delete-input">
            </form>
            <form method="POST" action="{{ route('checkout') }}" class="my-5 py-3">
                @csrf
                <label for="instructions">Instruciones especiales para el vendedor</label>
                <textarea class="border w-full h-32" name="instructions" id="instructions"></textarea>
                <div class="flex justify-between">
                    <span>Subtotal</span><span>${{$cart->subtotal}}</span>
                </div>
                <p class="text-center my-3">Gastos de envío y descuentos calculado al momento de pagar</p>
                <button class="w-full bg-gray-400 text-gary-800 py-2 my-2 font-bold" type="submit">Checkout <svg class="inline h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg></button>
            </form>
        @else
            <p class="p-3" style="color:gray">No hay items en el carro de compras.</p>
        @endif
    </div>
    
    </div>
</nav>