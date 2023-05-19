<div class="btn__container">
    @if (Auth::check()) {{-- Si hay una sesión iniciada --}}
        <button wire:click="addCarrito({{$libro->id}})" class="boton">Comprar</button>
    @else
        <button class="boton" disabled>Comprar</button>
    @endif
</div>
