<div>
    <button wire:click="addToWishlist">Añadir a la wishlist</button>
    @isset($wishlist)
        {{count($wishlist)}}
    @endisset
</div>
