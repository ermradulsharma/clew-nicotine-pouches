<form class="form" name="productImageForm" id="productImageForm" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="title">Title <span class="text-danger">*</span><span class="error"></span></label>
                <input type="text" name="title" id="title" class="form-control" />
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="variant_id">Variant <span class="text-danger">*</span><span class="error"></span></label>
                <select class="form-control" id="variant_id" name="variant_id">
                    <option value="">Variant</option>
                    @foreach($variants as $variant)
                    <option value="{{ $variant->id }}">{{ $variant->strength->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="image">Image <span class="text-danger">*</span><span class="error"></span></label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*" />
                <span class="sizeOption">(Image Size: 750px X 543px)</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xs-12 text-center">
            <div class="form-group">
                <input type="hidden" id="product_id" name="product_id" value="{{ $product_id }}">
                <button type="button" name="productImageInsert" id="productImageInsert" class="btn btn-default">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</form>
