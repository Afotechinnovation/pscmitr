@can('update', $admin)
<a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-sm btn-icon btn-pure btn-default ladda-button btn-edit" data-toggle="tooltip" data-original-title="Edit" data-plugin="ladda" data-style="zoom-in">
    <span class="ladda-label"><i class="icon wb-edit" aria-hidden="true"></i></span>
</a>
@endcan
{{--<a href="{{ route('admin.admins.destroy', $id) }}" class="btn btn-sm btn-icon btn-pure btn-default ladda-button btn-delete" data-toggle="tooltip" data-original-title="Delete"  data-style="zoom-in">--}}{{--
    <span class="ladda-label"><i class="icon wb-trash" aria-hidden="true"></i></span>
</a>--}}
