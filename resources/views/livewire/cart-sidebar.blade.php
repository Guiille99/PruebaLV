    {{-- Offcanvas carrito --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCarrito" aria-labelledby="offcanvasCart">
        <div class="offcanvas-header">
          <button type="button" class="bi bi-x" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          
          <div class="m-auto d-flex justify-content-center align-items-center gap-3">
            <i class="bi bi-bag">
              {{-- @if (session()->get('carrito'))
              <span class="carrito__cantidad">{{session('carrito-data')['cantidad']}}</span>
              @else
              <span class="carrito__cantidad">{{count((array) session('carrito'))}}</span>
              @endif --}}
              @livewire('cart-quantity')
            </i>
            <h5 class="offcanvas-title" id="offcanvasCart">Mi carrito</h5>
          </div>
        </div>
        <div class="offcanvas-content d-flex flex-column flex-grow-1">
          @if ($carrito!=null && $carrito->items->count() > 0)
          <div class="offcanvas-body">
              @foreach ($items as $item)
                  <div class="cart-book">
                    <figure>
                      <img src="{{asset($item->libro->portada)}}" alt="portada" class="img-fluid">
                    </figure>
    
                    <div class="book-data">
                      <p>{{$item->libro->titulo}}</p>
                      <div class="book-data__body">
                        <p>{{$item->cantidad}} x <span class="fw-bold">{{$item->libro->precio}}€</span></p>
                      </div>
                      <div class="book-data__footer">
                        <p class="total-unidad">{{$item->libro->precio * $item->cantidad}}€</p>
                        <form action="{{route('delete_to_cart', $item->libro->id)}}" method="post">
                          @csrf
                          @method('delete')
                          <button type="submit" class="bi bi-trash3 bg-transparent border-0"></button>
                        </form>
                      </div>
                    </div>
                  </div>
                  @endforeach
            @else
                <div class="offcanvas-body d-flex align-items-center justify-content-center">
                  <div class="text-center">
                    <i class="bi bi-emoji-frown"></i>
                    <p>El carrito está vacío</p>
                  </div>
            @endif
          </div>
          @if ($carrito!=null)
          <div class="offcanvas-footer">
            <p id="total">Total: <span class="precio">{{$total}}€</span></p>
            <a href="{{route('show-cart')}}" class="text-center text-decoration-none">Ver carrito</a>
            <form action="{{route('vaciar-carrito')}}" method="post">
              @csrf
              @method('delete')
              <input type="submit" class="w-100" value="Vaciar cesta">
            </form>
          </div>
          @endif
        </div>
  
    </div>