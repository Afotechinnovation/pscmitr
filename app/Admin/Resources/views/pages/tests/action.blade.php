@can('view', $test)
    <a href="{{ route('admin.tests.show', $test->id) }}"
       class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-edit" data-toggle="tooltip" data-original-title="Edit"
       data-plugin="ladda" data-style="zoom-in"><span class="ladda-label"><i class="icon wb-eye" aria-hidden="true"></i></span>
    </a>
@endcan

@can('update', $test)
    @if(!$test->is_live_now)
        <a href="#" data-test-id="{{ $test->id }}" data-test-date="{{ $test->today_test_date }}"  data-today-test ="{{ $test->is_today_test }}"  class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-today-test">
            <span class="badge badge-success"> @if (($test->is_today_test && $test->today_test_date == \Carbon\Carbon::today()->toDateString())) Today Test @else Add To Today Test @endif</span>
        </a>
    @endif
    <a href="#" data-test-id="{{ $test->id }}" data-live-test-date-time="{{ $test->live_test_date_time }}"  data-live-test-duration="{{ $test->live_test_duration }}"  data-is-live-test ="{{ $test->is_live_test }}"  class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-live-test">
        <span class="badge badge-success"> @if ($test->is_live_now) Live Test @else Add To Live Test @endif</span>
    </a>
    @if(!$test->is_published)
        <a href="{{ route('admin.tests.publish', $test->id) }}" class="btn btn-sm btn-icon btn-pure btn-default ladda-button
        button-publish" data-publish="1"  data-toggle="tooltip" data-original-title="Publish" data-plugin="ladda" data-style="zoom-in">
            <span class="ladda-label"><i class="icon  wb-check-circle" aria-hidden="true"></i></span>
        </a>
    @else
        @if(!in_array($test->id, $isUserAttemptedTest))
            <a href="{{ route('admin.tests.publish', $test->id) }}" class="btn btn-sm btn-icon btn-pure btn-default ladda-button
            button-publish"  data-publish="0" data-toggle="tooltip" data-original-title="Edit" data-plugin="ladda" data-style="zoom-in">
                <span class="ladda-label"><i class="icon wb-reply" aria-hidden="true"></i></span>
            </a>
        @endif
    @endif
    @if(!in_array($test->id, $isUserAttemptedTest))
        <a href="{{ route('admin.tests.edit', $test->id) }}"
           class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-edit" data-toggle="tooltip" data-original-title="Edit"
           data-plugin="ladda" data-style="zoom-in"><span class="ladda-label"><i class="icon wb-edit" aria-hidden="true"></i></span>
        </a>
    @endif

    @if($test->is_published)

    <a href="#" data-test-id="{{ $test->name_slug }}"
       class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-copy-test" data-toggle="tooltip" data-original-title="Edit"
       data-plugin="ladda" data-style="zoom-in"><span class="ladda-label"><i class="icon wb-clipboard" aria-hidden="true"></i></span>
    </a>
    @endif

@endcan


@if(!in_array($test->id, $isUserAttemptedTest))
    @can('delete', $test)
        <a href="{{ route('admin.tests.destroy', $test->id) }}"
           class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-delete" data-toggle="tooltip"
           data-original-title="Delete"  data-style="zoom-in">
            <span class="ladda-label"><i class="icon wb-trash" aria-hidden="true"></i></span>
        </a>
    @endcan
@endif



