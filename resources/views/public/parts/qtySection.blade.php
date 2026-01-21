<div class="proDis">
    <div class="as" style="width:100%;">
        <button class="decrease_qty" cart-id="{{$cart->id}}" product-id="{{$cart->product_id}}" {{($cart->qty==1)?'disabled':''}}>-</button>
            <input type="text" id="item-qty-{{$cart->id}}" class="qty-input productQtyInput" value="{{$cart->qty}}" data-min="1" data-max="100" disabled />
        <button class="increase_qty" cart-id="{{$cart->id}}" product-id="{{$cart->product_id}}" {{($cart->qty>=100)?'disabled':''}}>+</button>
    </div>
</div>