@extends('auth.admin_layouts.main')

@section('title','User Manual')

@section('custom_styles')
    <style>
       .hidden{
           display:none;
       }
    </style>
@endsection

@section('content')
<div class="mdc-layout-grid">
@if ($message = Session::get('status'))
            <div class="alert alert-success alert-block">	
                    <strong>{{ $message }}</strong>
            </div>
            @endif
</div>
<div class="mdc-layout-grid">
    <div class="mdc-layout-grid__inner">
        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
            <div class="mdc-card p-0">
                <h6 class="card-title card-padding pb-0">Edit User Manual</h6>
                <form action="{{ route('user-manual.update', $manual->id) }}" enctype="multipart/form-data" method="post">
                    <div class="mdc-card">
                    @csrf
                    @method('PUT')
                        <div class="template-demo">
                            <div class="mdc-layout-grid__inner">
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                    <input class="mdc-text-field__input" type="file"  name="file" id="file">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label class="mdc-floating-label">File</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                    <select class="mdc-text-field__input"  name="user_type" id="user_type">
                                        <option value="Admin" @if($manual->manual_for == "Admin") Selected @endif>Admin</option>
                                        <option value="User" @if($manual->manual_for == "User") Selected @endif>User</option>
                                    </select>
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label class="mdc-floating-label">User Type</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                    </div>
                                </div>
                                @if($manual->file)
                                <input type="hidden" class="form-control-file" name="hidden_image" value="{{ $manual->file }}">
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                        <a href="{{ URL::to('/') }}/UserManual/{{$manual->file}}" target="_blank">Click to View</a>
                                    </div>
                                </div>
                                @endif
                                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-12-desktop">
                                    <button class="mdc-button mdc-button--unelevated filled-button--success mdc-ripple-upgraded" style="--mdc-ripple-fg-size:56px; --mdc-ripple-fg-scale:1.96936; --mdc-ripple-fg-translate-start:6px, -0.200012px; --mdc-ripple-fg-translate-end:18.8px, -10px;" type="submit" name="submit">
                                        Update Manual
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection