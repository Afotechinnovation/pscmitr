<div class="text-center">
    <a data-id="{{$package_study_material->document_id}}" href="{{ route('admin.documents.download', $package_study_material->document_id) }}" target="_blank" class="m-2">
      <i class="icon wb-download" ></i>
    </a>
    @can('delete', $package_study_material)
        <a href="{{ route('admin.packages.study-materials.destroy', ['package' => $package_study_material->package_id,'study_material' => $package_study_material->document_id]) }}"
           class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-delete" data-toggle="tooltip"
           data-original-title="Delete"  data-style="zoom-in">
            <span class="ladda-label"><i class="icon wb-trash" aria-hidden="true"></i></span>
        </a>
    @endcan
</div>
