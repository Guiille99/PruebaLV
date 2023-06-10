<div>
    @if (Auth::check())
        @if ($libroWishlistExists)
            <div wire:ignore>
                <button wire:click="deleteToWishlist" wire:loading.attr="disabled" class="boton btn-carrito mt-2" data-id="{{$libro->id}}">
                    <i wire:loading.remove class="bi bi-heart-fill"></i> 
                    <span wire:loading.remove>Eliminar de la lista de deseos</span>
                    <div wire:loading wire:target="deleteToWishlist">
                        <div class="spinner-border text-light" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </button>
            </div>
        @else
            <button wire:click="addToWishlist" wire:loading.attr="disabled" class="btn-outline-green mt-2" data-id="{{$libro->id}}">
                <i wire:loading.remove class="bi bi-heart"></i> 
                <span wire:loading.remove>Añadir a la lista de deseos</span>
                <div wire:loading wire:target="addToWishlist">
                    <div class="spinner-border text-dark" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </button>
        @endif
    @else
    <button class="btn-outline-green mt-2" disabled><i class="bi bi-heart"></i> Añadir a la lista de deseos</button>
    @endif
</div>
