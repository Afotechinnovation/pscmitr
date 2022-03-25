<?php

namespace App\Exports;

use App\Models\SegmentCourse;
use App\Models\SegmentTest;
use App\Models\User;
use App\Models\UserSegment;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
//use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class SegmentExport implements FromQuery, WithMapping, WithHeadings, WithEvents
{

    private $segmentId;
    public function __construct($segmentId = null)
    {
        $this->search = $segmentId;
    }

    /**
     * @return Builder
     */
    public function query()
    {
            $user_segment = UserSegment::findOrFail($this->search);

            $query = User::with('students','package_rating','test_rating','test_results','transactions');

            $condition = null;
            $condition1 = null;
            $condition2 = null;

            $gender = $user_segment->gender;
            $age_from = $user_segment->age_from;
            $age_to = $user_segment->age_to;
            $dob_from = Carbon::now()->subYear($age_from)->format('Y-m-d');
            $dob_to = Carbon::now()->subYear($age_to)->format('Y-m-d');
            $rating = $user_segment->rating;
            $mark_from = $user_segment->mark_from;
            $mark_to = $user_segment->mark_to;

            if( $user_segment->marks_less_than ) {
                $condition = '<=';
            }
            if ( $user_segment->marks_greater_than ) {
                $condition = '>=';
            }
            if ( $user_segment->marks_is_equal ) {
                $condition = '=';
            }
            if($user_segment->marks_in_between) {
                $condition1 = '>=';
                $condition2 = '<=';
            }

            $courses =  SegmentCourse::where('segment_id',  $this->search)
                ->pluck('course_id');
            $tests =  SegmentTest::where('segment_id', $this->search)
                ->pluck('test_id');

            $query->whereHas('students',function ( $student ) use( $gender, $dob_from, $dob_to ){
                    $student->whereDate('date_of_birth','>=', $dob_to)
                        ->whereDate('date_of_birth','<=', $dob_from)
                        ->orWhere('gender', $gender);

                })
                ->orWhereHas('package_rating',function ( $package_rating ) use( $rating ) {
                    $package_rating->where('rating', $rating);
                })
                ->orWhereHas('test_rating',function ( $test_rating) use( $rating ) {
                    $test_rating->where('rating', $rating);
                })
                ->orWhereHas('test_results',function ( $test_results ) use( $mark_from, $mark_to, $condition, $condition1, $condition2, $tests ) {
                    $test_results->where('mark_percentage', $condition1, $mark_from)
                        ->where('mark_percentage', $condition2, $mark_to)
                        ->orWhere('mark_percentage', $condition, $mark_from)
                        ->orWhereIn('test_id', $tests);

                })
                ->orWhereHas('transactions',function ( $transactions ) use( $courses ) {
                    $transactions->WhereIn('course_id', $courses);
                })
                ->orderBy('id','DESC')
                ->get();

            return $query;

    }

    /**
     * @param UserSegment $userSegment
     * @return array|void
     */
    public function map($query): array
    {
        return [
            [
                $query->name,
                $query->student->email,
                $query->student->mobile,
                $this->getGender($query),

            ],
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Mobile',
            'Email',
            'Gender'
        ];
    }

    public  function getGender($query)
    {
        if($query->student->gender == 0) {
            return 'Female';
        }
        return  'Male';
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);

            },
        ];
    }


}
