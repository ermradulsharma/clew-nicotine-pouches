<form class="form" name="productImageForm" id="productImageForm" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="title">Title <span class="text-danger">*</span><span class="error"></span></label>
                <input type="text" name="title" id="title" value="{{ $data->title }}" class="form-control" />
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="variant_id">Variant <span class="text-danger">*</span><span class="error"></span></label>
                <select class="form-control" id="variant_id" name="variant_id">
                    <option value="">Variant</option>
                    @foreach($variants as $variant)
                    @php $selected = ($data->variant_id==$variant->id)?'selected':''; @endphp
                    <option value="{{ $variant->id }}" {{ $selected }}>{{ $variant->strength->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="image">Image <span class="error"></span></label>
                <div class="input-group">
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" />
                    <span class="input-group-addon" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="<img src='{{ asset('storage/product/multishots/thumb/'.$data->image) }}' class='img-150w' />">
                        <img src="{{ asset('storage/product/multishots/thumb/'.$data->image) }}" style="width: 24px; height: 20px;" />
                    </span>
                </div>
                <span class="sizeOption">(Image Size: 750px X 543px)</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xs-12 text-center">
            <div class="form-group">
                @method('PUT') @csrf
                <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                <input type="hidden" id="product_id" name="product_id" value="{{ $data->product_id }}">
                <button type="button" name="productImageUpdate" id="productImageUpdate" class="btn btn-default">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</form>
