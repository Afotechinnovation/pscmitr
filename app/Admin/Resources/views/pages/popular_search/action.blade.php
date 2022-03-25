
@can('delete', $popular_search)
    <a href="{{ route('admin.popular-searches.destroy', $popular_search->id) }}"
       class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-delete" data-toggle="tooltip"
       data-original-title="Delete"  data-style="zoom-in">
        <span class="ladda-label"><i class="icon wb-trash" aria-hidden="true"></i></span>
    </a>
@endcan
{{--@can('update', $popular_search)--}}
{{--    <a href="{{ route('admin.popular-searches.change-status', $popular_search->id) }}"--}}
{{--       class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-status-change" data-toggle="tooltip"--}}
{{--       data-original-title="Status"  data-style="zoom-in">--}}
{{--        <span class="ladda-label"><i class="icon wb-check-circle" aria-hidden="true"></i></span>--}}
{{--    </a>--}}
{{--@endcan--}}
@if(!$popular_search->status == 1)
    <a href="{{ route('admin.popular-searches.change-status', $popular_search->id) }}"
       class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-status-change" data-toggle="tooltip"
       data-original-title="Status"  data-style="zoom-in">
        <span class="ladda-label"><i class="icon wb-check-circle" aria-hidden="true"></i></span>
    </a>
@else
    <a href="{{ route('admin.popular-searches.change-status', $popular_search->id) }}"
       class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-status-change" data-toggle="tooltip"
       data-original-title="Status"  data-style="zoom-in">
        <span class="ladda-label"><i class="icon wb-reply" aria-hidden="true"></i></span>
    </a>
@endif
