@extends('layouts.plantilla-editPerfil')
@section('content-profile')
@section('breadcrumb-profile')
<li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
<li class="breadcrumb-item active" aria-current="page">Mi Wishlist</li> 
@endsection
@section('miWishlist-isActive', 'active')
    <div class="column account__details wishlist-section w-100">
        <div class="title">
            <p>MI WISHLIST</p>
        </div>
        <div class="data wishlist__container">
            @if (count($wishlistItems)>0)
                <div class="table-responsive">
                    <table class="table table-striped align-middle wislist-table">
                        <thead>
                            <td></td>
                            <td>Título</td>
                            <td>Autor</td>
                            <td>Precio</td>
                        </thead>
                        <tbody>
                            @foreach ($wishlistItems as $item)
                            <tr>
                                <td class="d-flex align-items-center gap-2">
                                    {{-- <form action="{{route('delete_to_wishlist', $item->libro_id)}}" method="post"> --}}
                                    {{-- @csrf --}}
                                    {{-- @method('delete') --}}
                                    <button class="btn-delete-wishlist bg-transparent border-0" data-idlibro="{{$item->libro_id}}"><i class="btn-delete-to-cart bi bi-x-circle"></i></button>
                                    {{-- </form> --}}
                                    <figure class="m-0">
                                        <img src="{{$item->libro->portada}}" alt="" class="img-fluid">
                                    </figure>
                                </td>
                                <td>{{$item->libro->titulo}}</td>
                                <td>{{$item->libro->autor}}</td>
                                <td>{{$item->libro->precio}} €</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$wishlistItems->links()}}
                </div>
            @else
            <div class="alert alert-warning mt-2" role="alert">
                <i class="bi bi-exclamation-triangle"></i>
                <span>Actualmente no tiene ningún producto en su lista de deseos</span>
            </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script>
        let url = "{{route('delete_to_wishlist', 'num')}}";
    </script>
    @vite(['resources/js/wishlist.js'])
@endsection