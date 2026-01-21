<form class="form" name="productVariantForm" id="productVariantForm" method="post">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="strength_id">Strength <span class="text-danger">*</span><span class="error"></span></label>
            <select class="form-control" id="strength_id" name="strength_id">
                <option value="">Strength</option>
                @foreach($strengths as $strength)
                <option value="{{ $strength->id }}">{{ $strength->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
    {{--
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="qty">Qty <span class="text-danger">*</span><span class="error"></span></label>
            <input type="text" name="qty" id="qty" class="form-control" onkeypress="return numbersonly(event);" />
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="mrp">MRP <span class="text-danger">*</span><span class="error"></span></label>
            <input type="text" name="mrp" id="mrp" class="form-control" onkeypress=" return decimalsonly(this, event);" />
        </div>
    </div>
    --}}
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="price">Price <span class="text-danger">*</span><span class="error"></span></label>
            <input type="text" name="price" id="price" class="form-control" onkeypress="return decimalsonly(this, event);" />
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="image">Image <span class="text-danger">*</span><span class="error"></span></label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*" />
            <span class="sizeOption">(Image Size: 750px X 543px)</span>
        </div>
    </div>

    {{--
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="sale_price">Sale Price <span class="text-danger">*</span><span class="error"></span></label>
            <input type="text" name="sale_price" id="sale_price" class="form-control" onkeypress="return numbersonly(this, event);" />
        </div>
    </div>
    --}}
    <div class="col-sm-12 col-md-12 col-xs-12 text-center">
        <div class="form-group">
            @csrf
            <input type="hidden" id="product_id" name="product_id" value="{{ $product_id }}">
            <button type="button" name="productVariantInsert" id="productVariantInsert" class="btn btn-default">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
    </div>
</form>
