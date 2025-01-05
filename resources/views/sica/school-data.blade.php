@extends('layouts.sica.main')
@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.dataTables.min.css">
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js">
    </script>

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Detailed </span> Data</h4>
        @if (Session::has('success_message'))
            <div class="alert alert-success">
                {{ Session::get('success_message') }}
            </div>
        @endif

        @if (Session::has('error_message'))
            <div class="alert alert-danger">
                {{ Session::get('error_message') }}
            </div>
        @endif

        <!-----------FILTER START------------->
        <form id="schoolForm" action="{{ route('sica.emis_get_school') }}" method="GET">
            <div class="row mb-3">
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="districtSelect" class="form-label">District</label>
                        <?php //echo "<pre>";print_r($districts);exit;
                        ?>
                        <select id="districtSelect" class="form-select" name="districtid">
                            <option value="0">Select District</option>
                            @if (Auth::check() && Auth::user()->user_type === 'ADMIN')
                                @foreach ($districts as $district)
                                    <option value="{{ $district->district_id }}" <?php if ($districtID == $district->district_id) {
                                        echo 'selected';
                                    } ?>>
                                        {{ $district->district_name }}</option>
                                @endforeach
                            @else
                                <option value="{{ $districts->district_id }}" selected> {{ $districts->district_name }}</option>
                            @endif

                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="tehsilSelect" class="form-label">Tehsils</label>
                        <select id="tehsilSelect" name="tehsil" class="form-select">
                            <option value="0">Select Tehsil</option>
                            @if ($tehsils)
                                @foreach ($tehsils as $tehsil)
                                    <option value="{{ $tehsil->s_tehsil_idFk }}" <?php if ($tehsil_select == $tehsil->s_tehsil_idFk) {
                                        echo 'selected';
                                    } ?>>{{ $tehsil->t_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="markazSelect" class="form-label">Markaz</label>
                        <select id="markazSelect" name="markez_select" class="form-select js-example-basic-single">
                            <option value="0">Select Markaz</option>
                            @if ($markazes)
                                @foreach ($markazes as $markaz)
                                    <option value="{{ $markaz->s_markaz_idFk }}" <?php if ($markez_select == $markaz->s_markaz_idFk) {
                                        echo 'selected';
                                    } ?>>{{ $markaz->m_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="schoolsSelect" class="form-label">School Name</label>
                        <select id="schoolsSelect" name="school_emis_code" class="form-select js-example-basic-single">
                            <option value="0">Select School</option>
                            @if ($schools)
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}" <?php if ($school_select == $school->id) {
                                        echo 'selected';
                                    } ?>>{{ $school->s_emis_code }} ||
                                        {{ $school->s_name }} </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="statusSelect" class="form-label">Status</label>
                        <select id="statusSelect" name="status_select" class="form-select js-example-basic-single">
                            <option value="0" <?php if ($status_select == '0') {
                                echo 'selected';
                            } ?>>Select Status</option>
                            <option value="1" <?php if ($status_select == '1') {
                                echo 'selected';
                            } ?>>Verified</option>
                            <option value="2" <?php if ($status_select == '2') {
                                echo 'selected';
                            } ?>>Un-verified</option>
                            <option value="3" <?php if ($status_select == '3') {
                                echo 'selected';
                            } ?>>Data not submitted</option>
                            <option value="4" <?php if ($status_select == '4') {
                                echo 'selected';
                            } ?>>Pending for review</option>
                        </select>
                    </div>
                </div>


                <div class="col-md-1">
                    <div class="mb-3">
                        <label for="schoolsSelect" class="form-label"></label>
                        <button id="filter_apply" class="btn btn-primary d-grid w-100">Apply</button>
                    </div>
                </div>
            </div>
        </form>
        <!-----------FILTER END------------->
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
                            @if ($grouped_and_mapped->isEmpty())
                                <tr>
                                    <td colspan="16">No data found</td>
                                </tr>
                            @else
                                @foreach ($grouped_and_mapped as $emisCode => $metadata)
                                    <tr>

                                        <td>{{ ($schools->currentPage() - 1) * $schools->perPage() + $loop->iteration }}
                                        </td>
                                        <td>{{ $metadata->d_name }}</td> <!-- District Name -->
                                        <td>{{ $metadata->t_name }}</td> <!-- Tehsil Name -->
                                        <td>
                                            @if ($metadata->metadata_status == 'no')
                                                {{ $metadata->s_emis_code }}
                                            @else
                                                <a
                                                    href="{{ url('sica/school-images/' . encrypt($metadata->s_emis_code)) }}">{{ $metadata->s_emis_code }}
                                                </a>
                                            @endif
                                        </td> <!-- EMIS Code -->
                                        <td style="text-align: left;">{{ $metadata->s_name }}</td>
                                        <td>
                                            @if ($metadata->metadata_status == 'no')
                                                Data not Received
                                            @else
                                                @foreach ($metadata->metadata['items'] as $item)
                                                    @if ($item['category_type'] == 'gate_picture')
                                                        @php
                                                            $status =
                                                                $item['verify'] == 0
                                                                    ? 'pending'
                                                                    : ($item['verify'] == 1
                                                                        ? '<span class="bg-label-success">Verified</span>'
                                                                        : ($item['verify'] == 2
                                                                            ? 'Send back to school'
                                                                            : 'n/a'));
                                                        @endphp
                                                        {!! $status !!}
                                                    @break
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if ($metadata->metadata_status == 'no')
                                            Data not Received
                                        @else
                                            @foreach ($metadata->metadata['items'] as $item)
                                                @if ($item['category_type'] == 'academic_block')
                                                    @php
                                                        $status =
                                                            $item['verify'] == 0
                                                                ? 'pending'
                                                                : ($item['verify'] == 1
                                                                    ? '<span class="bg-label-success">Verified</span>'
                                                                    : ($item['verify'] == 2
                                                                        ? 'Send back to school'
                                                                        : 'n/a'));
                                                    @endphp
                                                    {!! $status !!}
                                                @break
                                            @endif
                                        @endforeach
                                    @endif
                                </td>

                                <td>
                                    @if ($metadata->metadata_status == 'no')
                                        Data not Received
                                    @else
                                        @foreach ($metadata->metadata['items'] as $item)
                                            @if ($item['category_type'] == 'drinking_water')
                                                @php
                                                    $status =
                                                        $item['verify'] == 0
                                                            ? 'pending'
                                                            : ($item['verify'] == 1
                                                                ? '<span class="bg-label-success">Verified</span>'
                                                                : ($item['verify'] == 2
                                                                    ? 'Send back to school'
                                                                    : 'n/a'));
                                                @endphp
                                                {!! $status !!}
                                            @break
                                        @endif
                                    @endforeach
                                @endif
                            </td>

                            <td>
                                @if ($metadata->metadata_status == 'no')
                                    Data not Received
                                @else
                                    @foreach ($metadata->metadata['items'] as $item)
                                        @if ($item['category_type'] == 'toilet_block')
                                            @php
                                                $status =
                                                    $item['verify'] == 0
                                                        ? 'pending'
                                                        : ($item['verify'] == 1
                                                            ? '<span class="bg-label-success">Verified</span>'
                                                            : ($item['verify'] == 2
                                                                ? 'Send back to school'
                                                                : 'n/a'));
                                            @endphp
                                            {!! $status !!}
                                        @break
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if ($metadata->metadata_status == 'no')
                                Data not Received
                            @else
                                @foreach ($metadata->metadata['items'] as $item)
                                    @if ($item['category_type'] == 'play_ground')
                                        @php
                                            $status =
                                                $item['verify'] == 0
                                                    ? 'pending'
                                                    : ($item['verify'] == 1
                                                        ? '<span class="bg-label-success">Verified</span>'
                                                        : ($item['verify'] == 2
                                                            ? 'Send back to school'
                                                            : 'n/a'));
                                        @endphp
                                        {!! $status !!}
                                    @break
                                @endif
                            @endforeach
                        @endif
                    </td>

                    <td>
                        @if ($metadata->metadata_status == 'no')
                            Data not Received
                        @else
                            @foreach ($metadata->metadata['items'] as $item)
                                @if ($item['category_type'] == 'library')
                                    @php
                                        $status =
                                            $item['verify'] == 0
                                                ? 'pending'
                                                : ($item['verify'] == 1
                                                    ? '<span class="bg-label-success">Verified</span>'
                                                    : ($item['verify'] == 2
                                                        ? 'Send back to school'
                                                        : 'n/a'));
                                    @endphp
                                    {!! $status !!}
                                @break
                            @endif
                        @endforeach
                    @endif
                </td>

                <td>
                    @if ($metadata->metadata_status == 'no')
                        Data not Received
                    @else
                        @foreach ($metadata->metadata['items'] as $item)
                            @if ($item['category_type'] == 'computer_lab')
                                @php
                                    $status =
                                        $item['verify'] == 0
                                            ? 'pending'
                                            : ($item['verify'] == 1
                                                ? '<span class="bg-label-success">Verified</span>'
                                                : ($item['verify'] == 2
                                                    ? 'Send back to school'
                                                    : 'n/a'));
                                @endphp
                                {!! $status !!}
                            @break
                        @endif
                    @endforeach
                @endif
            </td>
            <td>
                @if ($metadata->metadata_status == 'no')
                    Data not Received
                @else
                    @foreach ($metadata->metadata['items'] as $item)
                        @if ($item['category_type'] == 'science_lab/physics')
                            @php
                                $status =
                                    $item['verify'] == 0
                                        ? 'pending'
                                        : ($item['verify'] == 1
                                            ? '<span class="bg-label-success">Verified</span>'
                                            : ($item['verify'] == 2
                                                ? 'Send back to school'
                                                : 'n/a'));
                            @endphp
                            {!! $status !!}
                        @break
                    @endif
                @endforeach
            @endif
        </td>
        <?php //echo "<pre>";print_r($metadata->metadata['s_lat']);exit;
        ?>
        {{-- <td>
            @if (isset($metadata) && isset($metadata->metadata['s_lat']))
            {{ $metadata->metadata['s_lat'] }}
            @else
            DATA NOT RECEIVED
        @endif
        <td>
            @if (isset($metadata) && isset($metadata->metadata['s_lng']))
            {{ $metadata->metadata['s_lng'] }}
            @else
            DATA NOT RECEIVED
        @endif</td> <!-- Longitude --> --}}
        <td>
            @if ($metadata->metadata_status == 'no')
                <span class="badge bg-danger me-1">Data not Received</span>
            @else
                @if ($metadata->metadata['status'] == 1)
                    <span class="badge bg-label-success me-1">Verified</span>
                @else
                    <span class="badge bg-label-warning me-1">Pending</span>
                @endif
            @endif
        </td>
        {{-- @endif --}}
    </tr>
@endforeach
@endif
</tbody>
</table>
</div>
<div class="school-in-data-table-pagenation">
@if ($schools->count() > 0)
{{ $schools->links() }}
@endif
</div>

</div>
</div>
<!--/ Bordered Table -->
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    var districtSelect = document.getElementById('districtSelect');
    var tehsilSelect = document.getElementById('tehsilSelect');
    var markezSelect = document.getElementById('markazSelect');
    var schoolsSelect = document.getElementById('schoolsSelect');

    function fetchTehsilsAndPopulate(districtId) {
        fetch('/sica/get-tehsils/' + districtId, {
                cache: 'no-store'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                tehsilSelect.innerHTML = '<option value="">Select Tehsil</option>';
                data.forEach(tehsil => {
                    var option = document.createElement('option');
                    option.value = tehsil.tehsil_id;
                    option.textContent = tehsil.tehsil_name;
                    tehsilSelect.appendChild(option);
                });
                tehsilSelect.style.display = 'block';

                var urlParams = new URLSearchParams(window.location.search);
                var tehsilParam = urlParams.get('tehsil');
                if (tehsilParam) {
                    var tehsilOption = tehsilSelect.querySelector('option[value="' + tehsilParam + '"]');
                    if (tehsilOption) {
                        tehsilSelect.value = tehsilParam;
                        fetchAndPopulateMarkez(tehsilParam);
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching tehsils:', error);
            });
    }

    function fetchAndPopulateMarkez(tehsilId) {
    fetch('/sica/get-markez/' + tehsilId, {
            cache: 'no-store'
        })
        .then(response => response.json())
        .then(data => {
            markezSelect.innerHTML = '<option value="">Select Markaz</option>';
            data.forEach(markaz => {
                var option = document.createElement('option');
                option.value = markaz.m_id;
                option.textContent = markaz.m_name;
                markezSelect.appendChild(option);
            });
            markezSelect.style.display = 'block';
            initializeMarkezSelect();

            var urlParams = new URLSearchParams(window.location.search);
            var markezParam = urlParams.get('markez_select');
            if (markezParam) {
                var markezOption = markezSelect.querySelector('option[value="' + markezParam + '"]');
                if (markezOption) {
                    markezSelect.value = markezParam;
                    fetchAndPopulateSchools(markezParam);
                }
            }
        })
        .catch(error => {
            console.error('Error fetching markaz:', error);
        });
}

    function fetchAndPopulateSchools(markazId) {
        fetch('/sica/get-schools/' + markazId, {
                cache: 'no-store'
            })
            .then(response => response.json())
            .then(data => {
                schoolsSelect.innerHTML = '<option value="">Select School</option>';
                data.forEach(school => {
                    var option = document.createElement('option');
                    option.value = school.id;
                    option.textContent = school.s_emis_code + ' - ' + school.s_name;
                    schoolsSelect.appendChild(option);
                });
                schoolsSelect.style.display = 'block';
                initializeSchoolsSelect(); // Call initializeSchoolsSelect after populating options
            })
            .catch(error => {
                console.error('Error fetching schools:', error);
            });
    }

    districtSelect.addEventListener('change', function() {
        var districtId = this.value;
        fetchTehsilsAndPopulate(districtId);
    });

    fetchTehsilsAndPopulate(districtSelect.value);

    tehsilSelect.addEventListener('change', function() {
        var tehsilId = this.value;
        fetchAndPopulateMarkez(tehsilId);
    });

    markezSelect.addEventListener('change', function() {
        var markazId = this.value;
        console.log('Selected Markaz ID:', markazId); // Check the selected markazId
        fetchAndPopulateSchools(markazId);
    });

    function initializeSchoolsSelect() {
        $('#schoolsSelect').select2();
    }

    function initializeMarkezSelect() {
        $('#markezSelect').select2();
    }

    $('#example').DataTable({
        dom: '<"d-flex justify-content-between align-items-center mb-3"B>',
        buttons: [],
        paging: false,
        lengthChange: false,
        info: false,
        fixedHeader: true,
        responsive: true
    });
});
</script>
@endsection
