@extends('layouts.app')
@section('content')
  @include('layouts.parts.warning')
  @include('layouts.parts.header', ['page'=>'users'])
@include('public.parts.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
<div class="profile-dtl-container">
    <div class="profilepicbox">
         <div class="propic"><img src="images/profile-pic.jpg" alt=""/><i class="fa fa-pencil"></i></div>
         <div class="name">{{ $user->first_name}}</div>
    </div>
    <div id="profileSection" class="profileoption">
      <ul>
        <li>
          <a id="editProfile" title="Edit profile"><img src="{{ asset('images/edit-profile-icon.png') }}"/>Edit Profile</a>
          <div class="loginform hide" id="displayProfile">
            <form id="profileForm" name="profileForm">
              <div class="frows checkrow">
                <div class="frows-in">
                  <input type="text" id="first_name" name="first_name" value="{{ $user->first_name}}" placeholder="First Name*"><span></span>
                  </div>
                  <div class="frows-in">
                  <input type="text" id="last_name" name="last_name" value="{{ $user->last_name}}" placeholder="Last Name*"><span></span>
                </div>
              </div>
              <div class="button">
                <button id="profileUpdate" type="button" class="bluebtn btnCenter" style="height:50px; width:100%;">Save</button>
              </div>
            </form>
          </div>
        </li>
        <li>
          <a id="changePassword" title="Change Password"><img src="{{ asset('images/change-password-icon.png') }}"/>Change Password</a>
          <div class="loginform hide" id="displayChangePassword">
            <form id="changePasswordForm" name="changePasswordForm">
              <div class="frows">
                <input type="password" id="current_password" name="current_password" placeholder="Current Password*"><span></span>
              </div>
              <div class="frows checkrow">
                <div class="frows-in">
                  <input type="password" id="password" name="password" value="" placeholder="New Password*"><span></span>
                  </div>
                  <div class="frows-in">
                  <input type="password" id="password-confirm" name="password_confirmation" value="" placeholder="Confirm Password*"><span></span>
                </div>
              </div>
              <div class="button">
                <button id="changePasswordSave" type="button" class="bluebtn btnCenter" style="height:50px; width:100%;">Update</button>
              </div>
            </form>
          </div>
        </li>
        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="log out"><img src="{{ asset('images/logout-icon.png') }}"/>log out</a></li>
      </ul>
    </div>
</div>

  

  {{--
  <div class="page-content">
    <div class="holder breadcrumbs-wrap mt-0">
      <div class="container">
        <ul class="breadcrumbs">
          <li><a href="{{route('home')}}">Home</a></li>
          <li><span>Personal Information</span></li>
        </ul>
      </div>
    </div>
    <div class="holder">
      <div class="container">
        <div class="row">
          <div id="profileDisplay" class="col-md-14 aside">
            @include('public.parts.profileDisplay', ['user'=>$user])  
          </div>
        </div>
      </div>
    </div>
  </div>
  --}}
  {{--
  <div id="profileModal" class="add_new_address">
    <div class="new_address_fom">
      <span class="close_address_box"></span>
      <h3>Personal Information</h3>
        <form id="profileForm" name="profileForm">
          <div class="form_row">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{$user->name}}" placeholder="Name">
            <span class="errorMsg"></span>
          </div>
          <div class="form_row">
            <label for="mobile">Mobile:</label>
            <input type="text" name="mobile" id="mobile" value="{{$user->mobile}}" placeholder="Mobile">
            <span class="errorMsg"></span>
          </div>
          <div class="form_row">
            <label for="dob">Date of Birth:</label>
            <input type="text" name="dob" id="dob" value="{{$user->dob}}" placeholder="Date of Birth">
            <span class="errorMsg"></span>
          </div>
          <div class="form_row">
            <label for="location">Location:</label>
            <select name="location" id="location">
              <option value="">Location</option>
              @foreach($states as $state)
              <option value="{{$state->title}}" {{($state->title==$user->location)?'selected':''}}>{{$state->title}}</option>
              @endforeach
            </select>
            <span class="errorMsg"></span>
          </div>
          <div class="form_row load_more_row">
            <button type="button" class="btn" id="profileUpdate">Save</button>
            <button type="button" class="btn close_address_box">Cancel</button>
          </div>
        </form>
    </div>
  </div>

  <div id="changePasswordModal" class="add_new_address">
    <div class="new_address_fom">
      <span class="close_address_box"></span>
      <h3>Change Password</h3>
      <form id="changePasswordForm" name="changePasswordForm">
        <div class="form_row">
          <label for="currentPassword">Current Password:</label>
          <input type="password" name="currentPassword" id="currentPassword">
          <span class="errorMsg"></span>
        </div>
        <div class="form_row">
          <label for="newPassword">New Password:</label>
          <input type="password" name="newPassword" id="newPassword">
          <span class="errorMsg"></span>
        </div>
        <div class="form_row">
          <label for="confirmPassword">Confirm Password:</label>
          <input type="password" name="confirmPassword" id="confirmPassword">
          <span class="errorMsg"></span>
        </div>
        <div class="form_row load_more_row">
          <button type="button" class="btn" id="changePasswordSave">Save</button>
          <button type="button" class="btn close_address_box">Cancel</button>
        </div>
      </form>
    </div>
  </div>
  --}}
  @include('layouts.parts.footer')
@endsection