<form class="form" name="pageBannerForm" id="pageBannerForm" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="title">Title <span class="text-danger">*</span><span class="error"></span></label>
                <input type="text" name="title" id="title" class="form-control" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="mobile">Mobile <span class="text-danger">*</span><span class="error"></span></label>
                <input type="file" name="mobile" id="mobile" class="form-control" accept="image/*" />
                <span class="sizeOption">(Image Size: 1366px X 600px)</span>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="desktop">Desktop <span class="text-danger">*</span><span class="error"></span></label>
                <input type="file" name="desktop" id="desktop" class="form-control" accept="image/*" />
                <span class="sizeOption">(Image Size: 1366px X 400px)</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xs-12 text-center">
            <div class="form-group">
                <input type="hidden" id="page_id" name="page_id" value="{{ $page_id }}">
                <button type="button" name="pageBannerInsert" id="pageBannerInsert" class="btn btn-default">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</form>
