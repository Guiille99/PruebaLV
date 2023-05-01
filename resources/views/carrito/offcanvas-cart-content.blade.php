<div class="offcanvas-body">
  @if (session()->get('carrito'))
    @foreach (session()->get('carrito') as $id=>$libro)
        <div class="cart-book">
          <figure>
            <img src="{{asset($libro['portada'])}}" alt="portada" class="img-fluid">
          </figure>

          <div class="book-data">
            <p>{{$libro["titulo"]}}</p>
            <div class="book-data__body">
              <p>{{$libro["cantidad"]}} x <span class="fw-bold">{{$libro["precio"]}}€</span></p>
            </div>
            <div class="book-data__footer">
              <p class="total-unidad">{{$libro["precio"]*$libro["cantidad"]}}€</p>
              <form action="{{route('delete_to_cart', $id)}}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="bi bi-trash3 bg-transparent border-0"></button>
              </form>
            </div>
          </div>
        </div>
        @endforeach
  @else
      <p>El carrito está vacío</p>
  @endif
</div>
@if (session()->get('carrito'))
<div class="offcanvas-footer bottom-0">
  <p id="total">Total: <span class="precio">{{session()->get('carrito-data')["total"]}}€</span></p>
  <a href="{{route('show-cart')}}" class="text-center text-decoration-none">Ver carrito</a>
  <form action="{{route('vaciar-carrito')}}" method="post">
    @csrf
    @method('delete')
    <input type="submit" class="w-100" value="Vaciar cesta">
  </form>
</div>
@endif