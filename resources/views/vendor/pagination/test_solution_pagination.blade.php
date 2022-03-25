@if ($paginator->hasPages())
    <div class="row">
        <div class="col-lg-12">
            <ul class="pagination justify-content-center d-flex pt-5">
                @if($paginator->onFirstPage())
                    <li class="page-item m-1 disabled">
                        <a class="page-link rounded-lg btn-round-md p-0 fw-600 shadow-xss bg-white text-grey-900 border-0" href="#" tabindex="-1" aria-disabled="true">
                            <i class="ti-angle-left"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item m-1">
                        <a class="page-link rounded-lg btn-round-md p-0 fw-600 shadow-xss bg-white text-grey-900 border-0"
                           href="{{ url('user/tests/'.$test_id.'/test_result/'.$testresultId.'/solution').'?tab='.$tab.'&page='.($paginator->currentPage() - 1) }}" tabindex="-1" aria-disabled="true">
                            <i class="ti-angle-left"></i>
                        </a>
                    </li>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="disabled"><span>{{ $element }}</span></li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item m-1">
                                    <a class="page-link bg-primary active text-white bg-primary text-white  rounded-lg btn-round-md p-0 fw-600 font-xssss shadow-xss border-0"
                                       href="#">
                                        {{ $page }}
                                    </a>
                                </li>
                            @else

                                <li class="page-item m-1">
                                    <a class="page-link  bg-white text-grey  rounded-lg btn-round-md p-0 fw-600 font-xssss shadow-xss border-0"
                                       href="{{ url('user/tests/'.$test_id.'/test_result/'.$testresultId.'/solution').'?tab='.$tab.'&page='.$page }}">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li class="page-item m-1"><a class="page-link rounded-lg btn-round-md p-0 fw-600 shadow-xss bg-white text-grey-900
                 border-0" href=" {{ url('user/tests/'.$test_id.'/test_result/'.$testresultId.'/solution').'?tab='.$tab.'&page='.($paginator->currentPage() + 1) }}">
                            <i class="ti-angle-right"></i>
                        </a>
                    </li>
                @else

                    <li class="page-item m-1 disabled">
                        <a class="page-link rounded-lg btn-round-md p-0 fw-600 shadow-xss bg-white text-grey-900 border-0" href="#">
                            <i class="ti-angle-right"></i>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
@endif
