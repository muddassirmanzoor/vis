@extends('layouts.main')
@section('content')

    <!----------------------->


    @include('includes.header')
     <!--------------------->

    <main >
		<section class="position-relative overflow-hidden text-center bg-light hero-area-map">
            <div class="row">
                <div class="col-md-12 p-lg-12 mx-auto">
                    <h1 class="indicator-heading">Punjab Schools : Teachers & Facilities</h1>
                </div>
            </div>
        </section>
	    <section class="filter-wrapper">
            <div class="container">
                <div class="row align-items-center justify-content-between pt-3 pb-3">

                    <div class="col-md-12 mobile-btn-location">
                        <button class="btn btn-primary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="background: #28416f;border: 0px;margin-top: 10px;float:right;">
                            <i class="fa fa-filter" aria-hidden="true"></i> Filters
                        </button>
                    </div>
                </div>

                <div class="collapse" id="collapseExample">
                    <form id="filterForm" method="POST" action="{{ route('get-schools') }}">
                        @csrf
                        <div class="row">
                                <div class="col-md-2 mb-2">
                                    <label for="District" class="form-label">District</label>
                                    <select class="form-select" id="district" name="district" >
                                        <option value="">All Punjab</option>
                                        <!-- Populate options dynamically from database -->
                                        @foreach($districts as $district)

                                            <option value="{{ $district->s_district_idFk }}" <?php if($districtId == $district->s_district_idFk) { echo "selected"; } ?>>{{ $district->d_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2 ">
                                    <label for="Tehsils" class="form-label">Tehsil</label>
                                    <select class="form-select" id="tehsil" name="tehsil" >
                                            <option value="">Select Tehsil</option>
                                            @if($tehsils)
                                                @foreach($tehsils as $tehsil)
                                                    <option value="{{ $tehsil->s_tehsil_idFk }}" <?php if($tehsilId == $tehsil->s_tehsil_idFk) { echo "selected"; } ?>>{{ $tehsil->t_name }}</option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label for="Marakez" class="form-label">Markaz</label>
                                    <select class="form-select" id="markaz" name="markaz">
                                        <option value="">Select Markaz</option>
                                        @if($markazes)
                                            @foreach($markazes as $markaz)
                                                <option value="{{ $markaz->s_markaz_idFk }}" <?php if($markazId == $markaz->s_markaz_idFk) { echo "selected"; } ?>>{{ $markaz->m_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2">
                                <label for="School_level" class="form-label">School Type</label>
                                    <select class="form-select" id="s_type" name="s_type" >
                                        <option value="">Select Gender</option>
                                        <option value="Male"<?php if($s_type =="Male") { echo "selected"; } ?>>Male</option>
                                        <option value="Female" <?php if($s_type =="Female") { echo "selected"; } ?>>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label for="Gender" class="form-label">School Level</label>
                                    <select class="form-select"  id="s_level" name="s_level" >
                                            <option value="">Select Level</option>
                                            <option value="Primary" <?php if($s_level =="Primary") { echo "selected"; } ?>>Primary</option>
                                            <!-- <option value="sMosque">sMosque</option> -->
                                            <option value="Middle" <?php if($s_level =="Middle") { echo "selected"; } ?>>Middle</option>
                                            <option value="High" <?php if($s_level == "High") { echo "selected"; } ?>>High</option>
                                            <option value="H.Sec." <?php if($s_level =="H.Sec.") { echo "selected"; } ?>>Higher Secondary</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label for="Gender" class="form-label">No. Of Teachers</label>
                                    <select class="form-select"  id="teachers" name="teachers" >
                                            <option value="">Select Teachers</option>
                                            <option value="0"  <?php if($teachers == "0") { echo "selected"; } ?>>Zero Teacher</option>
                                            <option value="1" <?php if($teachers =="1") { echo "selected"; } ?>>Single Teacher</option>
                                            <option value="2" <?php if($teachers =="2") { echo "selected"; } ?>>Two Teachers</option>

                                    </select>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label for="Gender" class="form-label">Projects</label>
                                    <select class="form-select"  id="project" name="project" >
                                            <option value="">Select Project</option>
                                            <option value="PHCIP"  <?php if($project == "PHCIP") { echo "selected"; } ?>>PHCIP</option>
                                            <option value="ASP" <?php if($project =="ASP") { echo "selected"; } ?>>ASP</option>
                                            <option value="ECE" <?php if($project =="ECE") { echo "selected"; } ?>>ECE</option>
                                            <option value="MEAL" <?php if($project =="MEAL") { echo "selected"; } ?>>MEAL PROGRAMME</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label for="Gender" class="form-label">Provincial Constituency</label><br>
                                    <select class="form-select select2-w-100"  id="pp_seat" name="pp_seat" style="width: 100%;">
                                        <option value="">Select PP</option>
                                        @if($pp_seat)
                                            @foreach($pp_seat as $pp)
                                                <option value="{{ $pp->pp_no }}" <?php if($ppId == $pp->pp_no) { echo "selected"; } ?>>{{ $pp->pp_seat }} </option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label for="Gender" class="form-label">National Constituency</label><br>
                                    <select class="form-select select2-w-100"  id="na_seat" name="na_seat" style="width: 100%;">
                                        <option value="">Select NA</option>
                                        @if($na_seat)
                                            @foreach($na_seat as $na)
                                                <option value="{{ $na->na_no }}" <?php if($naId == $na->na_no) { echo "selected"; } ?>>{{ $na->na_seat }} </option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="Gender" class="form-label">School</label><br>
                                    <select class="form-select select2-w-100"  id="school" name="school" style="width: 100%;">
                                        <option value="">Select School</option>
                                        @if($schools)
                                            @foreach($schools as $school)
                                                <option value="{{ $school->id }}" <?php if($schoolId == $school->id) { echo "selected"; } ?>>{{ $school->s_emis_code }} || {{ $school->s_name }}  </option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                                <div class="col-md-12 text-right">

                                <button class="btn btn-primary mb-2" type="submit" style="background: #28416f;border: 0px;margin-top: 10px;float:right;">Submit</button>
                                <a href="{{ url('show-map') }}" class="btn btn-danger mb-2 mr-3" style="border: 0px;margin-top: 10px;float:right;margin-right: 10px;">Reset </a>
                                </div>

                        </div>
                    </form>
                </div>
                <div class="row">

                        <div class="col-md-12 mb-2">
                            <div  class="badge-wrapper-primary  mb-2">
                                No. Of Schools:  <span class="badge badge-light">{{count($schools)}}</span>
                            </div>
                            @if($districtName)

                            <div  class="badge-wrapper-primary  mb-2">
                                District:  <span class="badge badge-light">{{$districtName->district_name}}</span>
                            </div>

                            @endif
                            @if($PPName)

                                <div  class="badge-wrapper-primary  mb-2">
                                    PP:  <span class="badge badge-light">{{$PPName->pp_seat}}</span>
                                </div>

                            @endif
                            @if($NAName)

                                <div  class="badge-wrapper-primary  mb-2">
                                    NA:  <span class="badge badge-light">{{$NAName->na_seat}}</span>
                                </div>

                                @endif
                            @if($tehsilName)
                            <div  class="badge-wrapper-primary  mb-2">
                                Tehsil:  <span class="badge badge-light">{{$tehsilName->tehsil_name}}</span>
                            </div>
                            @endif
                            @if($markazName)
                            <div  class="badge-wrapper-primary  mb-2">
                                Markaz:  <span class="badge badge-light">{{$markazName->m_name}}</span>
                            </div>
                            @endif
                            @if($s_type)
                            <div  class="badge-wrapper-primary  mb-2">
                                School Type:  <span class="badge badge-light">{{ $s_type }}</span>
                            </div>
                            @endif
                            @if($s_level)
                            <div  class="badge-wrapper-primary  mb-2">
                                School Level: <span class="badge badge-light">{{$s_level}}</span>
                            </div>
                            @endif
                            @if($teachers)
                            <div  class="badge-wrapper-primary  mb-2">
                                No. of Teachers:  <span class="badge badge-light">{{$teachers}}</span>
                            </div>
                            @endif
                            @if($project)
                            <div  class="badge-wrapper-primary  mb-2">
                                Project:  <span class="badge badge-light">{{$project}}</span>
                            </div>
                            @endif
                            @if($schoolName)
                            <div  class="badge-wrapper-primary  mb-2">
                                School:  <span class="badge badge-light">{{ $schoolName->s_name }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-12 mb-2">
                            @if($PPName || $NAName)

                                <div  class="mb-2">
                                     <span class=""><b>Disclaimer:</b> Constituency data is supplied by Head Masters and confirmed by the respective CEOs. In case of errors or omissions, please register compalints <b><a href="{{ url('complaint-form') }}">here</a></b></span>
                                </div>
                                <div class="mb-2" id="schoolsListWrapper" style="display: none;">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr><th  colspan="7" style="text-align:center; padding-top:7px;"><h2>Constituency Wise Schools</h2></th> </tr>
                                            <tr >
                                                <th style="border: 1px solid black;">Sr.#</th>
                                                <th style="border: 1px solid black;">EMIS Code</th>
                                                <th style="border: 1px solid black;">School Name</th>
                                                <th style="border: 1px solid black;">District</th>
                                                <th style="border: 1px solid black;">PP</th>
                                                <th style="border: 1px solid black;">NA</th>
                                                <th style="border: 1px solid black;">Gender</th>
                                                <th style="border: 1px solid black;">Level</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $counter = 1;
                                            @endphp
                                            @foreach($schools as $school)
                                                <tr>
                                                    <td style="border: 1px solid black;">{{ $counter }}</td>
                                                    <td style="border: 1px solid black;">{{ $school->s_emis_code }}</td>
                                                    <td style="border: 1px solid black;">{{ $school->s_name }}</td>
                                                    <td style="border: 1px solid black;">{{ $school->d_name }}</td>
                                                    <td style="border: 1px solid black;">{{ $school->pp_seat }}</td>
                                                    <td style="border: 1px solid black;">{{ $school->na_seat }}</td>
                                                    <td style="border: 1px solid black;">{{ $school->s_type }}</td>
                                                    <td style="border: 1px solid black;">{{ $school->s_level }}</td>
                                                </tr>
                                                @php
                                                    $counter++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mb-2">
                                    <button onclick="printSchoolsList()" class="btn btn-primary" style="background: #04578f !important;">Download Schools List</button>
                                </div>

                            @endif
                        </div>
                        <div class="col-md-12 mb-3">
                            <div id="map"></div>
                        </div>
                </div>

		    </div>
		</section>


    </main>

<!--</div>-->
<script type="text/javascript">
    function initMap() {
        const districts = {!! json_encode($districts) !!};
        console.log( districts);
        const districtId = parseInt(document.getElementById('district').value, 10);

        const selectedDistrict = districts.find(district => district.s_district_idFk === districtId);

        let center, zoom;

        // Set center and zoom level based on selected district or default values
        if (selectedDistrict) {
            const latitude = parseFloat(selectedDistrict.lat);
            const longitude = parseFloat(selectedDistrict.long);

            if (!isNaN(latitude) && !isNaN(longitude)) {
                center = { lat: latitude, lng: longitude };
                zoom = 10;
            } else {
                // Handle case where latitude or longitude is not a number
                // Set default center and zoom
                center = { lat: 31.1704, lng: 72.7097 };
                zoom = 7;
            }
        } else {
            // Handle case where selected district is not found
            // Set default center and zoom
            center = { lat: 31.1704, lng: 72.7097 };
            zoom = 7;
        }

        // Initialize map with dynamic center and zoom
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: zoom,
            center: center,
        });
//         console.log('Type of districtId:', typeof districtId);
// console.log('Type of s_district_idFk:', typeof districts[0].s_district_idFk);
//         console.log('Selected District:', selectedDistrict);
//         console.log('District ID:', districtId);
//         console.log('Center:', center);
//         console.log('Zoom:', zoom);

        const markerIcons = {
        'Male Primary': '/img/pins/male-p.png',
        'Male sMosque': '/img/pins/male-p.png',
        'Female Primary': '/img/pins/female-p.png',
        'Male Middle': '/img/pins/male-md.png',
        'Female Middle': '/img/pins/female-md.png',
        'Male High': '/img/pins/male-h.png',
        'Female High': '/img/pins/female-h.png',
        'Male H.Sec.': '/img/pins/male-hs.png',
        'Female H.Sec.': '/img/pins/female-hs.png',
        };

        // Create legends panel
        const legendsPanel = document.createElement('div');
        legendsPanel.classList.add('legends-panel');
        legendsPanel.innerHTML = `
            <div><img src="/img/pins/male-p.png"> Boys Primary</div>
            <div><img src="/img/pins/female-p.png"> Girls Primary</div>
            <div><img src="/img/pins/male-md.png"> Boys Middle</div>
            <div><img src="/img/pins/female-md.png"> Girls Middle</div>
            <div><img src="/img/pins/male-h.png"> Boys High</div>
            <div><img src="/img/pins/female-h.png"> Girls High</div>
            <div><img src="/img/pins/male-hs.png"> Boys H.Sec.</div>
            <div><img src="/img/pins/female-hs.png"> Girls H.Sec.</div>
        `;

        // Append toggle button and legends panel to map
        //map.controls[google.maps.ControlPosition.RIGHT_TOP].push(toggleButton);
        map.controls[google.maps.ControlPosition.RIGHT_TOP].push(legendsPanel);







        // Get schools data passed from the controller
        const schools = {!! json_encode($schools) !!};
        let openInfoWindow = null;
        // Loop through schools data and add markers to the map
        schools.forEach(function(school) {
            const markerIcon = markerIcons[`${school.s_type} ${school.s_level}`];

            const marker = new google.maps.Marker({
                position: { lat: parseFloat(school.s_lat), lng: parseFloat(school.s_lng) },
                map: map,
                title: school.s_name,
                icon: markerIcon
            });

            // Add info window to the marker
            const infoWindow = new google.maps.InfoWindow({
                content: createInfoWindowContent(school)
            });

            // Show info window when marker is clicked
            marker.addListener('click', function() {
                if (openInfoWindow !== null) {
                    openInfoWindow.close();
                }
                infoWindow.open(map, marker);
                openInfoWindow = infoWindow;
            });
        });

        // Attach event listeners outside the loop
        attachEventListeners();

    }

    function createInfoWindowContent(school) {

       return '<div class="school-info-map-wrapper">' +
                            '<button onclick="printTable()" class="btn btn-primary" style="margin-bottom: 10px;background: #04578f !important;">Download</button>' +
                            '<div class="printable">'+
                            '<table class="table table-bordered table-striped ">' +
                            '<tr style="background-color: #c5e0ff !important;" ><td colspan="4"><h4 style="text-align:center !important; padding-top:10px;padding-bottom:10px; border-bottom: 2px solid #04578f; color: #04578f;font-weight:bold;" class="school-name-heading">'+ school.s_emis_code + ' - ' +  school.s_name + '</h4></td></tr>' +
                            '<tr><td class="school-info-title">District</td><td class="school-info-vaule">' + school.d_name + '</td>' +
                            '<td class="school-info-title">Tehsil</td><td class="school-info-vaule">' + school.t_name + '</td></tr>' +
                            '<tr><td class="school-info-title">Markaz</td><td class="school-info-vaule">' + school.m_name + '</td>' +
                            '<td class="school-info-title">Gender</td><td class="school-info-vaule">' + school.s_type + '</td></tr>' +
                            '<tr><td class="school-info-title">Level</td><td class="school-info-vaule">' + school.s_level + '</td>' +
                            '<td class="school-info-title">No. of Teachers</td><td class="school-info-vaule">' + school.no_of_teachers + '</td></tr>' +
                            '<tr><td class="school-info-title">No. of Students</td><td class="school-info-vaule">' + school.total_students + '</td>' +
                            '<td class="school-info-title">Student to Teacher Ratio (40:1 recommended)</td><td class="school-info-vaule">' +
                                (school.no_of_teachers != 0 ?
                                    (Math.round(school.total_students / school.no_of_teachers) > 40 ?
                                        '<span style="color:red;">' + Math.round(school.total_students / school.no_of_teachers) + ':1</span>' :
                                        Math.round(school.total_students / school.no_of_teachers) + ':1'
                                    ) :
                                    '<span style="color:red;">' +school.total_students + ':0</span>'
                                ) +
                            '</td></tr>' +
                            '<tr style="background-color: #c5e0ff !important;" ><td colspan="4"><h4 style="text-align:center !important; padding-top:10px;padding-bottom:10px; border-bottom: 2px solid #04578f; color: #04578f;" class="school-facility-heading"> AVAILABLE FACILITIES </h4></td></tr>' +
                            '<tr><td class="school-info-title">Electricity</td><td class="school-info-vaule">' + (school.electricity == 1 ? 'Yes' : '<span style="color:red;">No</span>') + '</td>' +
                            '<td class="school-info-title">Drinking Water</td><td class="school-info-vaule">' + (school.dw == 1 ? 'Yes' : '<span style="color:red;">No</span>') + '</td></tr>' +
                            '<tr><td class="school-info-title">Toilets</td><td class="school-info-vaule">' + (school.toilet_facility == 1 ? 'Yes (Total: '+ school.total_toilets +', Usable: '+ school.usable_toilets +')' : '<span style="color:red;">No</span>') + '</td>' +
                            '<td class="school-info-title">Boundary Wall</td><td class="school-info-vaule">' + (school.bw == 1 ? 'Yes' : '<span style="color:red;">No</span>') + '</td></tr>' +
                            '<tr><td class="school-info-title">Functional Classrooms</td><td class="school-info-vaule">' + school.functional_classrooms + '</td>' +
                            '<td class="school-info-title">Science Lab</td><td class="school-info-vaule">' + (school.science_lab == 1 ? 'Yes' : '<span style="color:red;">No</span>') + '</td></tr>' +
                            '<tr><td class="school-info-title">Library</td><td class="school-info-vaule">' + (school.library == 1 ? 'Yes' : '<span style="color:red;">No</span>') + '</td>' +
                            '<td class="school-info-title">Computer Lab</td><td class="school-info-vaule">' + (school.computer_lab == 1 ? 'Yes (Functional Computers: '+ school.functional_computers +')' : '<span style="color:red;">No</span>') + '</td></tr>' +
                            '<tr><td class="school-info-title">Play Ground</td><td class="school-info-vaule">' + (school.play_ground == 1 ? 'Yes' : '<span style="color:red;">No</span>') + '</td>' +
                            '<td class="school-info-title">Total Area</td><td class="school-info-vaule">' + school.area  + '</td></tr>' +
                            '<tr style="background-color: #c5e0ff !important;" ><td colspan="4"><h4 style="text-align:center !important; padding-top:10px;padding-bottom:10px; border-bottom: 2px solid #04578f; color: #04578f;" class="school-facility-heading"> Enrollment & Teachers History </h4></td></tr>' +
                            '<tr><td class="school-info-title">Students 2023</td><td class="school-info-vaule">' + school.t_students_2023 + '</td>' +
                            '<td class="school-info-title">Teachers 2023</td><td class="school-info-vaule">' + school.t_teachers_2023 + '</td></tr>' +
                            '<tr><td class="school-info-title">Students 2022</td><td class="school-info-vaule">' + school.t_students_2022 + '</td>' +
                            '<td class="school-info-title">Teachers 2022</td><td class="school-info-vaule">' + school.t_teachers_2022 + '</td></tr>' +
                            '<tr><td class="school-info-title">Students 2021</td><td class="school-info-vaule">' + school.t_students_2021 + '</td>' +
                            '<td class="school-info-title">Teachers 2021</td><td class="school-info-vaule">' + school.t_teachers_2021 + '</td></tr>' +
                        '</table></div></div>';
    }

    function printTable(school1) {



        var printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>School Info</title>');
        printWindow.document.write('</head><body>');
       // printWindow.document.write(table);
        printWindow.document.write(document.getElementsByClassName('printable')[0].innerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }



    function attachEventListeners() {
    // Toggle button


        // Legends panel
        const legendsPanel = document.createElement('div');
        legendsPanel.classList.add('legends-panel');
        legendsPanel.innerHTML = `
            <div><img src="/img/pins/male-p.png"> Boys Primary</div>
            <div><img src="/img/pins/female-p.png"> Girls Primary</div>
            <div><img src="/img/pins/male-md.png"> Boys Middle</div>
            <div><img src="/img/pins/female-md.png"> Girls Middle</div>
            <div><img src="/img/pins/male-h.png"> Boys High</div>
            <div><img src="/img/pins/female-h.png"> Girls High</div>
            <div><img src="/img/pins/male-hs.png"> Boys H.Sec.</div>
            <div><img src="/img/pins/female-hs.png"> Girls H.Sec.</div>
        `;

        map.controls[google.maps.ControlPosition.RIGHT_TOP].push(legendsPanel);

    }


    window.initMap = initMap;

    // Event listener for district change
        document.getElementById("district").addEventListener("change", function() {

            const districtId = this.value;
            $.ajax({
                url: "/get-tehsils",
                type: "POST",
                data: { district_id: districtId, _token: '{{ csrf_token() }}' },
                success: function(data) {
                    // Populate tehsil dropdown with fetched tehsils

                    $("#tehsil").html('<option value="">Select Tehsil</option>');
                    $.each(data, function(key, value) {
                        console.log(value);
                        $("#tehsil").append('<option value="' + value.s_tehsil_idFk + '"  <?php if($tehsilId == "' + value.s_tehsil_idFk + '") { echo "selected"; } ?>>' + value.t_name + '</option>');

                    });
                }
            });

            $.ajax({
                url: "/fetch-pp-seats",
                type: "POST",
                data: { district_id: districtId, _token: '{{ csrf_token() }}' },
                success: function(data) {
                    // Populate tehsil dropdown with fetched tehsils

                    $("#pp_seat").html('<option value="">Select PP</option>');
                    $.each(data, function(key, value) {
                        console.log(value);
                        $("#pp_seat").append('<option value="' + value.pp_no + '"  <?php if($ppId == "' + value.pp_no + '") { echo "selected"; } ?>>' + value.pp_seat + '</option>');

                    });
                }
            });

            $.ajax({
                url: "/fetch-na-seats",
                type: "POST",
                data: { district_id: districtId, _token: '{{ csrf_token() }}' },
                success: function(data) {
                    // Populate tehsil dropdown with fetched tehsils

                    $("#na_seat").html('<option value="">Select NA</option>');
                    $.each(data, function(key, value) {
                        console.log(value);
                        $("#na_seat").append('<option value="' + value.na_no + '"  <?php if($naId == "' + value.na_no + '") { echo "selected"; } ?>>' + value.na_seat + '</option>');

                    });
                }
            });

            $.ajax({
                url: "/get-schools-ajax",
                type: "POST",
                data: { district_id: districtId, _token: '{{ csrf_token() }}' },
                success: function(data) {
                    // Populate markaz dropdown with fetched markazes
                    $("#school").html('<option value="">Select School</option>');
                    $.each(data, function(key, value) {
                        $("#school").append('<option value="' + value.id + '"  <?php if($schoolId == "' + value.id + '") { echo "selected"; } ?>>' + value.s_emis_code + ' || ' + value.s_name +'</option>');
                    });
                }
            });




        });

        // Event listener for tehsil change
        document.getElementById("tehsil").addEventListener("change", function() {
            const tehsilId = this.value;
            // Enable markaz dropdown


            // Fetch markazes based on selected tehsil using AJAX
            $.ajax({
                url: "/get-markazes",
                type: "POST",
                data: { tehsil_id: tehsilId, _token: '{{ csrf_token() }}' },
                success: function(data) {
                    // Populate markaz dropdown with fetched markazes
                    $("#markaz").html('<option value="">Select Markaz</option>');
                    $.each(data, function(key, value) {
                        $("#markaz").append('<option value="' + value.s_markaz_idFk + '"  <?php if($markazId == "' + value.s_markaz_idFk + '") { echo "selected"; } ?>>' + value.m_name + '</option>');
                    });
                }
            });
        });

        document.getElementById("markaz").addEventListener("change", function() {
            const markazId = this.value;
            // Enable markaz dropdown


            // Fetch markazes based on selected tehsil using AJAX
            $.ajax({
                url: "/get-schools-ajax",
                type: "POST",
                data: { markaz_id: markazId, _token: '{{ csrf_token() }}' },
                success: function(data) {
                    // Populate markaz dropdown with fetched markazes
                    $("#school").html('<option value="">Select School</option>');
                    $.each(data, function(key, value) {
                        $("#school").append('<option value="' + value.id + '"  <?php if($schoolId == "' + value.id + '") { echo "selected"; } ?>>' + value.s_emis_code + ' || ' + value.s_name +'</option>');
                    });
                }
            });
        });
</script>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>

<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
<script>
// Apply Select2 to your select element
//   $(document).ready(function() {
//     $('#district').select2();
// 	$('#tehsil').select2();
// 	$('#markez').select2();
// 	$('#s_type').select2();
// 	$('#s_level').select2();
//   });
$(document).ready(function() {
    $('#school').select2();
});
function showTooltip() {
    var tooltip = document.getElementById("myTooltip");
    tooltip.style.visibility = "visible";
    tooltip.style.opacity = "1";
    // You can perform any other actions here when the tooltip is clicked
}
</script>
<script>
    function printSchoolsList() {
        var printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Schools List</title>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(document.getElementById('schoolsListWrapper').innerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>

@endsection
