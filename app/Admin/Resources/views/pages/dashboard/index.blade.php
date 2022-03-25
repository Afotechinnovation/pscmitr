@extends('admin::layouts.app')

@section('title', 'Dashboard')

@section('header')
    <h1 class="page-title">Dashboard</h1>

@endsection

@section('content')
    <div class="card">
        <div class="card-body bg-grey-100">
            <div class="row p-15">
                <h3 class="text-black text-center">Overview</h3>
            </div>
            <div class="row  p-15">
                <form class="form-inline mb-0" id="form-filter" action="{{ route('admin.dashboard') }}" method="GET">
                    <div class="form-group ">
                        <x-inputs.courses id="course_id"  class=" w-200">
                            @if (request()->filled('course_id') && request()->filled('course_id_text'))
                                <option value="{{ old('course_id', request()->input('course_id')) }}" selected>{{ old('course_id', request()->input('course_id_text')) }}</option>
                            @endif
                        </x-inputs.courses>
                    </div>
                     <div class="form-group">
                        <select id="test" name="test" class="form-control w-200" >
                            <option></option>
                            @foreach($tests as $userTest)
                                <option value="{{ $userTest->id }}"  @if($test == $userTest->id) selected @endif>{{ $userTest->name }} </option>
                            @endforeach
                        </select>
                     </div>
                     <div class="form-group">
{{--                         <div class="input-group mb-3">--}}
{{--                             <input  name="date_range" type="text" value="{{old('date_range', request()->input('date_range'))}}"  class="form-control @error('date_range') is-invalid @enderror"--}}
{{--                             autocomplete="off" placeholder="Select Date">--}}
{{--                             <div class="input-group-append">--}}
{{--                                 <button class="btn btn-secondary"  type="button" id="date-range" >--}}
{{--                                     Date--}}
{{--                                 </button>--}}
{{--                             </div>--}}
{{--                             @error('date_range')--}}
{{--                                 <span class="invalid-feedback" role="alert" style="display: inline;">--}}
{{--                                {{ $errors->first('date_range') }}--}}
{{--                                 </span>--}}
{{--                             @enderror--}}
{{--                         </div>--}}

                        <input id="date" name="date_range" type="text" value="{{old('date_range', request()->input('date_range'))}}"  class="form-control @error('date_range') is-invalid @enderror"
                               autocomplete="off" placeholder="Select Date">

                     </div>
                    <div class="form-group ">
                        <x-inputs.countries id="country_id"  class=" w-200">
                            @if (request()->filled('country_id') && request()->filled('country_id_text'))
                                <option value="{{ old('country_id', request()->input('country_id')) }}" selected>{{ old('country_id', request()->input('country_id_text')) }}</option>
                            @endif
                        </x-inputs.countries>
                    </div>
                    <div class="form-group ">
                        <x-inputs.states id="state_id" related="#country_id"  class=" w-200">
                            @if (request()->filled('state_id') && request()->filled('state_text'))
                                <option value="{{ old('state_id', request()->input('state_id')) }}" selected>{{ old('state_id', request()->input('state_text')) }}</option>
                            @endif
                        </x-inputs.states>
                    </div>
                    <div class="form-group">
                        <input id="age" name="age" type="number" min="1" value="{{old('age', request()->input('age'))}}"  class="form-control @error('age') is-invalid @enderror  w-100"
                               value="{{ old('age') }}" autocomplete="off" placeholder="Age">
                        @error('age')
                        <span class="invalid-feedback" role="alert" style="display: inline;">
                            {{ $errors->first('age') }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <select id="gender" name="gender" class="form-control w-200" >
                            <option></option>
                            <option @if ($gender == 'male') selected @endif value="male">Male</option>
                            <option  @if ($gender == 'female') selected @endif value="female">Female</option>
                        </select>
                    </div>

                    <div class="row  p-15">
                        <div class="form-group">
                            <button class="btn btn-primary btn-outline" id="button-filter" type="submit">Search</button>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('admin.dashboard') }}">
                                <button class="btn btn-primary btn-outline" id="btn-clear" type="button">Cancel</button>
                            </a>
                        </div>
                    </div>

                </form>
            </div>


            <div class="row pt-20">
                <!-- First Row -->
                <div class="col-xl-3 col-md-6 info-panel ">
                    <div class="card card-shadow">
                        <div class="card-block bg-white p-20">
                            <button type="button" class="btn btn-floating btn-sm btn-warning">
                                <i class="icon wb-users"></i>
                            </button>
                            <span class="ml-15 font-weight-400">TOTAL USERS</span>
                            <div class="content-text text-center mb-0">
                                <i class="text-danger icon wb-triangle-up font-size-20">
                                </i>
                                <span class="font-size-40 font-weight-100">{{$total_users->count() }}</span>
{{--                                <p class="blue-grey-400 font-weight-100 m-0">{{ round($user_percentage_of_increment, 2) }}% From previous month</p>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 info-panel">
                    <div class="card card-shadow">
                        <div class="card-block bg-white p-20">
                            <button type="button" class="btn btn-floating btn-sm btn-danger">
                                <i class="icon wb-user"></i>
                            </button>
                            <span class="ml-15 font-weight-400">DORMANT USERS</span>
                            <div class="content-text text-center mb-0">
                                <i class="text-success icon wb-triangle-down font-size-20">
                                </i>
                                <span class="font-size-40 font-weight-100">
                                    {{$total_users->count() - $subscribers->count() }}
                                </span>
{{--                                <p class="blue-grey-400 font-weight-100 m-0">{{round($dormant_user_percentage_of_increment, 2)}}% From previous month</p>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 info-panel">
                    <div class="card card-shadow">
                        <div class="card-block bg-white p-20">
                            <button type="button" class="btn btn-floating btn-sm btn-success">
                                <i class="icon wb-users"></i>
                            </button>
                            <span class="ml-15 font-weight-400">SUBSCRIBERS</span>
                            <div class="content-text text-center mb-0">
                                <i class="text-danger icon wb-triangle-up font-size-20">
                                </i>
                                <span class="font-size-40 font-weight-100">{{$subscribers->count()}}</span>
{{--                                <p class="blue-grey-400 font-weight-100 m-0">{{ round($subscriber_percentage_of_increment, 2) }}% From previous month</p>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 info-panel">
                    <div class="card card-shadow">
                        <div class="card-block bg-white p-20">
                            <button type="button" class="btn btn-floating btn-sm btn-primary">
                                <i class="icon wb-user"></i>
                            </button>
                            <span class="ml-15 font-weight-400">DORMANT SUBSCRIBERS</span>
                            <div class="content-text text-center mb-0">
                                <i class="text-danger icon wb-triangle-up font-size-20">
                                </i>
                                <span class="font-size-40 font-weight-100">{{$dormant_subscriber_count}}</span>
{{--                                <p class="blue-grey-400 font-weight-100 m-0">0% From previous month</p>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 info-panel">
                    <div class="card card-shadow">
                        <div class="card-block bg-white p-20">
                            <button type="button" class="btn btn-floating btn-sm btn-info">
                                <i class="icon wb-user"></i>
                            </button>
                            <span class="ml-15 font-weight-400">TOTAL SUBSCRIPTIONS</span>
                            <div class="content-text text-center mb-0">
                                <i class="text-danger icon wb-triangle-up font-size-20">
                                </i>
                                <span class="font-size-40 font-weight-100">{{$total_subscriptions->count()}}</span>
{{--                                <p class="blue-grey-400 font-weight-100 m-0">{{round($subscription_percentage_of_increment, 2)}}% From previous month</p>--}}
                            </div>
                        </div>
                    </div>
                    <div  style="height: 520.781px;">
                        <!-- Countries Vists Card -->
                        <div id="countriesVistsWidget" class="card card-shadow card-md">
                            <div class="card-header card-header-transparent pb-15">
                                <p class="font-size-14 blue-grey-700 mb-0">ADMINS</p>
                            </div>
                            <div class="card-block px-30 pt-0">
                                <div class="table-responsive">
                                    <table class="table table-analytics mb-0 text-nowrap">
                                        <thead>
                                        <tr>
                                            <th class="language">TOTAL</th>
                                            <th class="vists text-right">COUNTS</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <a href="{{ route("admin.admins.index") }}" class="blue-grey-700" style="text-decoration: none">Admins </a>
                                            </td>
                                            <td class="text-right">{{$admins->count()}}</td>
                                        </tr>
{{--                                        <tr>--}}
{{--                                            <td>--}}
{{--                                                <a href="#" class="blue-grey-700" style="text-decoration: none">Test Creators</a>--}}
{{--                                            </td>--}}
{{--                                            <td class="text-right">2</td>--}}
{{--                                        </tr>--}}
{{--                                        <tr>--}}
{{--                                            <td>--}}
{{--                                                <a href="#" class="blue-grey-700" style="text-decoration: none">Data Entry</a>--}}
{{--                                            </td>--}}
{{--                                            <td class="text-right">9</td>--}}
{{--                                        </tr>--}}

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End Countries Vists Card -->
                    </div>
                </div>

                <div class="col-xl-5 col-12" style="height: 520.781px;">
                    <!-- Countries Vists Card -->
                    <div id="countriesVistsWidget" class="card card-shadow card-md">
                        <div class="card-header card-header-transparent pb-15">
                            <p class="font-size-14 blue-grey-700 mb-0">VISITS IN DIFFERENT PAGES</p>
                        </div>
                        <div class="card-block px-30 pt-0">
                            <div class="table-responsive">
                                <table class="table table-analytics mb-0 text-nowrap">
                                    <thead>
                                    <tr>
                                        <th class="language">TOTAL</th>
                                        <th class="vists text-right">COUNTS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                         <a href="{{route("admin.tests.index")}}" class="blue-grey-700" style="text-decoration: none" >Tests </a>
                                        </td>
                                        <td class="text-right" >{{$testCounts->count()}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="{{ route("admin.courses.index") }}" class="blue-grey-700" style="text-decoration: none" >Courses</a>
                                        </td>
                                        <td class="text-right">{{$courses->count()}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a  href="{{ route("admin.blogs.index") }}" class="blue-grey-700" style="text-decoration: none" >Blogs</a>
                                        </td>
                                        <td class="text-right">{{$blogs->count()}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="{{ route("admin.videos.index") }}" class="blue-grey-700" style="text-decoration: none" >Videos</a>
                                        </td>
                                        <td class="text-right">{{$videos->count()}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                          <a href="{{ route("admin.exam-notifications.index") }}" class="blue-grey-700" style="text-decoration: none" >Exam Notifications</a>
                                        </td>
                                        <td class="text-right">{{$exam_notifications->count()}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="#" class="blue-grey-700" style="text-decoration: none" >Doubts Cleared</a>
                                        </td>
                                        <td class="text-right">{{$user_doubts->count()}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End Countries Vists Card -->
                </div>
                <div class="col-xl-4 col-12" style="height: 520.781px;">
                    <!-- Countries Vists Card -->
                    <div id="countriesVistsWidget" class="card card-shadow card-md">
                        <div class="card-header card-header-transparent pb-15">
                            <p class="font-size-14 blue-grey-700 mb-0">RATINGS</p>
                        </div>
                        <div class="card-block px-30 pt-0">
                            <div class="table-responsive">
                                <table class="table table-analytics mb-0 text-nowrap">
                                    <thead>
                                    <tr>
                                        <th class="language">TOTAL</th>
                                        <th class="vists text-right">COUNTS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <span ><i class="icon wb-star "></i></span>
                                            <span><i class="icon wb-star "></i></span>
                                            <span ><i class="icon wb-star "></i></span>
                                            <span ><i class="icon wb-star "></i></span>
                                            <span ><i class="icon wb-star "></i></span>
                                        </td>
                                        <td class="text-right" >{{  $package_rating_five }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span ><i class="icon wb-star"></i></span>
                                            <span><i class="icon wb-star"></i></span>
                                            <span ><i class="icon wb-star"></i></span>
                                            <span ><i class="icon wb-star"></i></span>
                                            <span ><i class="icon wb-star-outline"></i></span>

                                        </td>
                                        <td class="text-right" >{{  $package_rating_four }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span ><i class="icon wb-star "></i></span>
                                            <span><i class="icon wb-star "></i></span>
                                            <span ><i class="icon wb-star "></i></span>
                                            <span ><i class="icon wb-star-outline"></i></span>
                                            <span ><i class="icon wb-star-outline"></i></span>
                                        </td>
                                        <td class="text-right" >{{  $package_rating_three }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span ><i class="icon wb-star "></i></span>
                                            <span><i class="icon wb-star "></i></span>
                                            <span ><i class="icon wb-star-outline"></i></span>
                                            <span ><i class="icon wb-star-outline"></i></span>
                                            <span ><i class="icon wb-star-outline"></i></span>
                                        </td>
                                        <td class="text-right" >{{ $package_rating_two }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span ><i class="icon wb-star "></i></span>
                                            <span ><i class="icon wb-star-outline"></i></span>
                                            <span ><i class="icon wb-star-outline"></i></span>
                                            <span ><i class="icon wb-star-outline"></i></span>
                                            <span ><i class="icon wb-star-outline"></i></span>
                                        </td>
                                        <td class="text-right" >{{  $package_rating_one }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End Countries Vists Card -->
                </div>
                <!-- End First Row -->
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>

        $( document ).ready(function() {
            $('#date').daterangepicker({
                locale: {
                    autoUpdateInput: false,
                    format: 'YYYY-MM-DD'
                }
            });

            $("#test").select2({
                placeholder: 'Choose Test'
            });
            $("#gender").select2({
                placeholder: 'Choose Gender'
            });

        });

        //
        // $('#date').daterangepicker({autoUpdateInput: false}, (from_date, to_date) => {
        //    // console.log(from_date.toDate(), to_date.toDate());
        //     $('#date').val(from_date.format('YYYY-MM-DD') + ' - ' + to_date.format('YYYY-MM-DD'));
        // });

    </script>

@endpush



