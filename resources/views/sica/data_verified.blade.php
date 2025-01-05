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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Data Verified</h4>
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
                                        <td>
                                            {{ ($schoolsPaginated->currentPage() - 1) * $schoolsPaginated->perPage() + $loop->iteration }}
                                        </td>
                                        <td>{{ $metadata->d_name }}</td> <!-- District Name -->
                                        <td>{{ $metadata->t_name }}</td> <!-- Tehsil Name -->
                                        <td>
                                            <a href="{{ url('sica/school-images/' . encrypt($metadata->s_emis_code)) }}">{{ $metadata->s_emis_code }}
                                            </a>
                                        </td> <!-- EMIS Code -->
                                        <td style="text-align: left;">{{ $metadata->s_name }}</td>
                                        @php
                                            $gatePictureItem = null;
                                            $academicBlockItem = null;
                                            $drinkingWaterItem = null;
                                            $toiletBlockItem = null;
                                            $playGroundItem = null;
                                            $libraryItem = null;
                                            $computerLabItem = null;
                                            $physicsLabItem = null;
                                        @endphp

                                        @if (isset($metadata->items) && is_array($metadata->items))
                                            @foreach ($metadata->items as $item)
                                                @if ($item['category_type'] == 'gate_picture')
                                                    @php $gatePictureItem = $item; @endphp
                                                @elseif ($item['category_type'] == 'academic_block')
                                                    @php $academicBlockItem = $item; @endphp
                                                @elseif ($item['category_type'] == 'drinking_water')
                                                    @php $drinkingWaterItem = $item; @endphp
                                                @elseif ($item['category_type'] == 'toilet_block')
                                                    @php $toiletBlockItem = $item; @endphp
                                                @elseif ($item['category_type'] == 'play_ground')
                                                    @php $playGroundItem = $item; @endphp
                                                @elseif ($item['category_type'] == 'library')
                                                    @php $libraryItem = $item; @endphp
                                                @elseif ($item['category_type'] == 'computer_lab')
                                                    @php $computerLabItem = $item; @endphp
                                                @elseif ($item['category_type'] == 'science_lab/physics')
                                                    @php $physicsLabItem = $item; @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                        <td>
                                            @if (!is_null($gatePictureItem))
                                                @php
                                                    $status =
                                                        $gatePictureItem['verify'] == 0
                                                            ? 'pending'
                                                            : ($gatePictureItem['verify'] == 1
                                                                ? '<span class="bg-label-success">Verified</span>'
                                                                : ($gatePictureItem['verify'] == 2
                                                                    ? 'Send back to school'
                                                                    : 'n/a'));
                                                @endphp
                                                {!! $status !!}
                                            @endif
                                        </td>
                                        <td>
                                            @if (!is_null($academicBlockItem))
                                                @php
                                                    $status =
                                                        $academicBlockItem['verify'] == 0
                                                            ? 'pending'
                                                            : ($gatePictureItem['verify'] == 1
                                                                ? '<span class="bg-label-success">Verified</span>'
                                                                : ($academicBlockItem['verify'] == 2
                                                                    ? 'Send back to school'
                                                                    : 'n/a'));
                                                @endphp
                                                {!! $status !!}
                                            @endif
                                        </td>
                                        <td>
                                            @if (!is_null($drinkingWaterItem))
                                                @php
                                                    $status =
                                                        $drinkingWaterItem['verify'] == 0
                                                            ? 'pending'
                                                            : ($gatePictureItem['verify'] == 1
                                                                ? '<span class="bg-label-success">Verified</span>'
                                                                : ($drinkingWaterItem['verify'] == 2
                                                                    ? 'Send back to school'
                                                                    : 'n/a'));
                                                @endphp
                                                {!! $status !!}
                                            @endif

                                        </td>
                                        <td>
                                            @if (!is_null($toiletBlockItem))
                                                @php
                                                    $status =
                                                        $toiletBlockItem['verify'] == 0
                                                            ? 'pending'
                                                            : ($toiletBlockItem['verify'] == 1
                                                                ? '<span class="bg-label-success">Verified</span>'
                                                                : ($toiletBlockItem['verify'] == 2
                                                                    ? 'Send back to school'
                                                                    : 'n/a'));
                                                @endphp
                                                {!! $status !!}
                                            @endif

                                        </td>
                                        <td>
                                            @if (!is_null($playGroundItem))
                                                @php
                                                    $status =
                                                        $playGroundItem['verify'] == 0
                                                            ? 'pending'
                                                            : ($gatePictureItem['verify'] == 1
                                                                ? '<span class="bg-label-success">Verified</span>'
                                                                : ($playGroundItem['verify'] == 2
                                                                    ? 'Send back to school'
                                                                    : 'n/a'));
                                                @endphp
                                                {!! $status !!}
                                            @endif

                                        </td>
                                        <td>
                                            @if (!is_null($libraryItem))
                                                @php
                                                    $status =
                                                        $libraryItem['verify'] == 0
                                                            ? 'pending'
                                                            : ($gatePictureItem['verify'] == 1
                                                                ? '<span class="bg-label-success">Verified</span>'
                                                                : ($libraryItem['verify'] == 2
                                                                    ? 'Send back to school'
                                                                    : 'n/a'));
                                                @endphp
                                                {!! $status !!}
                                            @endif

                                        </td>
                                        <td>
                                            @if (!is_null($computerLabItem))
                                                @php
                                                    $status =
                                                        $computerLabItem['verify'] == 0
                                                            ? 'pending'
                                                            : ($gatePictureItem['verify'] == 1
                                                                ? '<span class="bg-label-success">Verified</span>'
                                                                : ($computerLabItem['verify'] == 2
                                                                    ? 'Send back to school'
                                                                    : 'n/a'));
                                                @endphp
                                                {!! $status !!}
                                            @endif

                                        </td>
                                        <td>

                                            @if (!is_null($physicsLabItem))
                                                @php
                                                    $status =
                                                        $physicsLabItem['verify'] == 0
                                                            ? 'pending'
                                                            : ($gatePictureItem['verify'] == 1
                                                                ? '<span class="bg-label-success">Verified</span>'
                                                                : ($physicsLabItem['verify'] == 2
                                                                    ? 'Send back to school'
                                                                    : 'n/a'));
                                                @endphp
                                                {!! $status !!}
                                            @endif
                                        </td>
                                        {{-- <td>
                                            @if ($metadata->s_lat !== null && $metadata->s_lng !== null)
                                                {{ $metadata->s_lat }}
                                            @else
                                                N/A
                                            @endif
                                        </td> --}}
                                        {{-- <td>
                                            @if ($metadata->s_lat !== null && $metadata->s_lng !== null)
                                                {{ $metadata->s_lng }}
                                            @else
                                                N/A
                                            @endif
                                        </td>  --}}
                                        <td>
                                            <span class="badge bg-label-success me-1">Verified</span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="school-in-data-table-pagenation">
                    {{ $schoolsPaginated->links() }}

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
