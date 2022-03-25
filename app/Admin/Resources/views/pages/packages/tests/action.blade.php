<div class="text-center">
    @can('delete', $package_test)
        <a href="{{ route('admin.packages.tests.destroy', ['package' => $package_test->package_id,'test' => $package_test->test_id]) }}"
           class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-delete" data-toggle="tooltip"
           data-original-title="Delete"  data-style="zoom-in">
            <span class="ladda-label"><i class="icon wb-trash" aria-hidden="true"></i></span>
        </a>
    @endcan
</div>

