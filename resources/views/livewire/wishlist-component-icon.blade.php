<div class="wishlist__container mt-2">
    <a href="{{route('show.wishlist')}}" class="dropdown-item" title="Lista de deseos"><i class="bi bi-heart-fill"></i> <span class="wishlist-count">{{(Auth::user()->wishlist==null) ? 0 : Auth::user()->wishlist->items->count()}}</span></a> 
</div>
