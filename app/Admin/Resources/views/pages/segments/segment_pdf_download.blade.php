
<!DOCTYPE html>
<html>

<body>
<style type="text/css">
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td {
        padding: 5px;
        text-align: left;
    }
    .table-center {
        align-items: center;
    }
</style>
<div class="container">
    <table class="responsive table-center">
        <thead>
        <tr>
            <th>S.No.</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Gender</th>
        </tr>
        </thead>
        @foreach($segments as $segment)
            <tr>
                <td>{{$loop->iteration }} </td>
                <td>{{$segment->name ?? $test_result->mobile }}</td>
                <td>{{$segment->mobile}}</td>
                <td>{{$segment->student->email}}</td>
                <td>
                    @if($segment->student->gender == 0) Female  @else Male @endif
                </td>

            </tr>
        @endforeach
    </table>
</div>
</body>
</html>


