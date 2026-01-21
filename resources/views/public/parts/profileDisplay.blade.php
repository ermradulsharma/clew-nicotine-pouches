<h1 class="mb-3">Personal Information</h1>
<div class="card mt-3">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-9 mt-2">
            <label class="text-uppercase">Name:</label>
            <div class="form-group">
                <input type="text" class="form-control form-control--sm"value="{{ $user->name }}" readonly>
            </div>
            </div>
            <div class="col-sm-9 mt-2">
            <label class="text-uppercase">Mobile:</label>
            <div class="form-group">
                <input type="text" class="form-control form-control--sm" value="{{ $user->mobile }}" readonly>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-9 mt-2">
                <label class="text-uppercase">Email:</label>
                <div class="form-group">
                    <input type="text" class="form-control form-control--sm" value="{{ $user->email }}" readonly>
                </div>
            </div>
        </div>
        <div class="mt-2">
            <button type="button" id="editProfile" class="btn ml-1">Edit</button>
            <button type="button" id="changePassword" class="btn btn--grey ml-1">Change Password</button>
        </div>
    </div>
</div>