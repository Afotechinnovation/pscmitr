<?php

namespace App\Exports;

use App\Models\TestResult;
use App\Models\TestSection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
//use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TestResultExport implements FromQuery, WithMapping, WithHeadings, WithEvents
{
    private $searchDate;
    private $search;
    public function __construct($searchDate = null, $search = null)
    {
        $this->searchDate = $searchDate;
        $this->search = $search;
    }

    /**
     * @return Builder
     */
    public function query()
    {

        $query = TestResult::whereNotNull('ended_at')
            ->with('test.package','package','user','test')->orderBy('id','DESC');

        if ($this->searchDate == "null" && $this->search !== "null") {
//            info("search");


                $query->where('total_marks', 'like', '%'. $this->search . '%')
//                $query->orWhereHas('user', function( $user )  {
//                    $user->where('mobile', 'like', '%'. $this->search . '%')
//                        ->orWhere('name', 'like', '%'. $this->search . '%')
//                        ->orWhere('email', 'like', '%'. $this->search . '%');
//                });
//                $query->orWhereHas('test', function( $test )  {
//                    $test->where('name', 'like', '%'. $this->search . '%');
//
//                  });
//                $query->orWhereHas('package', function( $test )  {
//                    $test->where('name', 'like', '%'. $this->search . '%');
//
//                })
                    ->get();

//            info($query->get());

            return $query;


        }else if($this->searchDate !== "null" && $this->search == "null") {
//            info("withdate");

            $dates = explode(' - ', $this->searchDate);

            $start_date = Carbon::parse(date('Y-m-d', strtotime($dates[0])) . ' 00:00:00');
            $end_date = Carbon::parse(date('Y-m-d', strtotime($dates[1])) . ' 00:00:00');

            $query->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();

            return $query;
        }else if($this->searchDate !== "null" && $this->search !== "null") {
//            info("dateand search");

            $searchDate = '%' . $this->searchDate . '%';
            $search = '%' . $this->search . '%';

            $dates = explode(' - ', $this->searchDate);

            $start_date = Carbon::parse(date('Y-m-d', strtotime($dates[0])) . ' 00:00:00');
            $end_date = Carbon::parse(date('Y-m-d', strtotime($dates[1])) . ' 00:00:00');

            $query->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->where('total_marks', 'like', '%'. $this->search . '%')
//            $query->orWhereHas('user', function( $user )  {
//                $user->where('mobile', 'like', '%'. $this->search . '%')
//                    ->orWhere('name', 'like', '%'. $this->search . '%')
//                    ->orWhere('email', 'like', '%'. $this->search . '%');
//            });
//            $query->orWhereHas('test', function( $user )  {
//                $user->where('name', 'like', '%'. $this->search . '%');
//
//            });
//            $query->orWhereHas('package', function( $user )  {
//                $user->where('name', 'like', '%'. $this->search . '%');
//
//            })
                ->get();

            return $query;
        }else{
            return $query;
        }

    }

    /**
     * @param TestResult $testResult
     * @return array|void
     */
    public function map($query): array
    {
        return [
            [
                Carbon::parse($query->created_at)->format('d M Y'),
                Carbon::parse($query->ended_at)->format('H:i:s'),
                $query->test->name,
                $this->getPackage($query),
                $query->user->student->name,
                $query->user->student->email,
                $query->user->student->mobile,
                $query->total_duration,
                $query->total_correct_answers,
                $query->total_wrong_answers,
                $this->getUnattempted($query),
                $query->total_marks,

            ],
        ];
    }

    public function headings(): array
    {
        return [

            'Date',
            'Exam Completed On',
            'Test',
            'Package',
            'Name',
            'Email',
            'Mobile',
            'Total Time Taken(M)',
            'Correct',
            'Wrong',
            'Unattempted',
            'Total Marks',

        ];
    }
    public function getUnattempted($query)
    {
        $correct = $query->total_correct_answers;
        $wrong = $query->total_wrong_answers;
        $totalQuestions = $query->test->total_questions;
        $total_attempted  = $correct + $wrong;
        return $totalQuestions - $total_attempted;
    }

    public  function getPackage($query)
    {
        if(!$query->package) {
            return '';
        }
      return  $query->package->name;
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getColumnDimension('G')->setAutoSize(true);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getColumnDimension('E')->setAutoSize(true);
                $event->sheet->getColumnDimension('F')->setAutoSize(true);
                $event->sheet->getColumnDimension('J')->setAutoSize(true);
                $event->sheet->getColumnDimension('K')->setAutoSize(true);
                $event->sheet->getColumnDimension('L')->setAutoSize(true);
                $event->sheet->getColumnDimension('H')->setAutoSize(true);
            },
        ];
    }


}
