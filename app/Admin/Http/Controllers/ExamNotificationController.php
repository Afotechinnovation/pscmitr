<?php

namespace App\Admin\Http\Controllers;


use App\Models\ExamNotification;
use App\Models\RelatedExamNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ExamNotificationController extends Controller
{

    public function index(Builder $builder)
    {
        $this->authorize('viewAny', ExamNotification::class);

        if (request()->ajax()) {
            $query = ExamNotification::With('exam_category');

            return DataTables::of($query)
                ->filter(function ($query) {
                    if (request()->filled('filter.search')) {
                        $query->where(function ($query) {
                            $query->where('title', 'like', '%'. request('filter.search') . '%')
                                ->orWhere('exam_number', 'like', '%'. request('filter.search') . '%')
                                ->orWhere('url', 'like', '%'. request('filter.search') . '%')
                                ->orWhereHas('exam_category', function( $exam_category )  {
                                $exam_category->where('name', 'like', '%'. request('filter.search') . '%');
                            });

                        });
                    }
                    if (request()->filled('filter.date')) {
                        $query->where(function ($query) {
                            $query->whereDate('last_date', Carbon::parse(request('filter.date')));
                        });
                    }

                })
                ->editColumn('last_date', function ($examNotification) {

                    return Carbon::parse($examNotification->last_date)->format('d M Y');
                })
                ->editColumn('is_published', function ($examNotification) {
                    if(!$examNotification->is_published){
                        return '<span class="badge badge-warning">Unpublished</span>';
                    }

                    return '<span class="badge badge-info">Published</span>';
                })
                ->addColumn('action', function ($examNotification){
                    return view('admin::pages.exam_notifications.action', compact('examNotification'));
                })
                ->rawColumns(['action','last_date','is_published'])
                ->make(true);
        }

        $table = $builder->columns([
            ['data' => 'title', 'name' => 'title', 'title' => 'Title'],
            ['data' => 'exam_category.name', 'name' => 'exam_category.name', 'title' => 'Exam Category'],
            ['data' => 'last_date', 'name' => 'last_date', 'title' => 'Last Date'],
            ['data' => 'exam_number', 'name' => 'exam_number', 'title' => 'Exam Number'],
            ['data' => 'is_published', 'name' => 'is_published', 'title' => 'Is Published'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3']
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        return view('admin::pages.exam_notifications.index', compact('table'));
    }

    public function create()
    {
        $this->authorize('create', ExamNotification::class);

        $related_exam_notifications = ExamNotification::all();

        return view('admin::pages.exam_notifications.create', compact('related_exam_notifications'));
    }

    public function store(Request $request,ExamNotification $exam_notification)
    {
        $this->authorize('create', ExamNotification::class);

        $request->validate([
            'title' => 'required','max:50',
            'exam_category_id' => 'required',
            'exam_number' => 'required',
            'body' => 'required',
            'last_date' => 'required',
            'file' => 'required|mimes:doc,pdf,xls,docx,xlsx',
            'url' => 'url',

        ]);

        DB::beginTransaction();

        $exam_notification->title = $request->input('title');
        $exam_notification->name_slug  = Str::of($request->title)->slug('-');
        $exam_notification->exam_category_id = $request->input('exam_category_id');
        $exam_notification->exam_number = $request->input('exam_number');
        $exam_notification->body = $request->input('body');
        $exam_notification->last_date = $request->input('last_date');
        $exam_notification->url = $request->input('url');


        if ($request->hasFile('file')) {
            $document = $request->file('file');
            $file_extension =  $document->getClientOriginalExtension();
            $filename = time() . '.' . $file_extension;
            $filePath = $request->file('file')->storeAs('exam_document', $filename, 'public');
            $exam_notification->file  = $filename;
        }
        $exam_notification->save();

        if($request->related_exam_notifications){

            foreach($request->related_exam_notifications as $related_exam_notification){
                $exam_notification->relatedExamNotifications()->attach($exam_notification->id,
                    ['exam_notification_id' => $exam_notification->id, 'related_exam_notification_id' => $related_exam_notification]);
            }
        }

        DB::commit();

        return redirect()->route('admin.exam-notifications.index')->with('success', 'Exam Notification successfully created');
    }

    public function edit($id)
    {
        $exam_notification = ExamNotification::findOrFail($id);

        $this->authorize('update', $exam_notification);

        $related_exam_notifications = RelatedExamNotification::with('exam_notification')
            ->whereHas('exam_notification')
            ->where('exam_notification_id' , $id)
            ->get();

        $notifications = ExamNotification::where('id','!=',$id)->get();

        return view('admin::pages.exam_notifications.edit', compact('exam_notification','notifications','related_exam_notifications'));
    }

    public function update(Request $request, $id)
    {
        $exam_notification = ExamNotification::findOrFail($id);

        $this->authorize('update', $exam_notification);

        $request->validate([
            'title' => 'required','max:50',
            'exam_category_id' => 'required',
            'exam_number' => 'required',
            'body' => 'required',
            'last_date' => 'required',
            'file' => 'mimes:doc,pdf,xls,docx,xlsx',
            'url' => 'url',

        ]);

        DB::beginTransaction();

        $exam_notification->title = $request->input('title');
        $exam_notification->name_slug  = Str::of($request->title)->slug('-');
        $exam_notification->exam_category_id = $request->input('exam_category_id');
        $exam_notification->exam_number = $request->input('exam_number');
        $exam_notification->body = $request->input('body');
        $exam_notification->last_date = $request->input('last_date');
        $exam_notification->url = $request->input('url');

        if ($request->hasFile('file')) {
            $document = $request->file('file');
            $file_extension =  $document->getClientOriginalExtension();
            $filename = time() . '.' . $file_extension;
            $filePath = $request->file('file')->storeAs('exam_document', $filename, 'public');
            $exam_notification->file  = $filename;
        }

        $exam_notification->save();

        $related_exam_notifications = $request->related_exam_notifications;

        $exam_notification->relatedExamNotifications()->sync($related_exam_notifications);

        DB::commit();

        return redirect()->route('admin.exam-notifications.index')->with('success', 'Exam Notification successfully updated');
    }

    public function destroy($id)
    {
        $exam_notification = ExamNotification::findOrFail($id);

        $this->authorize('delete', $exam_notification);

        $exam_notification->delete();

        return response()->json(true, 200);
    }
    public function publish(Request $request, $examNotificationId)
    {
        $examNotification = ExamNotification::findOrFail($examNotificationId);

        $this->authorize('update', $examNotification);

        $examNotification->is_published = $request->publish;
        $examNotification->save();

        return response()->json($examNotification, 200);
    }
}
