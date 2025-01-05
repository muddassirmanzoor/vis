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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Data Not Verified</h4>
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
                                            <a href="{{ url('sica/school-images/' . encrypt($metadata->s_emis_code)) }}">{{ $metadata->s_emis_code }}
                                            </a>
                                        </td> <!-- EMIS Code -->
                                        <td style="text-align: left;">{{ $metadata->s_name }}</td>
                                        <td>

                                            @php
                                                $status = 'pending'; // Initialize status to 'pending'
                                                $gatePictureFound = false; // Flag to track if gate_picture is found
                                            @endphp

                                            @foreach ($metadata->items as $item)
                                                @if ($item['category_type'] == 'gate_picture')
                                                    @php
                                                        $status =
                                                            $item['verify'] == 0
                                                                ? 'pending'
                                                                : ($item['verify'] == 2
                                                                    ? 'Send back to school'
                                                                    : 'Verified');
                                                        $gatePictureFound = true; // Set the flag to true
                                                    @endphp
                                                    {{ $status }}
                                                @break

                                                // Exit the loop once the 'gate_picture' category type is found
                                            @endif
                                        @endforeach

                                        @if (!$gatePictureFound)
                                            {{ $status }} {{-- Display 'pending' if gate_picture is not found --}}
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $status = 'pending'; // Initialize status to 'pending'
                                            $academicBlockFound = false; // Flag to track if academic_block is found
                                        @endphp
                                        @foreach ($metadata->items as $item)
                                            @if ($item['category_type'] == 'academic_block')
                                                @php
                                                    $status =
                                                        $item['verify'] == 0
                                                            ? 'pending'
                                                            : ($item['verify'] == 2
                                                                ? 'Send back to school'
                                                                : 'Verified');
                                                    $academicBlockFound = true; // Set the flag to true
                                                @endphp
                                                {{ $status }}
                                            @break
                                        @endif
                                    @endforeach

                                    @if (!$academicBlockFound)
                                        {{ $status }} {{-- Display 'pending' if academic_block is not found --}}
                                    @endif
                                </td>

                                <td>
                                    @php
                                        $status = 'pending'; // Initialize status to 'pending'
                                        $drinkingWaterFound = false; // Flag to track if drinking_water is found
                                    @endphp

                                    @foreach ($metadata->items as $item)
                                        @if ($item['category_type'] == 'drinking_water')
                                            @php
                                                $status =
                                                    $item['verify'] == 0
                                                        ? 'pending'
                                                        : ($item['verify'] == 2
                                                            ? 'Send back to school'
                                                            : 'Verified');
                                                $drinkingWaterFound = true; // Set the flag to true
                                            @endphp
                                            {{ $status }}
                                        @break

                                        // Exit the loop once the 'drinking_water' category type is found
                                    @endif
                                @endforeach

                                @if (!$drinkingWaterFound)
                                    {{ $status }} {{-- Display 'pending' if drinking_water is not found --}}
                                @endif
                            </td>
                            <td>
                                @php
                                    $status = 'pending'; // Initialize status to 'pending'
                                    $toiletBlockFound = false; // Flag to track if toilet_block is found
                                @endphp

                                @foreach ($metadata->items as $item)
                                    @if ($item['category_type'] == 'toilet_block')
                                        @php
                                            $status =
                                                $item['verify'] == 0
                                                    ? 'pending'
                                                    : ($item['verify'] == 2
                                                        ? 'Send back to school'
                                                        : 'Verified');
                                            $toiletBlockFound = true; // Set the flag to true
                                        @endphp
                                        {{ $status }}
                                    @break

                                    // Exit the loop once the 'toilet_block' category type is found
                                @endif
                            @endforeach

                            @if (!$toiletBlockFound)
                                {{ $status }} {{-- Display 'pending' if toilet_block is not found --}}
                            @endif
                        </td>
                        <td>
                            @php
                                $status = 'pending'; // Initialize status to 'pending'
                                $playGroundFound = false; // Flag to track if play_ground is found
                            @endphp

                            @foreach ($metadata->items as $item)
                                @if ($item['category_type'] == 'play_ground')
                                    @php
                                        $status =
                                            $item['verify'] == 0
                                                ? 'pending'
                                                : ($item['verify'] == 2
                                                    ? 'Send back to school'
                                                    : 'Verified');
                                        $playGroundFound = true; // Set the flag to true
                                    @endphp
                                    {{ $status }}
                                @break

                                // Exit the loop once the 'play_ground' category type is found
                            @endif
                        @endforeach

                        @if (!$playGroundFound)
                            {{ $status }} {{-- Display 'pending' if play_ground is not found --}}
                        @endif
                    </td>

                    <td>
                        @php
                            $status = 'pending'; // Initialize status to 'pending'
                            $libraryFound = false; // Flag to track if library is found
                        @endphp

                        @foreach ($metadata->items as $item)
                            @if ($item['category_type'] == 'library')
                                @php
                                    $status =
                                        $item['verify'] == 0
                                            ? 'pending'
                                            : ($item['verify'] == 2
                                                ? 'Send back to school'
                                                : 'Verified');
                                    $libraryFound = true; // Set the flag to true
                                @endphp
                                {{ $status }}
                            @break

                            // Exit the loop once the 'library' category type is found
                        @endif
                    @endforeach

                    @if (!$libraryFound)
                        {{ $status }} {{-- Display 'pending' if library is not found --}}
                    @endif
                </td>

                <td>
                    @php
                        $status = 'pending'; // Initialize status to 'pending'
                        $computerLabFound = false; // Flag to track if computer lab is found
                    @endphp

                    @foreach ($metadata->items as $item)
                        @if ($item['category_type'] == 'computer_lab')
                            @php
                                $status =
                                    $item['verify'] == 0
                                        ? 'pending'
                                        : ($item['verify'] == 2
                                            ? 'Send back to school'
                                            : 'Verified');
                                $computerLabFound = true; // Set the flag to true
                            @endphp
                            {{ $status }}
                        @break

                        // Exit the loop once the 'computer_lab' category type is found
                    @endif
                @endforeach

                @if (!$computerLabFound)
                    {{ $status }} {{-- Display 'pending' if computer lab is not found --}}
                @endif

            </td>
            <td>
                @php
                    $status = 'pending'; // Initialize status to 'pending'
                    $scienceLabPhysicsFound = false; // Flag to track if science lab (physics) is found
                @endphp

                @foreach ($metadata->items as $item)
                    @if ($item['category_type'] == 'science_lab/physics')
                        @php
                            $status =
                                $item['verify'] == 0
                                    ? 'pending'
                                    : ($item['verify'] == 2
                                        ? 'Send back to school'
                                        : 'Verified');
                            $scienceLabPhysicsFound = true; // Set the flag to true
                        @endphp
                        {{ $status }}
                    @break

                    // Exit the loop once the 'science_lab/physics' category type is found
                @endif
            @endforeach

            @if (!$scienceLabPhysicsFound)
                {{ $status }} {{-- Display 'pending' if science lab (physics) is not found --}}
            @endif
        </td>
        {{-- <td>{{ $metadata->s_lat }}</td> <!-- Latitude -->
        <td>{{ $metadata->s_lng }}</td> <!-- Longitude --> --}}
        <td>
            <span class="badge bg-label-warning me-1">Pending</span>
            {{-- @foreach ($metadata->items as $item)
                    @if ($item['verify'] == 2)
                        <span class="badge bg-label-warning me-1">Pending</span>
                    @elseif ($item['verify'] == 0)
                        <span class="badge bg-label-warning me-1">Pending</span>
                    @else
                        <span class="badge bg-label-warning me-1">Pending</span>
                    @endif
                @break
            @endforeach --}}
        </td>
        {{-- @endif --}}
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
