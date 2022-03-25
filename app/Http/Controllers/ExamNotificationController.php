<?php

namespace App\Http\Controllers;

use App\Models\ExamCategory;
use App\Models\ExamNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExamNotificationController extends Controller
{
    public function index(Request $request) {

        $exam_categories = ExamCategory::with('exam_notifications')
            ->whereHas('exam_notifications', function ($exam_notification){
                $exam_notification->where('last_date', '>=', Carbon::today());
            })
            ->whereHas('exam_notifications', function ($exam_notification){
                $exam_notification->where('is_published', true);
            })
            ->orderBy('order','asc')
            ->get();

      //  return $exam_categories;

        $first_category = $exam_categories->first();

        $category = $request->input('category') ? $request->input('category') : $first_category->id;

        $exam_notifications = ExamNotification::getFilteredNotifications(
            $category,
            $request->input( 'page'),
            $request->input('limit'),
        );

        return view('pages.exam_notifications.index', compact('exam_categories','exam_notifications','category'));
    }
    public function show($id)
    {

        $exam_notification = ExamNotification::with('relatedNotification.exam_notification')
            ->whereHas('relatedNotification.exam_notification')
            ->where('name_slug', $id)
            ->first();

        if(!$exam_notification) {
            $exam_notification = ExamNotification::where('name_slug', $id)->first();
        }

        return view('pages.exam_notifications.show', compact('exam_notification'));
    }
}
