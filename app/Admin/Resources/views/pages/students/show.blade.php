@extends('admin::layouts.app')

@section('title', 'Students')

@section('header')
    <h1 class="page-title mb-2">Students</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.students.index')}}">Students</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$student->name}}</li>
        </ol>
    </nav>
   {{-- <div class="page-header-actions">
        <a class="btn btn-md btn-primary  btn-round" href="{{ route('admin.packages.edit', $package->id) }}">
            <i class="fa fa-edit" aria-hidden="true"></i>
            <span class="text hidden-sm-down">Edit Package</span>
        </a>
    </div>--}}
@endsection

@section('content')
    <div class="card">
        <div class="card-body p-0">
            <div class="card-header bg-white border-bottom p-20">
                <h4 class="card-title m-0">Student Information</h4>
            </div>
            <dl class="">
                <div class="row no-gutters align-items-center bg-light p-15">
                    <dd class="col-md-3 mb-sm-0">Profile Pic</dd>
                    <dt class="col-md-9"> <img width="50" height="50" src="{{$student->image}}"></dt>
                </div>
                <div class="row no-gutters align-items-center p-15">
                    <dd class="col-md-3 mb-sm-0">Name</dd>
                    <dt class="col-md-9">{{$student->name}}</dt>
                </div>
                <div class="row no-gutters align-items-center p-15">
                    <dd class="col-md-3 mb-sm-0">Gender</dd>
                    <dt class="col-md-9"> @if($student->gender == 0) {{ "Female" }} @else {{ "Male" }} @endif</dt>
                </div>
                <div class="row no-gutters align-items-center bg-light p-15">
                    <dd class="col-md-3 mb-sm-0">Date of Birth</dd>
                    <dt class="col-md-9">{{ $student->date_of_birth}}</dt>
                </div>
                <div class="row no-gutters align-items-center bg-light p-15">
                    <dd class="col-md-3 mb-sm-0">Mobile</dd>
                    <dt class="col-md-9">{{ $student->mobile}}</dt>
                </div>

                <div class="row no-gutters align-items-center p-15">
                    <dd class="col-md-3 mb-sm-0">Email</dd>
                    <dt class="col-md-9">{{ $student->email}}</dt>
                </div>
                <div class="row no-gutters align-items-center bg-light p-15">
                    <dd class="col-md-3 mb-sm-0">Country</dd>
                    <dt class="col-md-9">{{ $student->country->name ?? '' }}</dt>
                </div>
                <div class="row no-gutters align-items-center  p-15">
                    <dd class="col-md-3 mb-sm-0">State</dd>
                    <dt class="col-md-9">{{$student->state->name ?? '' }}</dt>
                </div>
                <div class="row no-gutters align-items-center  p-15">
                    <dd class="col-md-3 mb-sm-0">Place</dd>
                    <dt class="col-md-9">{{$student->place }}</dt>
                </div>
                <div class="row no-gutters align-items-center bg-light p-15">
                    <dd class="col-md-3 mb-sm-0">Pincode</dd>
                    <dt class="col-md-9">{{ $student->pin_code }}</dt>
                </div>
                <div class="row no-gutters align-items-center p-15">
                    <dd class="col-md-3 mb-sm-0">Address</dd>
                    <dt class="col-md-9"> {{ $student->address}}</dt>
                </div>
                <div class="row no-gutters align-items-center bg-light p-15">
                    <dd class="col-md-3 mb-sm-0">Occupations</dd>
                    <dt class="col-md-9"> {{ $studentOccupations}}</dt>
                </div>
                <div class="row no-gutters align-items-center p-15">
                    <dd class="col-md-3 mb-sm-0">Interests</dd>
                    <dt class="col-md-9"> {{ $studentInterests}}</dt>
                </div>
            </dl>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link font-size-16 active" data-toggle="tab" href="#transaction" aria-controls="transaction" role="tab" aria-selected="false">Transaction</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link font-size-16 " data-toggle="tab" href="#tests" aria-controls="tests" role="tab" aria-selected="false">Tests</a></li>
            </ul>
        </div>
    </div>

    <div class="nav-tabs-horizontal" data-plugin="tabs">
        <div class="tab-content">
            <div class="tab-pane active" id="transaction" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex align-items-center bg-white border-bottom px-20 py-15">
                        <h4 class="flex-fill">Transactions</h4>
                        <div class="">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                           {!! $tableStudentTransaction->table(['id' => 'table-student-transaction'], true) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane " id="tests" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex align-items-center bg-white border-bottom px-20 py-15">
                        <h4 class="flex-fill">Tests</h4>
                        <div class="">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                         {!! $tableStudentTestResults->table(['id' => 'table-student-tests'], true) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
   {!! $tableStudentTransaction->scripts() !!}
    {!! $tableStudentTestResults->scripts() !!}

@endpush

@push('scripts')
    <script>

    </script>
@endpush
