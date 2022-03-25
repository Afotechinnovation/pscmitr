<?php

namespace App\Admin\Http\Controllers;

use App\Models\Document;
use App\Models\Node;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $this->authorize('viewAny', Document::class);

        if (request()->ajax()) {
            $query = Node::query()->where('model', 2);

            return DataTables::of($query)
                ->filter(function ($query) {
                    if (request()->filled('filter.parent_id')) {
                        $query->where('parent_id', request()->input('filter.parent_id'));
                    }

                    if (request()->filled('filter.search')) {
                        $query->where('name', 'like', '%' . request()->input('filter.search') . '%');
                    }
                })
                ->addColumn('name', 'admin::pages.nodes.name')
                ->addColumn('type', function ($node) {
                    if ($node->type == Node::TYPE_FOLDER) {
                        return 'Folder';
                    }
                    return 'File';
                })
                ->addColumn('created_at', function ($node) {
                    return $node->created_at->toFormattedDateString();
                })
                ->addColumn('action', 'admin::pages.nodes.action')
                ->rawColumns(['name', 'action', 'name'])
                ->make(true);
        }

        $table = $builder->columns([
            ['name' => 'name', 'data' => 'name', 'title' => 'Name', 'width' => '50%'],
            ['name' => 'type', 'data' => 'type', 'title' => 'Type',  'width' => '20%'],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created At', 'width' => '20%'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'width' => '10%']
        ])->parameters([
            'searching' => false,
            'lengthChange' => false,
            'ordering' => false
        ]);

        return view('admin::pages.documents.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Document::class);

        $files = $request->file('files');

        if(! $request->hasFile('files'))
        {
            return redirect()->back();
        }

        foreach ($files as $file) {

            $filename = $file->getClientOriginalName();
            $parent_id = $request->input('parent_id');
            $pathName = str_replace(' ', '-', $filename);

            $fileFolder = new Document();
            $fileFolder->name = $filename;
            $fileFolder->folder_id = $parent_id;
            $fileFolder->save();

            $path = $fileFolder->id.'-'.$pathName;

            $folderFile = Document::findOrFail($fileFolder->id);
            $folderFile->path = $path;
            $folderFile->update();

            $node = new Node();
            $node->name = $path;
            $node->type = Node::TYPE_FILE;
            $node->parent_id = $parent_id ?? 0;
            $node->model = 2;
            $node->model_id = $folderFile->id;
            $node->save();

            $file->storeAs('documents', $path, ['disk' => 'public']);

        }

        return redirect()->route('admin.documents.index')->with('success', 'New File Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }

    public function downloadFile($id)
    {
        $node = Node::findOrFail($id);

        $file = Document::where('id', $node->model_id)->first();

        $this->authorize('downloadFile', $file);

        return response()->download($file->absolute_path);
    }

}
