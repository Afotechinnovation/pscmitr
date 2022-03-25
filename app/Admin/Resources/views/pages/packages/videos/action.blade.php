<div class="text-center">
    {{-- @can('update', $package_video)--}}
    <a href="{{ route('admin.packages.videos.edit', ['package' => $package_video->package_id,'video' => $package_video->id]) }}"
       class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-edit" data-toggle="tooltip" data-original-title="Edit"
       data-plugin="ladda" data-style="zoom-in"><span class="ladda-label"><i class="icon wb-edit" aria-hidden="true"></i></span>
    </a>
    {{--@endcan--}}
    @can('delete', $package_video)
    <a href="{{ route('admin.packages.videos.destroy', ['package' => $package_video->package_id,'video' => $package_video->video_id]) }}"
       class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-delete" data-toggle="tooltip"
       data-original-title="Delete"  data-style="zoom-in">
        <span class="ladda-label"><i class="icon wb-trash" aria-hidden="true"></i></span>
    </a>
    @endcan

</div>
