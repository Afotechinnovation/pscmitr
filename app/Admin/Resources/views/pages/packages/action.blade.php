<div class="text-center">
    @if(!$package->is_published)
    <a href="{{ route('admin.packages.publish', $package->id) }}" class="btn btn-sm btn-icon btn-pure btn-default ladda-button
        button-publish" data-publish="1" data-test-count="{{ $packageTestCount }}" data-video-count="{{ $packageVideoCount }}" data-document-count="{{ $packageDocumentCount }}" data-toggle="tooltip" data-original-title="Publish" data-plugin="ladda" data-style="zoom-in">
        <span class="ladda-label"><i class="icon  wb-check-circle" aria-hidden="true"></i></span>
    </a>
    @else
        <a href="{{ route('admin.packages.publish', $package->id) }}" class="btn btn-sm btn-icon btn-pure btn-default ladda-button
        button-publish"  data-publish="0" data-toggle="tooltip" data-original-title="Edit" data-plugin="ladda" data-style="zoom-in">
            <span class="ladda-label"><i class="icon wb-reply" aria-hidden="true"></i></span>
        </a>
    @endif
    <a href="{{ route('admin.packages.show', $package->id) }}" class="btn btn-sm btn-icon btn-pure btn-default ladda-button
        button-edit" data-toggle="tooltip" data-original-title="Edit" data-plugin="ladda" data-style="zoom-in">
        <span class="ladda-label"><i class="icon wb-eye" aria-hidden="true"></i></span>
    </a>
    <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-sm btn-icon btn-pure btn-default ladda-button
        button-edit" data-toggle="tooltip" data-original-title="Edit" data-plugin="ladda" data-style="zoom-in">
        <span class="ladda-label"><i class="icon wb-edit" aria-hidden="true"></i></span>
    </a>
    <a href="{{ route('admin.packages.destroy', $package->id) }}"
       class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-delete" data-toggle="tooltip"
       data-original-title="Delete"  data-style="zoom-in">
        <span class="ladda-label"><i class="icon wb-trash" aria-hidden="true"></i></span>
    </a>
</div>
