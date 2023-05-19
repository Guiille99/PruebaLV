<div>
    @if (Auth::user()->carrito == null)
        <span class="carrito__cantidad">0</span>
    @else
        <span class="carrito__cantidad">{{Auth::user()->carrito->items->sum('cantidad')}}</span>
    @endif
</div>
