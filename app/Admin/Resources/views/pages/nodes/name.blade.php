<span>
    @if ($type == \App\Models\Node::TYPE_FOLDER)
    <i class="wb-folder"></i>
    <a href="" class="node" style="text-decoration: none;"
       data-id="{{ $id }}" data-parent-id="{{ $parent_id }}" data-node-type="{{ $type }}">{{ $name }}
    </a>
    @endif
    @if($model ==1)
        @if ($type == \App\Models\Node::TYPE_FILE)
            <i class="wb-file"></i>
            <a href="{{route('admin.videos.show', $id)}}" class="videoFile" style="text-decoration: none;"
               data-id="{{ $id }}" data-parent-id="{{ $parent_id }}" data-node-type="{{ $type }}">{{ $name }}
            </a>
        @endif
    @else
        @if ($type == \App\Models\Node::TYPE_FILE)
            <i class="wb-file"></i>
            <a href="{{ route('admin.documents.download', $id) }}" target="_blank" style="text-decoration: none;" >{{ $name }}
            </a>
        @endif
    @endif
</span>
