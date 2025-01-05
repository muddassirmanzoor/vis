@extends('layouts.main')
@section('content')
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered  justify-content-center">
                <thead>
                <tr>
                    <th>CLASS</th>
                    <th>SUBJECT</th>
                    <th>QUANTITY RECIVED</th>
                    <th>QUANTITY OF USEBALE</th>
                    <th>QUANTITY OF SHAHEED</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                <?php
                $received = 0;
                $useable = 0;
                $unuseable = 0;
                ?>
                @foreach($visit_data as $class)
                        <?php
                        $received = $class->qty_received + $received;
                        $useable = $class->useable + $useable;
                        $unuseable = $class->unuseable + $unuseable;
                        ?>
                    <tr>
                        <td>Class {{$class->class}}</td>
                        <td>{{$class->subject}}</td>
                        <td>{{$class->qty_received}}</td>
                        <td>{{$class->useable}}</td>
                        <td>{{$class->unuseable}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2" style="text-align: center;font-weight: bold;">Total</td>
                    <td style="text-align: center;font-weight: bold;">{{$received}}</td>
                    <td style="text-align: center;font-weight: bold;">{{$useable}}</td>
                    <td style="text-align: center;font-weight: bold;">{{$unuseable}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
