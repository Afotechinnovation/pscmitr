@if ( !in_array( $test_questions->id, $testQuestionIDs) )
<a href="{{ route('admin.test_questions.destroy', $test_questions->id) }}"
   class="btn btn-sm btn-icon btn-pure btn-default ladda-button button-delete" data-toggle="tooltip"
   data-original-title="Delete"  data-style="zoom-in">
    <span class="ladda-label"><i class="icon wb-trash" aria-hidden="true"></i></span>
</a>
@endif



