@can('update', $subject)
    <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-sm btn-icon btn-pure btn-default ladda-button
    button-edit" data-toggle="tooltip" data-original-title="Edit" data-plugin="ladda" data-style="zoom-in">
        <span class="ladda-label"><i class="icon wb-edit" aria-hidden="true"></i></span>
    </a>
@endcan

@can('delete', $subject)
    @if ( !in_array( $subject->id, $testSubjectIDs) )
        <a href="{{ route('admin.subjects.destroy', $subject->id) }}"
           class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-delete" data-toggle="tooltip"
           data-original-title="Delete"  data-style="zoom-in">
            <span class="ladda-label"><i class="icon wb-trash" aria-hidden="true"></i></span>
        </a>
    @endif
@endcan
