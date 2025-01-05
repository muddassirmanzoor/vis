@extends('layouts.sica.main')
@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <!-- Include DataTables Buttons extension -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.dataTables.min.css">
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js">
    </script>
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Data Pending</h4>
        <!-- Bordered Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="example" class="table table-bordered table-striped school-info-data-table">
                        <thead>
                            <tr>
                                <th>Sr.no</th>
                                <th>District</th>
                                <th>Tehsil</th>
                                <th>EMIS<br>Code</th>
                                <th>Name</th>
                                <th>School<br>Gate</th>
                                <th>Academic<br>Block</th>
                                <th>Drinking<br>Water</th>
                                <th>Toilet<br>Block</th>
                                <th>Play<br>Ground</th>
                                <th>Libraray</th>
                                <th>Computer<br>Lab</th>
                                <th>Science<br>Lab</th>
                                {{-- <th>Lat</th>
                                <th>Long</th> --}}
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($schoolsPaginated->isEmpty())
                                <tr>
                                    <td colspan="16">No data found</td>
                                </tr>
                            @else
                                @foreach ($schoolsPaginated as $emisCode => $metadata)
                                    <tr>

                                        <td>{{ ($schoolsPaginated->currentPage() - 1) * $schoolsPaginated->perPage() + $loop->iteration }}
                                        </td>
                                        <td>{{ $metadata->d_name }}</td> <!-- District Name -->
                                        <td>{{ $metadata->t_name }}</td> <!-- Tehsil Name -->
                                        <td>
                                                <a
                                                    href="{{ url('sica/school-images/' . encrypt($metadata->s_emis_code)) }}">{{ $metadata->s_emis_code }}
                                                </a>
                                        </td> <!-- EMIS Code -->
                                        <td style="text-align: left;">{{ $metadata->s_name }}</td>
                                        <td>
                                           
                                                @foreach ($metadata->items as $item)
                                                    @if ($item['category_type'] == 'gate_picture')
                                                        @php
                                                            $status =
                                                                $item['verify'] == 0
                                                                    ? 'pending'
                                                                    : ($item['verify'] == 1
                                                                        ? 'Verified'
                                                                        : ($item['verify'] == 2
                                                                            ? 'Send back to school'
                                                                            : 'n/a'));
                                                        @endphp
                                                        {{ $status }}
                                                    @break
                                                @endif
                                            @endforeach
                                    </td>
                                    <td>
                                            @foreach ($metadata->items as $item)
                                                @if ($item['category_type'] == 'academic_block')
                                                    @php
                                                        $status =
                                                            $item['verify'] == 0
                                                                ? 'pending'
                                                                : ($item['verify'] == 1
                                                                    ? 'Verified'
                                                                    : ($item['verify'] == 2
                                                                        ? 'Send back to school'
                                                                        : 'n/a'));
                                                    @endphp
                                                    {{ $status }}
                                                @break
                                            @endif
                                        @endforeach
                                </td>

                                <td>
                                        @foreach ($metadata->items as $item)
                                            @if ($item['category_type'] == 'drinking_water')
                                                @php
                                                    $status =
                                                        $item['verify'] == 0
                                                            ? 'pending'
                                                            : ($item['verify'] == 1
                                                                ? 'Verified'
                                                                : ($item['verify'] == 2
                                                                    ? 'Send back to school'
                                                                    : 'n/a'));
                                                @endphp
                                                {{ $status }}
                                            @break
                                        @endif
                                    @endforeach
                            </td>
                            <td>
                                    @foreach ($metadata->items as $item)
                                        @if ($item['category_type'] == 'toilet_block')
                                            @php
                                                $status =
                                                    $item['verify'] == 0
                                                        ? 'pending'
                                                        : ($item['verify'] == 1
                                                            ? 'Verified'
                                                            : ($item['verify'] == 2
                                                                ? 'Send back to school'
                                                                : 'n/a'));
                                            @endphp
                                            {{ $status }}
                                        @break
                                    @endif
                                @endforeach
                        </td>
                        <td>
                                @foreach ($metadata->items as $item)
                                    @if ($item['category_type'] == 'play_ground')
                                        @php
                                            $status =
                                                $item['verify'] == 0
                                                    ? 'pending'
                                                    : ($item['verify'] == 1
                                                        ? 'Verified'
                                                        : ($item['verify'] == 2
                                                            ? 'Send back to school'
                                                            : 'n/a'));
                                        @endphp
                                        {{ $status }}
                                    @break
                                @endif
                            @endforeach
                    </td>

                    <td>
                            @foreach ($metadata->items as $item)
                                @if ($item['category_type'] == 'library')
                                    @php
                                        $status =
                                            $item['verify'] == 0
                                                ? 'pending'
                                                : ($item['verify'] == 1
                                                    ? 'Verified'
                                                    : ($item['verify'] == 2
                                                        ? 'Send back to school'
                                                        : 'n/a'));
                                    @endphp
                                    {{ $status }}
                                @break
                            @endif
                        @endforeach
                </td>

                <td>
                        @foreach ($metadata->items as $item)
                            @if ($item['category_type'] == 'computer_lab')
                                @php
                                    $status =
                                        $item['verify'] == 0
                                            ? 'pending'
                                            : ($item['verify'] == 1
                                                ? 'Verified'
                                                : ($item['verify'] == 2
                                                    ? 'Send back to school'
                                                    : 'n/a'));
                                @endphp
                                {{ $status }}
                            @break
                        @endif
                    @endforeach
            </td>
            <td>
                    @foreach ($metadata->items as $item)
                        @if ($item['category_type'] == 'science_lab/physics')
                            @php
                                $status =
                                    $item['verify'] == 0
                                        ? 'pending'
                                        : ($item['verify'] == 1
                                            ? 'Verified'
                                            : ($item['verify'] == 2
                                                ? 'Send back to school'
                                                : 'n/a'));
                            @endphp
                            {{ $status }}
                        @break
                    @endif
                @endforeach
        </td>
        {{-- <td>{{ $metadata->s_lat }}</td> <!-- Latitude -->
        <td>{{ $metadata->s_lng }}</td> <!-- Longitude --> --}}
        <td>
                @foreach ($metadata->items as $item)
                    @if ($item['verify'] == 1)
                        <span class="badge bg-label-success me-1">Verified</span>
                    @elseif ($item['verify'] == 0)
                        <span class="badge bg-label-warning me-1">Pending</span>
                    @else
                        <span class="badge bg-label-warning me-1">NaN</span>
                    @endif
                @break
            @endforeach
    </td>
    {{-- @endif --}}
</tr>
@endforeach
@endif
</tbody>
</table>
</div>
@php
    // // Total count of all schools
    // $total_schools = $schools->total();

    // // Calculate the count of data not submitted
    // $count_not_submitted = $total_schools - $schools->where('metadata_status', 'no')->count();
@endphp

<div class="school-in-data-table-pagenation">
{{-- @if ($count_not_submitted > 0) --}}
{{-- <p>Total {{ $count_not_submitted }} schools not submitted</p> --}}
{{ $schoolsPaginated->links() }}
{{-- @else --}}
{{-- <p>All schools have been submitted</p>
@endif --}}
</div>
</div>

</div>
</div>
<!--/ Bordered Table -->
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#example').DataTable({
            dom: '<"d-flex justify-content-between align-items-center mb-3"B>', // Only add buttons to the DOM
            buttons: [], // Empty array to remove all buttons
            paging: false, // Disable pagination
            lengthChange: false, // Disable "Entries" dropdown
            info: false // Disable display of "Showing x to y of z entries"
        });
    });
</script>
@endsection
