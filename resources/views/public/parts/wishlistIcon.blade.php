<span class="wishlist-pro add_to_wishlist wishlist-item-{{$product_id}} productWishlist" product-id="{{$product_id}}">
    <i class="fa {{ (\Helper::isWishlist($product_id))?'fa-heart':'fa-heart-o'}}" aria-hidden="true"></i>
</span>