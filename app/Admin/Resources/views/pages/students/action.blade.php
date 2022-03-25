<div class="text-center">
    <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-sm btn-icon btn-pure btn-default ladda-button
        button-edit" data-toggle="tooltip" data-original-title="Edit" data-plugin="ladda" data-style="zoom-in">
        <span class="ladda-label"><i class="icon wb-eye" aria-hidden="true"></i></span>
    </a>
    <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-sm btn-icon btn-pure btn-default ladda-button
        button-edit" data-toggle="tooltip" data-original-title="Edit" data-plugin="ladda" data-style="zoom-in">
        <span class="ladda-label"><i class="icon wb-edit" aria-hidden="true"></i></span>
    </a>

</div>
