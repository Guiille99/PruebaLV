<div>
    {{-- {{count($wishlist)}} --}}
    @if (Auth::check())
        @if (session()->get('wishlist')!=null && array_key_exists($libro->id,session()->get('wishlist')))
            <button wire:click="deleteToWishlist" class="boton btn-carrito mt-2" data-id="{{$libro->id}}"><i class="bi bi-heart-fill"></i> Eliminar de la lista de deseos</button>
        @else
            <button wire:click="addToWishlist" class="btn-outline-green mt-2" data-id="{{$libro->id}}"><i class="bi bi-heart"></i> Añadir a la lista de deseos</button>
        @endif
    @else
    <button class="btn-outline-green mt-2" disabled><i class="bi bi-heart"></i> Añadir a la lista de deseos</button>
    @endif
</div>
