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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Data not submitted</h4>
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
                                            {{ $metadata->s_emis_code }}
                                        </td> <!-- EMIS Code -->
                                        <td style="text-align: left;">{{ $metadata->s_name }}</td>
                                        <td>
                                            n/a
                                        </td>
                                    <td>
                                        n/a
                                </td>

                                <td>
                                    n/a
                            </td>

                            <td>
                                n/a
                        </td>
                        <td>
                            n/a
                    </td>

                    <td>
                        n/a
                </td>

                <td>
                    n/a
            </td>
            <td>
                n/a
        </td>
        {{-- <td>{{ $metadata->s_lat }}</td> <!-- Latitude -->
        <td>{{ $metadata->s_lng }}</td> <!-- Longitude --> --}}
        <td>        
                <span class="badge bg-danger me-1">Data not Received</span>
        </td>
    {{-- @endif --}}
</tr>
@endforeach
@endif
</tbody>
</table>
</div>

{{-- Showing {{ $schools->firstItem() }} to {{ $schools->lastItem() }} of {{ $schools->total() }} results --}}
{{-- <p>
    Showing page {{ $schoolsPaginated->currentPage() }} of {{ $schoolsPaginated->lastPage() }}
    ({{ $schoolsPaginated->perPage() }} records per page)
</p> --}}
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
