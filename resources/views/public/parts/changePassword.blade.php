<h1 class="mb-3">Change Password</h1>
<div class="card mt-3">
  <div class="card-body">
    <form id="changePasswordForm" name="changePasswordForm">
      <div class="row">
        <div class="col-sm-9 mt-2">
          <label for="currentPassword" class="text-uppercase">Current Password*:</label>
          <div class="form-group">
            <input type="password" name="currentPassword" id="currentPassword" class="form-control form-control--sm">
            <span class="errorMsg errors">&nbsp;</span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-9 mt-2">
          <label for="newPassword" class="text-uppercase">New Password*:</label>
          <div class="form-group">
            <input type="password" name="newPassword" id="newPassword" class="form-control form-control--sm">
            <span class="errorMsg errors">&nbsp;</span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-9 mt-2">
          <label for="confirmPassword" class="text-uppercase">Confirm Password*:</label>
          <div class="form-group">
            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control form-control--sm">
            <span class="errorMsg errors">&nbsp;</span>
          </div>
        </div>
      </div>
      <div class="mt-2">
        <button type="button" id="changePasswordSave" class="btn ml-1">Save</button>
        <button type="button" id="changePasswordCancel" class="btn btn--grey ml-1">Cancel</button>
      </div>
    </form>
  </div>
</div>