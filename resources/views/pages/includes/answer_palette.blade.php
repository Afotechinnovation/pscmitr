<div class="modal p-0 right side fade" id="ModalQuestionPallete" tabindex="-1" role="dialog">
    <div class="modal-dialog ml-auto mr-0 mt-0" role="document">
        <div class="modal-content border-0 rounded-0 p-3">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti-close text-grey-500"></i></button>
            <div class="modal-body pl-0 vh-100 d-flex align-items-start flex-column">
                <div class="row">
                    <div class="col-12 pt-2 pl-4 pb-4 pr-2">
                        <h6 class="fw-900 font-xs mb-2">Answer Palette</h6>
                        <div class="card w-100 border-0 mt-4">
                            <div class="row m-0">
                                @if(\Illuminate\Support\Facades\Auth::user())
                                    @if( $testQuestions )
                                        @foreach( $testQuestions as $key => $question )
                                            <a href="{{ url('user/tests/'. $test->id .'?package=' .$packageId. '&question='.($key +1)) }}">
                                                <span class="circle mb-2"> {{ $key +1 }} </span>
                                            </a>
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12 pl-0">

                        <div class="card w-100 border-0" style="position: fixed; bottom: 10%;">
                            <hr class="bold">
                            <div class="col-12 pl-5">
                                <div class="row">
                                    <span class="dot bg-info d-inline-block mb-2"></span>
                                    <span class="d-inline-block pl-3">Attempted</span>
                                </div>
                            </div>
                            <div class="col-12 pl-5">
                                <div class="row">
                                    <span class="dot d-inline-block mb-2"></span>
                                    <span class="d-inline-block pl-3">Unattempted</span>
                                </div>
                            </div>
                            <div class="col-12 pl-5">
                                <div class="row">
                                    <span class="dot bg-purple d-inline-block mb-2"></span>
                                    <span class="d-inline-block pl-3">Marked for Review</span>
                                </div>
                            </div>
                            <div class="col-12 pl-5">
                                <div class="row">
                                    <a href="{{ url('user/tests/1/result') }}">
                                        <button type="button"  class="btn p-1 mt-3 btn-outline-success text-success
                                         fw-700 lh-30 rounded-lg  w150 font-xsssss ls-3 bg-white">
                                            SUBMIT TEST
                                        </button>
                                    </a>
                                    <a href="#">
                                        <button type="button"  class="btn p-1 mt-3 ml-3 d-inline-block btn-outline-warning text-warning
                                         fw-700 lh-30 rounded-lg  w150 font-xsssss ls-3 bg-white">
                                            PAUSE & EXIT
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
