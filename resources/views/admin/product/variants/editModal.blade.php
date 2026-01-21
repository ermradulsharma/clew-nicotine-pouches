<form class="form" name="productVariantForm" id="productVariantForm" method="post">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="strength_id">Strength <span class="text-danger">*</span><span class="error"></span></label>
            <select class="form-control" id="strength_id" name="strength_id">
                <option value="">Strength</option>
                @foreach($strengths as $strength)
                @php $selected = ($data->strength_id==$strength->id)?'selected':''; @endphp
                <option value="{{ $strength->id }}" {{ $selected }}>{{ $strength->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
    {{--
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="qty">Qty <span class="text-danger">*</span><span class="error"></span></label>
            <input type="text" name="qty" id="qty" value="{{ $data->qty }}" class="form-control" />
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="mrp">MRP <span class="text-danger">*</span><span class="error"></span></label>
            <input type="text" name="mrp" id="mrp" value="{{ $data->mrp }}" class="form-control" onkeypress=" return decimalsonly(this, event);" />
        </div>
    </div>
    --}}
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="price">Price <span class="text-danger">*</span><span class="error"></span></label>
            <input type="text" name="price" id="price" value="{{ $data->price }}" class="form-control" onkeypress=" return decimalsonly(this, event);" />
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="image">Image <span class="error"></span></label>
            <div class="input-group">
                <input type="file" name="image" id="image" class="form-control" accept="image/*" />
                <span class="input-group-addon" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="<img src='{{ asset('storage/product/thumb/'.$data->image) }}' class='img-150w' />">
                    <img src="{{ asset('storage/product/thumb/'.$data->image) }}" style="width: 24px; height: 20px;" />
                </span>
            </div>
            <span class="sizeOption">(Image Size: 750px X 543px)</span>
        </div>
    </div>
    {{--
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="sale_price">Sale Price <span class="text-danger">*</span><span class="error"></span></label>
            <input type="text" name="sale_price" id="sale_price" value="{{ $data->sale_price }}" class="form-control" onkeypress=" return decimalsonly(this, event);" />
        </div>
    </div>
    --}}
    <div class="col-sm-12 col-md-12 col-xs-12 text-center">
        <div class="form-group">
            @method('PUT') @csrf
            <input type="hidden" id="id" name="id" value="{{ $data->id }}">
            <input type="hidden" id="product_id" name="product_id" value="{{ $data->product_id }}">
            <button type="button" name="productVariantUpdate" id="productVariantUpdate" class="btn btn-default">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
    </div>
</form>
