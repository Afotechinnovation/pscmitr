@can('update', $blog)
    @if(!$blog->is_published)
        <a href="{{ route('admin.blogs.publish', $blog->id) }}" class="btn btn-sm btn-icon btn-pure btn-default ladda-button
        button-publish" data-publish="1"  data-toggle="tooltip" data-original-title="Publish" data-plugin="ladda" data-style="zoom-in">
            <span class="ladda-label"><i class="icon  wb-check-circle" aria-hidden="true"></i></span>
        </a>
    @else
        <a href="{{ route('admin.blogs.publish', $blog->id) }}" class="btn btn-sm btn-icon btn-pure btn-default ladda-button
        button-publish"  data-publish="0" data-toggle="tooltip" data-original-title="Edit" data-plugin="ladda" data-style="zoom-in">
            <span class="ladda-label"><i class="icon wb-reply" aria-hidden="true"></i></span>
        </a>
    @endif
    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-icon btn-pure btn-default ladda-button
    button-edit" data-toggle="tooltip" data-original-title="Edit" data-plugin="ladda" data-style="zoom-in">
        <span class="ladda-label"><i class="icon wb-edit" aria-hidden="true"></i></span>
    </a>
@endcan
@can('delete', $blog)
<a href="{{ route('admin.blogs.destroy', $blog->id) }}"
   class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-delete" data-toggle="tooltip"
   data-original-title="Delete"  data-style="zoom-in">
    <span class="ladda-label"><i class="icon wb-trash" aria-hidden="true"></i></span>
</a>
@endcan
