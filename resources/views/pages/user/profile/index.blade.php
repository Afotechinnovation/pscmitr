@extends('layouts.app')
@section('title', 'Packages')
@section('content')
    <style>
        .modal-open .select2-container{
            z-index: 0 !important;
        }
        .select2-container {
            width: auto !important;
        }
    </style>
    <div class="course-details pb-lg--7 pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card d-block w-100 border-0 shadow-xss rounded-lg overflow-hidden ">
                        <div class="card-body mb-3 pb-0">
                            <h2 class="fw-400 font-lg d-block">My  <b>Profile</b></h2>
                        </div>
                        <style>
                            .modal-open .select2-container{
                                z-index: 0 !important;
                            }
                        </style>
                        <form id="profile-update"  class="p-3" method="POST" action="{{ route('user.profile.update', $student->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <input type="hidden" name="packageId" id="packageId" value="">
                                            <div class="form-group row">
                                                <label  class="col-sm-3 col-form-label">Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" required name="name" value="{{ $student['name'] }}">
                                                    @error('name')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label  class="col-sm-3 col-form-label">E-Mail</label>
                                                <div class="col-sm-8">
                                                    <input type="email" id="email"  placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $student['email'] }}">
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label  class="col-sm-3 col-form-label">Country</label>
                                                <div class="col-sm-8" >
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
                                                    <input type="tel" maxlength="10" class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile" name="mobile" value="{{ $student['mobile'] }}">
                                                    @error('mobile')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label  class="col-sm-3 col-form-label">Gender</label>
                                                <div class="col-sm-12 col-md-8">
                                                    <div class="form-check icon-input text-left pl-0">
                                                        <div class="form-check form-check-inline" >
                                                            <input class="form-check-input " type="radio"  id="inlineRadio1"  name="gender" value="1" {{ $student->gender == '1' ? 'checked' : ''}}>
                                                            <label class="form-check-label font-xsss mb-0  fw-500" for="inlineRadio1">Male</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"  name="gender" id="inlineRadio2" value="0" {{ $student->gender == '0' ? 'checked' : ''}}>
                                                            <label class="form-check-label font-xsss mb-0 fw-500" for="inlineRadio2">Female</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label  class="col-sm-3 col-form-label">Date Of Birth</label>
                                                <div class="col-sm-8">
                                                    <input  type="date" class="form-control @error('date_of_birth') is-invalid @enderror student_date_of_birth" name="date_of_birth" value="{{ $student['date_of_birth'] }}">
                                                    @error('date_of_birth')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                    @enderror
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
                                                                @if($userOccupation->occupation_id == $occupation->id) selected @endif
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
                                                    <textarea cols="2" rows="2" placeholder="Address" class=" form-control @error('address') is-invalid @enderror"  name="address" id="address">{{ $student['address'] }}</textarea>
                                                    @error('address')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label  class="col-sm-3 col-form-label">Pin Code</label>
                                                <div class="col-sm-8">
                                                    <input type="number" maxlength="6" placeholder="Pincode" class="form-control @error('pin_code') is-invalid @enderror" name="pin_code" value="{{ $student['pin_code'] }}">
                                                    @error('pin_code')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-column align-items-center text-center ">
                                               <h4 class="text-info">Click on image to update Image </h4>
                                                    <img src="@if($student['image']) {{$student['image']}} @elseif($student['gender'] == 0) {{ url('/web/images/female-avatar.jpeg') }} @else {{ url('/web/images/avatar.jpg') }} @endif" id="cropped-profile-photo"
                                                         data-toggle="modal"  data-target="#imageUploadModal"  alt="student" class="rounded-circle imageClick" width="150" data-packageId="{{ $packageId }}">
                                                    <div class="mt-3">
                                                        <h4 class=" text-info ">{{ $student->name }}</h4>
                                                        <p class="text-info mb-1">{{ $student->mobile }}</p>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3  p-3">
                                    <button type="submit" class="btn btn-default btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>

        let packageId = '{{ $packageId }}';
        $("#packageId").val(packageId);

        $(function() {

            $(".imageClick").click(function (e) {
                e.preventDefault();

                let packageId = '{{ $packageId }}';
                $(".modal-body #packageId").val(packageId);
            });

            $("#occupations").select2({
                placeholder: ' Select Occupations'
            });

            $("#interests").select2({
                placeholder: ' Select Interests'
            });
            $(".user_date_of_birth").mask("99/99/9999");

            $('#profile-update').validate({
                rules: {
                    mobile: {
                        required: true,
                        number: true,
                    },
                    name:{
                        required: true,
                    },
                    email: {
                        required: true,
                        email : true,
                        unique: true,
                    },
                }
            })

        });

    </script>
@endpush
