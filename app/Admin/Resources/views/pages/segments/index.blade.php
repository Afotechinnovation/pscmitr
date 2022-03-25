@extends('admin::layouts.app')

@section('title', 'Segments')

@section('header')
    <h1 class="page-title">Segments</h1>

@endsection

@section('content')
    <div class="card">
        <div class="card-body bg-grey-100">
            <h4 >Create Segment</h4>
            <div class="row p-15">
                <form class="form-inline mb-0" id="form-segment-filter" action="{{ route('admin.user-segments.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input id="name" name="name" type="text" value="{{old('name', request()->input('name'))}}"  class="form-control @error('name') is-invalid @enderror  w-200"
                               value="{{ old('name') }}" autocomplete="off" placeholder="Segment Name">
                        @error('name')
                        <span class="invalid-feedback" role="alert" style="display: inline;">
                                {{ $errors->first('name') }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label w-50">Age : </label>
                        <input id="age_from" name="age_from" type="number" value="{{old('age_from', request()->input('age_from'))}}"  class="form-control @error('age_from') is-invalid @enderror  w-100"
                               value="{{ old('age_from') }}" autocomplete="off" placeholder="From">
                        @error('age_from')
                        <span class="invalid-feedback" role="alert" style="display: inline;">
                                {{ $errors->first('age_from') }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="age_to" name="age_to" type="number" value="{{old('age_to', request()->input('age_to'))}}"  class="form-control @error('age') is-invalid @enderror  w-100"
                               value="{{ old('age_to') }}" autocomplete="off" placeholder="To">
                        @error('age_to')
                        <span class="invalid-feedback" role="alert" style="display: inline;">
                            {{ $errors->first('age_to') }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label w-100 ">Gender : </label>
                        <select id="gender" name="gender" class="form-control w-150" >
                            <option></option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label w-100">Ratings : </label>
                        <select id="rating" name="rating" class="form-control w-150" >
                            <option></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label w-100">Marks : </label>
                        <select id="mark_condition" name="mark_condition" class="form-control w-150" >
                            <option></option>
                            <option value="="> = </option>
                            <option value="<="> < = </option>
                            <option value=">="> > = </option>
                            <option value="<>"> Mark Range</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label w-110">Mark Percentage: </label>
                        <input id="mark_from" name="mark_from" type="number" value="{{old('mark_from', request()->input('mark_from'))}}"  class="form-control @error('mark_from') is-invalid @enderror  w-100"
                               value="{{ old('mark_from') }}" autocomplete="off" placeholder="From">
                        @error('mark_from')
                        <span class="invalid-feedback" role="alert" style="display: inline;">
                                {{ $errors->first('mark_from') }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mark_to" hidden >
                        <input  id="mark_to" name="mark_to" type="number" value="{{old('mark_to', request()->input('mark_to'))}}"  class="form-control @error('mark_to') is-invalid @enderror  w-100"
                               value="{{ old('mark_to') }}" autocomplete="off" placeholder="To">
                        @error('mark_to')
                        <span class="invalid-feedback" role="alert" style="display: inline;">
                            {{ $errors->first('mark_to') }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label w-100">Courses : </label>
                        <select id="courses" name="courses[]" multiple class="form-control w-200" >
                            @foreach( $courses as $course )
                                <option @if (old('courses') == $course->id) selected @endif
                                value="{{ $course->id }}">{{ $course->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label w-100">Tests : </label>
                        <select id="tests" name="tests[]" multiple class="form-control w-200" >
                            @foreach($tests as $test )
                                <option @if (old('tests') == $test->id) selected @endif
                                value="{{ $test->id }}">{{ $test->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                <div class="row  p-15">
                    <div class="form-group">
                        <button class="btn btn-primary btn-outline" id="button-filter" type="submit">Create</button>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('admin.user-segments.index') }}">
                            <button class="btn btn-primary btn-outline" id="btn-clear" type="button">Cancel</button>
                        </a>
                    </div>
                </div>
            </form>
            </div>
        </div>
        <div class="card-body">
            {!! $table->table(['id' => 'table-segments'], true) !!}
        </div>
    </div>
@endsection

@push('scripts')
    {!! $table->scripts() !!}
@endpush

@push('scripts')
    <script>
        $(function() {
            let $table = $('#table-segments');

            $("#rating").select2({
                placeholder: 'Select Rating'
            });
            $("#gender").select2({
                placeholder: 'Select Gender'
            });
            $("#mark_condition").select2({
                placeholder: 'Select Condition'
            });
            $("#courses").select2({
                placeholder: 'Select Course'
            });
            $("#tests").select2({
                placeholder: 'Select Tests'
            });
            $("#mark_condition").on("change", function() {
                if ($(this).val() == "<>") {
                    $(".mark_to").attr('hidden', false);
                }else {
                    $(".mark_to").attr('hidden', true);
                }

            });


            $('#form-segment-filter').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255
                    },
                    mark_from: {
                        required: {
                            depends: function(element){
                                if ($('#mark_condition').val()) {
                                    return true;
                                } else {
                                    return false;
                                }
                            }
                        }
                    },
                    mark_to: {
                        required: {
                            depends: function(element){
                                if ($('#mark_condition').val() == '<>') {
                                    return true;
                                } else {
                                    return false;
                                }
                            }
                        }
                    },

                },
                messages: {
                    mark_from : {
                        required : "Mark From is required!",
                    },
                    mark_to : {
                        required : "Mark To is required!",
                    }
                },
            });
        })
    </script>
@endpush
