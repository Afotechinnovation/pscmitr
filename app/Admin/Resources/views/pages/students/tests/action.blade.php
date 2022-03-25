<div class="text-center">
{{--    <a href="{{ route('admin.student.test-attempts', ['student_id' => $testResults->user_id, 'test_id' => $testResults->test_id]) }}" class="btn btn-sm btn-icon btn-pure btn-default ladda-button--}}
{{--        button-edit" data-toggle="tooltip" data-original-title="Edit" data-plugin="ladda" data-style="zoom-in">--}}
{{--        <span class="ladda-label"><i class="icon wb-eye" aria-hidden="true"></i></span>--}}
{{--    </a>--}}
    <a href="{{ url('admin/students/'.$testResults->user_id.'/tests/'.$testResults->test_id.'?package='.$testResults->package_id) }}" class="btn btn-sm btn-icon btn-pure btn-default ladda-button
        button-edit" data-toggle="tooltip" data-original-title="Edit" data-plugin="ladda" data-style="zoom-in">
        <span class="ladda-label"><i class="icon wb-eye" aria-hidden="true"></i></span>
    </a>

</div>
