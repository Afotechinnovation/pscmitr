<?php

namespace App\Exports;

use App\Models\Option;
use App\Models\Question;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Drawing;

class QuestionExport implements WithEvents,FromQuery, WithMapping, WithHeadings,WithColumnWidths
{
    private $searchType;
    private $search;
    public function __construct($searchType = null, $search = null,  $course = null, $subject = null, $chapter = null, $created_by = null, $date = null )
    {
        $this->searchType = $searchType;
        $this->search = $search;
        $this->course = $course;
        $this->subject = $subject;
        $this->chapter = $chapter;
        $this->created_by = $created_by;
        $this->date = $date;

    }

    /**
     * @return Builder
     */
    public function query()
    {
        $query = Question::with('course','subject','chapter','admin_created_by','options')
            ->orderBy('id','DESC');

        $searchType = $this->searchType;
        $search = $this->search;
        $course = $this->course;
        $subject = $this->subject;
        $chapter = $this->chapter;
        $created_by = $this->created_by;
        $date = $this->date;

        if ($searchType == "null" && $search == "null" && $course == "null" &&$subject == "null" && $chapter == "null" && $created_by == "null" && $date == "null") {

            return $query;
        }
        if($searchType !== "null") {
            $query->where('type', '=',  $searchType );
        }
        if($search !== "null") {
            $query->where('question', 'like', '%'. $search . '%');
        }
        if( $course !== "null") {
            $query->where('course_id', 'like', '%'. $course . '%');
        }
        if( $subject !== "null") {
            $query->where('subject_id', 'like', '%'. $subject . '%');
        }
        if($chapter !== "null") {
            $query->where('chapter_id', 'like', '%'. $chapter . '%');
        }
        if($created_by !== "null") {
            $query->where('created_by', 'like', '%'. $created_by . '%');
        }
        if($date !== "null") {
            $query->whereDate('created_at', '=', Carbon::parse($date));
        }

        return $query;

    }


    /**
     * @param TestResult $testResult
     * @return array|void
     */
    public function map($query): array
    {
        return [
            [
                strip_tags(html_entity_decode($query->question)),
                $query->course->name,
                $query->subject->name,
                $query->chapter->name,
                $this->getType($query),
                strip_tags(html_entity_decode($this->getOptions($query))),
                strip_tags(html_entity_decode( $this->getCorrectOption($query))),

            ],
        ];
    }

    public function headings(): array
    {
        return [

            'Question',
            'Course',
            'Subject',
            'Chapter',
            'Type',
            'Options',
            'Correct Option',
           // 'Question Images',
            //'Option Images'
        ];
    }

    public function getType($query)
    {
        if($query->type == 1) {
            return 'Objective';
        }else {
            return 'True or False';
        }

    }

