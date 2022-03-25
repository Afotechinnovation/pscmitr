<div class="text-center">

  @can('delete', $package_categories)
        <a href="{{ route('admin.packages.category.destroy', ['package' => $package_categories->package_id, 'category' => $package_categories->id]) }}"
           class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-delete" data-toggle="tooltip"
           data-original-title="Delete"  data-style="zoom-in">
            <span class="ladda-label"><i class="icon wb-trash" aria-hidden="true"></i></span>
        </a>
  @endcan
</div>
