@extends('admin::layouts.app')

@section('title', 'Students')

@section('header')
    <h1 class="page-title">Student</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.students.index')}}">Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="panel">
        <form id="form-update" method="POST" action="{{ route('admin.students.update', $student->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="panel-body pt-40 pb-5">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" value="{{ old('name', $student->name)  }}">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">E-Mail</label>
                                    <div class="col-sm-8">
                                        <input type="email" id="email"  placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $student->email) }}">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Country</label>
                                    <div class="col-sm-8">
                                        <x-inputs.countries id="country_id"  class="{{ $errors->has('country_id') ? ' is-invalid' : '' }}  ">
                                            @if(!empty(old('country_id', $student->country_id)))
                                                <option value="{{ old('country_id', $student->country_id) }}" selected>
                                                    {{ old('country_id_text', empty($student->country) ? '' : $student->country->name) }}</option>
                                            @endif
                                        </x-inputs.countries>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">State</label>
                                    <div class="col-sm-8">
                                        <x-inputs.states id="state_id" related="#country_id"  class="{{ $errors->has('state_id') ? ' is-invalid' : '' }}  ">
                                            @if(!empty(old('state_id', $student->state_id)))
                                                <option value="{{ old('state_id', $student->state_id) }}" selected>
                                                    {{ old('state_id_text', empty($student->state) ? '' : $student->state->name) }}</option>
                                            @endif
                                        </x-inputs.states>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Mobile</label>
                                    <div class="col-sm-8">
                                        <input type="tel" maxlength="10" class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile" name="mobile" value="{{ old('mobile', $student->mobile) }}">
                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Gender</label>
                                    <div class="col-sm-8">
                                        <div class="form-check icon-input text-left pl-0">
                                            <div class="form-check form-check-inline" >
                                                <input class="form-check-input " type="radio"  id="inlineRadio1"  name="gender" value="1" {{ old('gender', $student->gender)  == '1' ? 'checked' : ''}}>
                                                <label class="form-check-label font-xsss mb-0  fw-500" for="inlineRadio1">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"  name="gender" id="inlineRadio2" value="0" {{ old('gender', $student->gender)  == '0' ? 'checked' : ''}}>
                                                <label class="form-check-label font-xsss mb-0 fw-500" for="inlineRadio2">Female</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Date Of Birth</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror student_date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth) }}">
                                        @error('date_of_birth')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Choose Image </label>
                                    <div class="col-md-8">
                                        <input type="file" onchange="loadFile(event)"  id="image" name="image"
                                               class="form-control @error('image') is-invalid @enderror"  accept="image/*" style="padding-top: 3px;overflow: hidden">
                                        @error('image')
                                        <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('image') }}
                                        </span><br>
                                        @enderror
                                        <span class="text-info" role="alert"  style="display: inline;">
                                  <small> ** Recommended Maximum size for image - 300 x 300 </small>
                                </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Occupations </label>
                                    <div class="col-md-8">
                                        <select name="occupations[]" id="occupations" multiple class="form-control
                                                            @error('occupations') is-invalid @enderror" style="width: 100%;" >
                                            <option></option>
                                            @foreach($occupations as $occupation)
                                                <option
                                                    @foreach($userOccupations as $userOccupation)
                                                    @if( $userOccupation->occupation_id == $occupation->id) selected @endif
                                                    @endforeach
                                                    value=" {{ $occupation->id }}" >{{ $occupation->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Interests </label>
                                    <div class="col-md-8">
                                        <select name="interests[]" id="interests" multiple class="form-control
                                                            @error('interests') is-invalid @enderror" style="width: 100%;" >
                                            <option></option>
                                            @foreach($interests as $interest)
                                                <option
                                                    @foreach($userInterests as $userInterest)
                                                    @if($userInterest->course_id == $interest->id) selected @endif
                                                    @endforeach
                                                    value=" {{ $interest->id }}" >{{ $interest->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Address</label>
                                    <div class="col-sm-8">
                                        <textarea cols="2" rows="5" placeholder="Address" class=" form-control @error('address') is-invalid @enderror"  name="address" id="address">{{ old('address', $student->address) }}</textarea>
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label  class="col-sm-3 col-form-label">Pin Code</label>
                                    <div class="col-sm-8">
                                        <input type="number" maxlength="6" placeholder="Pincode" class="form-control @error('pin_code') is-invalid @enderror" name="pin_code" value="{{ old('pin_code', $student->pin_code) }}">
                                        @error('pin_code')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6" >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="cropped-testimonial-image p-5"  >
                                    <img width="100%" src="{{ $student->image }}"  data-toggle="tooltip" data-placement="top" title="Cropped Image" id="cropped-testimonial-photo" class="img-thumbnail" ><br>
                                    <p class="text-center"><small class="text-info">Student Image</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <hr/>
            <div class="panel-footer">
                <div class="row">
                    @can('update', $student)
                        <div class="col-md-12">
                            <button class="btn btn-primary float-right" type="submit">UPDATE</button>
                        </div>
                    @endcan
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        var loadFile = function(event) {
            var image = document.getElementById('cropped-testimonial-photo');
            var image_src = event.target.files[0];
            if(image_src){
                image.src = URL.createObjectURL(image_src);
            }
        }
        $(function() {
            $("#occupations").select2({
                placeholder: ' Select Occupations'
            });

            $("#interests").select2({
                placeholder: ' Select Interests'
            });
            $(".user_date_of_birth").mask("99/99/9999");

            $('#form-update').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255
                    }
                }
            })
        });
    </script>
@endpush