    public function getOptions($query)
    {
        $questionId = $query->id;

        if($query->type == 1) {
            $options = Option::with('question')
                ->whereHas('question', function ( $option ) use ( $questionId ) {
                    $option->where('question_id', $questionId);
                })
                ->orderBy('id', 'DESC')
                ->pluck('option');


            $questionOptions = [];

            foreach ($options as $key => $questionOption) {
                $optionCount = $key+ 1;
                $questionOptions[] = "Option". $optionCount .": " . $questionOption;
            }

            return implode(",\n",$questionOptions);

        }else{

            return " True Or False";
        }

    }
    public function getCorrectOption($query)
    {
        $questionId = $query->id;

        if($query->type == 1) {

            $options = Option::with('question')
                ->whereHas('question', function ( $option ) use ( $questionId ) {
                        $option->where('question_id', $questionId)
                            ->where('is_correct', true);
                })
                ->pluck('option');

            $CorrectOptions = [];
           foreach ($options as $Key => $correctOption )  {

               $CorrectOptions[] =  $correctOption;
           }
            return implode(",\n",$CorrectOptions);


        }else{
            $option  = Option::with('question')
                ->whereHas('question', function ($option) use ($questionId) {
                    $option->where('question_id', $questionId);
                })
                ->pluck('is_correct')->toArray();

            if ($option[0] == 1) {
                return 'True';
            } else {
                return 'False';
            }
        }
    }
    public function columnWidths(): array
    {
        return [
            'A' => 55,
            'B' => 45,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getColumnDimension('E')->setAutoSize(true);
                $event->sheet->getColumnDimension('F')->setAutoSize(true);
                $event->sheet->getColumnDimension('G')->setAutoSize(true);
//                $event->sheet->getColumnDimension('H')->setAutoSize(true);
//                $event->sheet->getColumnDimension('L')->setAutoSize(true);

//                $event->sheet->freezePane('H1', 'H1');
//
//                $query = Question::with('course', 'subject', 'chapter', 'admin_created_by', 'options')
//                    ->orderBy('id','DESC');
//
//                $searchType = $this->searchType;
//                $search = $this->search;
//                $course = $this->course;
//                $subject = $this->subject;
//                $chapter = $this->chapter;
//                $created_by = $this->created_by;
//                $date = $this->date;
//
//
//                if ($searchType == "null" && $search == "null" && $course == "null" && $subject == "null" && $chapter == "null" && $created_by == "null" && $date == "null") {
//                    return $query;
//
//                }
//
//                if($searchType !== "null") {
//                    $query->where('type', '=',  $searchType );
//                }
//                if($search !== "null") {
//                    $query->where('question', 'like', '%'. $search . '%');
//                }
//                if( $course !== "null") {
//                    $query->where('course_id', 'like', '%'. $course . '%');
//                }
//                if( $subject !== "null") {
//                    $query->where('subject_id', 'like', '%'. $subject . '%');
//                }
//                if($chapter !== "null") {
//                    $query->where('chapter_id', 'like', '%'. $chapter . '%');
//                }
//                if($created_by !== "null") {
//                    $query->where('created_by', 'like', '%'. $created_by . '%');
//                }
//                if($date !== "null") {
//                    $query->whereDate('created_at', '=', Carbon::parse($date));
//                }
//
//                $questions = $query->get();
//                // question image
//                //Set row height
//                for ($i = 0; $i < count($questions); $i++) //iterate based on row count
//                {
//                    $event->sheet->getRowDimension(+$i)->setRowHeight(60);
//                }
//
//                foreach ($questions as $Key => $question) {
//
//                    if ($question->image !== NULL) {
//                        $column = $Key+2;
//                        $drawing = new  \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
//                        $drawing->setName('image');
//                        $drawing->setDescription('image');
//                        $drawing->setPath('storage/questions/image/' . $question->image);
//                        $drawing->setHeight(70);
//                        $drawing->setOffsetX(5);
//                        $drawing->setOffsetY(5);
//                        $drawing->setCoordinates('H'. $column );
//                        $drawing->setWorksheet($event->sheet->getDelegate());
//
//                    }
//                }
//                // Option Image
//                foreach ($questions as $Key => $question) {
//                    $questionId = $question->id;
//
//                    $options = Option::with('question')
//                        ->whereHas('question', function ( $option ) use ( $questionId ) {
//                            $option->where('question_id', $questionId);
//                        })
//                       ->get();
//
//                    foreach ($options as $option) {
//
//                        if ($option->image !== NULL ) {
//
//                            $column = $Key+2;
//                            $drawing = new  \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
//                            $drawing->setName('image');
//                            $drawing->setDescription('image');
//                            $drawing->setPath('storage/questions/options/image/'.$option->image);
//                            $drawing->setHeight(50);
//                            $drawing->setOffsetX(5);
//                            $drawing->setOffsetY(5);
//                            $drawing->setCoordinates('L'. $column );
//                            $drawing->setWorksheet($event->sheet->getDelegate());
//
//                        }
//                    }
//
//                }

            },
        ];
    }
//    public function columnWidths(): array
//    {
//        return [
//            'H' => 55,
//
//        ];
//    }
//    public function getImages( $query ) {
//
//        return $query->image;
//
//    }
//    public function drawings()
//    {
//
//        $query = Question::with('course','subject','chapter','admin_created_by','options')
//            ->get();
//
//        $searchType = $this->searchType;
//        $search = $this->search;
//        $course = $this->course;
//        $subject = $this->subject;
//        $chapter = $this->chapter;
//        $created_by = $this->created_by;
//        $date = $this->date;
//
////        if ($searchType == "null" && $search == "null" && $course == "null" &&$subject == "null" && $chapter == "null" && $created_by == "null" && $date == "null") {
////
////            return $query;
////        }
////        if($searchType !== "null") {
////            $query->where('type', '=',  $searchType );
////        }
////        if($search !== "null") {
////            $query->where('question', 'like', '%'. $search . '%');
////        }
////        if( $course !== "null") {
////            $query->where('course_id', 'like', '%'. $course . '%');
////        }
////        if( $subject !== "null") {
////            $query->where('subject_id', 'like', '%'. $subject . '%');
////        }
////        if($chapter !== "null") {
////            $query->where('chapter_id', 'like', '%'. $chapter . '%');
////        }
////        if($created_by !== "null") {
////            $query->where('created_by', 'like', '%'. $created_by . '%');
////        }
////        if($date !== "null") {
////            $query->whereDate('created_at', '=', Carbon::parse($date));
////        }
//
//        foreach ($query as $questionImage) {
//
//            if($questionImage->image !== NULL) {
//                info($questionImage->image);
//                $drawing =  new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
//                $drawing->setName('Question Image');
//                $drawing->setDescription('Question Image');
//                $drawing->setPath(('storage/questions/image/'.$questionImage->image));
//                $drawing->setHeight(90);
//
//                return $drawing;
//            }
//
//        }
//
////        $drawing->setCoordinates('B3');
//
//
//    }


}
