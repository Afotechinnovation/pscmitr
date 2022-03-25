@extends('admin::layouts.app')

@section('title', 'Test Ratings')

@section('header')
    <h1 class="page-title">Test Ratings</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route( 'admin.test-attempts.index', $testResult->test_id )}}">Tests</a></li>
            <li class="breadcrumb-item active" aria-current="page"></li>
        </ol>
    </nav>

@endsection

@section('content')

    <div class="card">
        <div class="card-body p-0">

            <div class="col-md-6">
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
                                        @for( $i=1; $i<= 5; $i++ )
                                        <span ><i class="icon wb-star "></i></span>
                                        @endfor
                                    </td>
                                    <td class="text-right" >{{ $test_rating_five }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        @for( $i=1; $i<= 4; $i++ )
                                            <span ><i class="icon wb-star "></i></span>
                                        @endfor
                                        <span ><i class="icon wb-star-outline "></i></span>

                                    </td>
                                    <td class="text-right" >{{ $test_rating_four }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        @for( $i=1; $i<= 3; $i++ )
                                            <span ><i class="icon wb-star "></i></span>
                                        @endfor
                                        @for( $i=1; $i<= 2; $i++ )
                                            <span ><i class="icon wb-star-outline "></i></span>
                                        @endfor
                                    </td>
                                    <td class="text-right" >{{  $test_rating_three }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        @for( $i=1; $i<= 1; $i++ )
                                            <span ><i class="icon wb-star "></i></span>
                                        @endfor
                                        @for( $i=1; $i<= 4; $i++ )
                                            <span ><i class="icon wb-star-outline "></i></span>
                                        @endfor
                                    </td>
                                    <td class="text-right" >{{  $test_rating_two }}</td>
                                </tr>
                                <tr>
                                    <td>

                                        @for( $i=1; $i<= 5; $i++ )
                                            <span ><i class="icon wb-star-outline "></i></span>
                                        @endfor
                                    </td>
                                    <td class="text-right" >{{ $test_rating_one }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection

