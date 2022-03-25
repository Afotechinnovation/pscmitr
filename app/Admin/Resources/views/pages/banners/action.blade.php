<div class="text-center">
    @can('update', $banner)
    <a href="{{ route('admin.banners.edit', $banner->id) }}"
       class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-edit" data-toggle="tooltip"
       data-original-title="Delete"  data-style="zoom-in">
        <span class="ladda-label"><i class="icon wb-edit" aria-hidden="true"></i></span>
    </a>
    @endcan
    @can('delete', $banner)
        <a href="{{ route('admin.banners.destroy', $banner->id) }}"
           class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-delete" data-toggle="tooltip"
           data-original-title="Delete"  data-style="zoom-in">
            <span class="ladda-label"><i class="icon wb-trash" aria-hidden="true"></i></span>
        </a>
    @endcan

</div>

