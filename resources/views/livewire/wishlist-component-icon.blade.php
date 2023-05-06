<div class="wishlist__container mt-2">
    <a href="{{route('show.wishlist')}}" class="dropdown-item" title="Lista de deseos"><i class="bi bi-heart-fill"></i> <span class="wishlist-count">{{(session()->get('wishlist')==null) ? 0 : count(session()->get('wishlist'))}}</span></a> 
</div>
