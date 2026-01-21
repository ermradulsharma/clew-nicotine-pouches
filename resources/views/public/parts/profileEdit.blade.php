<h1 class="mb-3">Personal Information</h1>
<div class="card mt-3">
  <div class="card-body">
    <form id="profileForm" name="profileForm">
      <div class="row">
        <div class="col-sm-9">
          <label for="name" class="text-uppercase">Name*:</label>
          <div class="form-group">
            <input type="text" name="name" id="name" class="form-control form-control--sm" value="{{ $user->name }}">
            <span class="errorMsg errors">&nbsp;</span>
          </div>
        </div>
        <div class="col-sm-9">
          <label for="mobile" class="text-uppercase">Mobile*:</label>
          <div class="form-group">
            <input type="text" name="mobile" id="mobile" class="form-control form-control--sm" value="{{ $user->mobile }}" onkeypress="return numbersonly(event);" maxlength="10">
            <span class="errorMsg errors">&nbsp;</span>
          </div>
        </div>
      </div>
      <div class="mt-2">
        <button type="button" id="profileUpdate" class="btn ml-1">Update</button>
        <button type="button" id="profileCancel" class="btn btn--grey ml-1">Cancel</button>
      </div>
    </form>
  </div>
</div>