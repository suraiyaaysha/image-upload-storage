@extends('layouts.app')

@push('style')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" style="background: gray; color:#f1f7fa; font-weight:bold;">
                    Create New User
                    <a href="{{ route('user.index') }}" class="btn btn-success btn-xs py-0 float-end">Back</a>
                </div>
                @if($errors->any())
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                @endif
                 <div class="card-body">
                    <form class="w-px-500 p-3 p-md-3" action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" placeholder="Name" @error('name') is-invalid @enderror>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="email" placeholder="Email" @error('email') is-invalid @enderror>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password" placeholder="Password" @error('password') is-invalid @enderror>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Only show uploaded image/ Normally we do like this --}}
                        {{-- <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Profile Pic</label>
                            <div class="col-sm-9">
                              <input type="file" class="form-control" name="image" @error('image') is-invalid @enderror>
                            </div>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}
                        {{-- Only show uploaded image/ Normally we do like this --}}

                        {{-- Image Upload with Preview --}}
                         <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Profile Pic</label>
                            <div class="col-sm-9">
                              <input type="file" class="form-control" name="image" @error('image') is-invalid @enderror id="selectImage">
                            </div>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <img id="preview" src="#" alt="your image" class="mt-3" style="display:none;"/>
                        </div>
                        {{-- Image Upload with Preview --}}


                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-secondary btn-block text-danger">Submit</button>
                            </div>
                        </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Script for Uploaded image preview show --}}
@push('script')
    <script>
        selectImage.onchange = evt => {
            preview = document.getElementById('preview');
            preview.style.display = 'block';
            const [file] = selectImage.files
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }
    </script>
@endpush
{{-- Script for Uploaded image preview show --}}
