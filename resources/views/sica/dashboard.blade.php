@extends('layouts.sica.main')
@section('content')

    <style>
        /* Loader styles */
        .loader {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 9999;
        }

        /* Background blur effect */
        .blur-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Adjust the alpha value for the desired level of blur */
            backdrop-filter: blur(5px);
            /* Adjust the blur radius as needed */
            z-index: 9998;
            /* Ensure the blur effect is behind the loader */
        }

        #map {
            height: 100%;
        }
    </style>
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Welcome To </span>SICA SED
        </h4>
        <!-----------FILTER START------------->
        <!-- Loader -->
        <div id="blur-background" style="display: none;" class="blur-background"></div>
        <div id="loader" style="display: none;" class="loader">
            <h3>Please wait...</h3>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="districtSelect" class="form-label">District</label>
                    <select id="districtSelect" class="form-select" name="districtid">
                        <option value="0">All Punjab</option>
                        @if (Auth::check() && Auth::user()->user_type === 'ADMIN')
                            @foreach ($districts as $district)
                                <option value="{{ $district->district_id }}">
                                    {{ $district->district_name }}</option>
                            @endforeach
                        @else
                            <option value="{{ $districts->district_id }}" selected>
                                {{ $districts->district_name }}</option>
                        @endif

                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="tehsilSelect" class="form-label">Tehsils</label>
                    <select id="tehsilSelect" class="form-select">
                        <option value="">Default select</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="markezSelect" class="form-label">Markaz</label>
                    <select id="markezSelect" class="form-select">
                        <option value="">Default select</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label for="schoolsSelect" class="form-label"></label>
                    <button id="filter_apply" class="btn btn-primary d-grid w-100">Apply</button>
                </div>
            </div>
        </div>
        <!-----------FILTER END------------->
        <div class="row">
            <div class="col-lg-12 col-md-12 order-1">
                <div class="row">
                    <div class="col-2-half mb-4">
                        <a href="{{ route('sica.schooldata') }}">
                            <div class="card">
                                <div class="card-body">
                                    <span class="d-block mb-1 label-bage">Total Schools</span>
                                    <h3 class="card-title text-nowrap mb-2" id="total_schools">
                                        @if (isset($total_Schools) && $total_Schools > 0)
                                            {{ $total_Schools }}
                                        @else
                                            0
                                        @endif
                                    </h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-2-half mb-4">
                        <a href="{{ route('sica.data_verified') }}">
                            <div class="card">
                                <div class="card-body">
                                    <span class="d-block mb-1 label-bage">Total Verified </span>
                                    <h3 class="card-title text-nowrap mb-2" id="total_verified">
                                        @if (isset($total_verified) && $total_verified > 0)
                                            {{ $total_verified }}
                                        @else
                                            0
                                        @endif
                                    </h3>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-2-half mb-4">
                        <a href="{{ route('sica.dataunverified') }}">
                            <div class="card">
                                <div class="card-body">
                                    <span class="d-block mb-1 label-bage">Total Un-Verified </span>
                                    <h3 class="card-title text-nowrap mb-2" id="total_unverified">
                                        @if (isset($totalUnverified) && $totalUnverified > 0)
                                            {{ $totalUnverified }}
                                        @else
                                            0
                                        @endif
                                    </h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-2-half mb-4">
                        <a href="{{ route('sica.datanotsubmitted') }}">
                            <div class="card">
                                <div class="card-body">
                                    <span class="d-block mb-1 label-bage">Data Not Submitted</span>
                                    <h3 class="card-title text-nowrap mb-2" id="total_not_submitted">
                                        @if (isset($totalDatanotsubmitted) && $totalDatanotsubmitted > 0)
                                            {{ $totalDatanotsubmitted }}
                                        @else
                                            0
                                        @endif
                                    </h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-2-half mb-4">
                        <a href="{{ route('sica.data_pending') }}">
                            <div class="card">
                                <div class="card-body">
                                    <span class="d-block mb-1 label-bage">Pending For Review</span>
                                    <h3 class="card-title text-nowrap mb-2" id="pending_review">
                                        @if (isset($totalPendingReview) && $totalPendingReview > 0)
                                            {{ $totalPendingReview }}
                                        @else
                                            0
                                        @endif
                                    </h3>
                                </div>
                            </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Order Statistics -->
            <div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h4 class="m-0 me-2">Verification Statistics</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="orderStatisticsChart"></div>
                    </div>
                </div>
            </div>
            <!--/ Order Statistics -->

            <!-- Expense Overview -->
            <div class="col-md-6 col-lg-6 order-1 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="card-title mb-0">
                            <h4 class="m-0 me-2">School Map</h4>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d27701.41587064758!2d74.28111841899259!3d31.51358092638643!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e0!4m5!1s0x39190382931e3655%3A0x58b2e3b1be62b2f4!2sGovernment%20Pilot%20Secondary%20High%20School%2C%20Wahdat%20Rd%2C%20Asif%20Block%20Allama%20Iqbal%20Town%2C%20Lahore%2C%20Punjab%2C%20Pakistan!3m2!1d31.512222299999998!2d74.3019212!4m5!1s0x39190382931e3655%3A0x58b2e3b1be62b2f4!2sGovernment%20Pilot%20Secondary%20High%20School%2C%20Wahdat%20Rd%2C%20Asif%20Block%20Allama%20Iqbal%20Town%2C%20Lahore%2C%20Punjab%2C%20Pakistan!3m2!1d31.512222299999998!2d74.3019212!5e0!3m2!1sen!2s!4v1712225055502!5m2!1sen!2s"
                            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                        {{-- <div id="map"></div> --}}
                    </div>
                </div>
            </div>
            <!--/ Expense Overview -->
        </div>

    </div>

    <!-- / Content -->
    {{-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=marker"></script> --}}

    {{-- <script src="https://maps.googleapis.com/maps/api/js?libraries=maps&key={{ env('GOOGLE_MAP_KEY') }}&v=weekly&callback=google.maps.__ib__:139"></script> --}}
    <script>
        function fetchDataAndUpdateChart() {
            $.ajax({
                url: '{{ route('sica.dashboard') }}',
                type: 'GET',
                dataType: 'json',
                cache: false, // Disable caching for AJAX request
                success: function(data) {
                    data.total_verified = parseInt(data.total_verified);
                    // Check if unverified data is already a number
                    data.total_unverified = typeof data.total_unverified === 'string' ? parseInt(data
                        .total_unverified.replace(
                            /,/g, '')) : data.total_unverified;
                    data.total_data_not_submitted = parseInt(data.total_data_not_submitted.replace(/,/g, ''));
                    data.total_pending_review = parseInt(data.pending);

                    // Update total counts
                    updateTotalCounts(data);

                    // Update chart data
                    updateChartData(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
        fetchDataAndUpdateChart();
        setInterval(fetchDataAndUpdateChart, 300000);

        // District select change event listener
        document.getElementById('districtSelect').addEventListener('change', function() {
            var districtId = this.value;

            fetch('/sica/get-tehsils/' + districtId, {
                    cache: 'no-store'
                })
                .then(response => response.json())
                .then(data => {
                    var tehsilSelect = document.getElementById('tehsilSelect');

                    // Clear existing options
                    tehsilSelect.innerHTML = '<option value="">Select Tehsil</option>';

                    // Populate tehsil select with fetched tehsils
                    data.forEach(tehsil => {
                        var option = document.createElement('option');
                        option.value = tehsil.tehsil_id;
                        option.textContent = tehsil.tehsil_name;
                        tehsilSelect.appendChild(option);
                    });

                    // Show tehsil select
                    tehsilSelect.style.display = 'block';
                });
        });
        $(document).ready(function() {
            // Function to fetch data and update the Tehsils dropdown
            function fetchTehsilsAndUpdateDropdown(districtId) {
                fetch('/sica/get-tehsils/' + districtId, {
                        cache: 'no-store'
                    })
                    .then(response => response.json())
                    .then(data => {
                        var tehsilSelect = document.getElementById('tehsilSelect');

                        // Clear existing options
                        tehsilSelect.innerHTML = '<option value="">Select Tehsil</option>';

                        // Populate tehsil select with fetched tehsils
                        data.forEach(tehsil => {
                            var option = document.createElement('option');
                            option.value = tehsil.tehsil_id;
                            option.textContent = tehsil.tehsil_name;
                            tehsilSelect.appendChild(option);
                        });

                        // Show tehsil select
                        tehsilSelect.style.display = 'block';
                    });
            }

            // Function to automatically select the district on page load
            function autoSelectDistrict() {
                var districtSelect = document.getElementById('districtSelect');
                var districtId = districtSelect.value;

                // If a district is selected
                if (districtId) {
                    // Fetch and update Tehsils dropdown
                    fetchTehsilsAndUpdateDropdown(districtId);
                }
            }

            // Trigger change event on District dropdown to fetch and update Tehsils dropdown
            autoSelectDistrict();

            // District select change event listener
            document.getElementById('districtSelect').addEventListener('change', function() {
                var districtId = this.value;

                // Fetch and update Tehsils dropdown
                fetchTehsilsAndUpdateDropdown(districtId);
            });
        });
        // Tehsil select change event listener
        document.getElementById('tehsilSelect').addEventListener('change', function() {
            var tehsilId = this.value;

            // Make AJAX request to fetch markez for the selected tehsil
            // Replace 'getMarkezUrl' with your actual route URL to fetch markez
            fetch('/sica/get-markez/' + tehsilId, {
                    cache: 'no-store'
                })
                .then(response => response.json())
                .then(data => {
                    var markezSelect = document.getElementById('markezSelect');

                    // Clear existing options
                    markezSelect.innerHTML = '<option value="">Select Markez</option>';

                    // Populate markez select with fetched markez
                    data.forEach(markez => {
                        var option = document.createElement('option');
                        option.value = markez.m_id;
                        option.textContent = markez.m_name;
                        markezSelect.appendChild(option);
                    });

                    // Show markez select
                    markezSelect.style.display = 'block';
                });
        });
        // Markez select change event listener
        document.getElementById('markezSelect').addEventListener('change', function() {
            var markezId = this.value;

            // Make AJAX request to fetch markez for the selected tehsil
            // Replace 'getMarkezUrl' with your actual route URL to fetch markez
            fetch('/sica/get-schools/' + markezId, {
                    cache: 'no-store'
                })
                .then(response => response.json())
                .then(data => {
                    var schoolsSelect = document.getElementById('schoolsSelect');

                    // Clear existing options
                    schoolsSelect.innerHTML = '<option value="">Select School</option>';

                    // Populate markez select with fetched markez
                    data.forEach(schools => {
                        var option = document.createElement('option');
                        option.value = schools.id;
                        option.textContent = schools.s_emis_code + ' - ' + schools.s_name;
                        schoolsSelect.appendChild(option);
                    });

                    // Show markez select
                    schoolsSelect.style.display = 'block';
                });
        });
        document.getElementById('filter_apply').addEventListener('click', function() {
            var districtId = document.getElementById('districtSelect').value;
            var tehsilId = document.getElementById('tehsilSelect').value;
            var markezId = document.getElementById('markezSelect').value;

            // Show loader
            document.getElementById('blur-background').style.display = 'block';
            document.getElementById('loader').style.display = 'block';

            // Get CSRF token from meta tag
            var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

            // Make AJAX request to fetch data for the selected filters
            fetch('/sica/dashboard-stat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in the headers
                    },
                    body: JSON.stringify({
                        districtId: districtId,
                        tehsilId: tehsilId,
                        markezId: markezId
                    }),
                    cache: 'no-store'
                })
                .then(response => response.json())
                .then(data => {
                    // console.log(data.schools_location, 'schools_location');
                    // Update total counts
                    updateTotalCounts(data);

                    // Update chart data
                    updateChartData(data);
                    
                    //update map
                    initMap(data.schools_location);
                    // Hide loader
                    document.getElementById('loader').style.display = 'none';
                    document.getElementById('blur-background').style.display = 'none';
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Hide loader in case of error
                    document.getElementById('loader').style.display = 'none';
                    document.getElementById('blur-background').style.display = 'none';
                });
        });

        function updateTotalCounts(data) {
            if (data.total_schools) {
                animateValue(document.getElementById('total_schools'), 0, data.total_schools, 1000);
            }
            if (data.total_verified !== undefined) {
                animateValue(document.getElementById('total_verified'), 0, data.total_verified, 1000);
            }
            if (data.total_unverified !== undefined) {
                animateValue(document.getElementById('total_unverified'), 0, data.total_unverified, 1000);
            }
            if (data.total_data_not_submitted) {
                animateValue(document.getElementById('total_not_submitted'), 0, data.total_data_not_submitted, 1000);
            }
            if (data.total_pending_review) {
                animateValue(document.getElementById('pending_review'), 0, data.total_pending_review, 1000);
            }
        }


        function animateValue(obj, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                let value;
                if (end === 0) {
                    value = 0; // Set value to 0 if end value is 0
                } else {
                    value = Math.floor(progress * (end - start) + start);
                }
                obj.textContent = value.toLocaleString();
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        function updateChartData(data) {
            var chart = $('#orderStatisticsChart').highcharts();
            if (chart) {
                chart.series[0].setData([{
                        name: 'Verified',
                        y: data.total_verified,
                        color: '#00a6e3',
                        url: 'data-verified'
                    },
                    {
                        name: 'Un-Verified',
                        y: data.total_unverified,
                        color: '#f9b115',
                        url: 'data-unverified'
                    },
                    {
                        name: 'Not Submitted',
                        y: data.total_data_not_submitted,
                        color: '#f85c50',
                        url: 'data-not-submitted'
                    },
                    {
                        name: 'Pending',
                        y: data.total_pending_review,
                        color: '#4caf50',
                        url: 'data-pending'
                    }
                ]);

                chart.series[0].points.forEach(function(point) {
                    point.graphic.element.setAttribute('style', 'cursor: pointer');
                    point.graphic.element.onclick = function() {
                        window.location.href = point.options.url;
                    };
                });
            }
        }

        function initMap(data) {
            const districts = data;
            
            const districtId = parseInt(document.getElementById('districtSelect').value, 10);
            
            const selectedDistrict = districts.find(district => district.s_district_idFk === districtId);
            console.log(selectedDistrict, 'selectedDistrict');
            let center, zoom;

            // Set center and zoom level based on selected district or default values
            if (selectedDistrict) {
                
                const latitude = parseFloat(selectedDistrict.lat);
                const longitude = parseFloat(selectedDistrict.long);

                if (!isNaN(latitude) && !isNaN(longitude)) {
                    center = {
                        lat: latitude,
                        lng: longitude
                    };
                    zoom = 10;
                } else {
                    center = {
                        lat: 31.1704,
                        lng: 72.7097
                    };
                    zoom = 7;
                }
            } else {
                center = {
                    lat: 31.1704,
                    lng: 72.7097
                };
                zoom = 7;
            }

            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: zoom,
                center: center,
            });

            const markerIcons = {
                "Male Primary": "{{ asset('sica/assets/pins/male-p.png') }}",
                "Male Mosque": "{{ asset('sica/assets/pins/male-p.png') }}",
                "Female Primary": "{{ asset('sica/assets/pins/female-p.png') }}",
                "Male Middle": "{{ asset('sica/assets/pins/male-md.png') }}",
                "Female Middle": "{{ asset('sica/assets/pins/female-md.png') }}",
                "Male High": "{{ asset('sica/assets/pins/male-h.png') }}",
                "Female High": "{{ asset('sica/assets/pins/female-h.png') }}",
                "Male H.Sec.": "{{ asset('sica/assets/pins/male-hs.png') }}",
                "Female H.Sec.": "{{ asset('sica/assets/pins/female-hs.png') }}",
            };

            // Create legends panel
            const legendsPanel = document.createElement('div');
            legendsPanel.classList.add('legends-panel');
            legendsPanel.innerHTML = `
            <div><img src="{{ asset('sica/assets/pins/male-p.png') }}"> Boys Primary</div>
            <div><img src="{{ asset('sica/assets/pins/female-p.png') }}"> Girls Primary</div>
            <div><img src="{{ asset('sica/assets/pins/male-md.png') }}"> Boys Middle</div>
            <div><img src="{{ asset('sica/assets/pins/female-md.png') }}"> Girls Middle</div>
            <div><img src="{{ asset('sica/assets/pins/male-h.png') }}"> Boys High</div>
            <div><img src="{{ asset('sica/assets/pins/female-h.png') }}"> Girls High</div>
            <div><img src="{{ asset('sica/assets/pins/male-hs.png') }}"> Boys H.Sec.</div>
            <div><img src="{{ asset('sica/assets/pins/female-hs.png') }}"> Girls H.Sec.</div>
        `;
            // Append toggle button and legends panel to map
            //map.controls[google.maps.ControlPosition.RIGHT_TOP].push(toggleButton);
            map.controls[google.maps.ControlPosition.RIGHT_TOP].push(legendsPanel);
            // Get schools data passed from the controller
            const schools = districts;
            let openInfoWindow = null;
            // Loop through schools data and add markers to the map
            schools.forEach(function(school) {
                const markerIcon = markerIcons[`${school.s_type} ${school.s_level}`];

                const marker = new google.maps.Marker({
                    position: {
                        lat: parseFloat(school.lat),
                        lng: parseFloat(school.long)
                    },
                    map: map,
                    title: school.s_name,
                    icon: markerIcon
                });

                // Add info window to the marker
                const infoWindow = new google.maps.InfoWindow({
                    content: createInfoWindowContent(school) //adeel un-hide this
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
            return '<div class="school-info-map-wrapper"><table class="table table-bordered table-striped ">' +
                '<tr style="background: #04578f !important;color: #ffffff !important;"><td colspan="4"><h4 class="school-name-heading">' +
                school.emis_code + ' - ' + school.s_name + '</h4></td></tr>' +
                '<tr><td class="school-info-title">District</td><td class="school-info-vaule">' + school.d_name + '</td>' +
                '<td class="school-info-title">Tehsil</td><td class="school-info-vaule">' + school.t_name + '</td></tr>' +
                '<tr><td class="school-info-title">Markaz</td><td class="school-info-vaule">' + school.m_name + '</td>' +
                '<td class="school-info-title">Gender</td><td class="school-info-vaule">' + school.s_type + '</td></tr>' +
                '<tr><td class="school-info-title">Level</td><td class="school-info-vaule">' + school.s_level + '</td>' +
                '<td class="school-info-title">No. of Teachers</td><td class="school-info-vaule">' + school.no_of_teachers +
                '</td></tr>' +
                '<tr><td class="school-info-title">No. of Students</td><td class="school-info-vaule">' + school
                .total_students + '</td>' +
                '<td class="school-info-title">Student to Teacher Ratio (40:1 recommended)</td><td class="school-info-vaule">' +
                (Math.round(school.total_students / school.no_of_teachers) > 40 ? '<span style="color:red;">' + Math.round(
                    school.total_students / school.no_of_teachers) + ':1</span>' : Math.round(school.total_students /
                    school.no_of_teachers) + ':1') + '</td></tr>' +
                '<tr style="background: #04578f !important;color: #ffffff !important;"><td colspan="4"><h4 class="school-facility-heading"> Available Facilities </h4></td></tr>' +
                '<tr><td class="school-info-title">Electricity</td><td class="school-info-vaule">' + (school.electricity ==
                    1 ? 'Yes' : '<span style="color:red;">No</span>') + '</td>' +
                '<td class="school-info-title">Drinking Water</td><td class="school-info-vaule">' + (school.dw == 1 ?
                    'Yes' : '<span style="color:red;">No</span>') + '</td></tr>' +
                '<tr><td class="school-info-title">Toilets</td><td class="school-info-vaule">' + (school.toilet_facility ==
                    1 ? 'Yes (Total: ' + school.total_toilets + ', Usable: ' + school.usable_toilets + ')' :
                    '<span style="color:red;">No</span>') + '</td>' +
                '<td class="school-info-title">Boundary Wall</td><td class="school-info-vaule">' + (school.bw == 1 ? 'Yes' :
                    '<span style="color:red;">No</span>') + '</td></tr>' +
                '<tr><td class="school-info-title">Functional Classrooms</td><td class="school-info-vaule">' + school
                .functional_classrooms + '</td>' +
                '<td class="school-info-title">Science Lab</td><td class="school-info-vaule">' + (school.science_lab == 1 ?
                    'Yes' : '<span style="color:red;">No</span>') + '</td></tr>' +
                '<tr><td class="school-info-title">Library</td><td class="school-info-vaule">' + (school.library == 1 ?
                    'Yes' : '<span style="color:red;">No</span>') + '</td>' +
                '<td class="school-info-title">Computer Lab</td><td class="school-info-vaule">' + (school.computer_lab ==
                    1 ? 'Yes (Functional Computers: ' + school.functional_computers + ')' :
                    '<span style="color:red;">No</span>') + '</td></tr>' +
                '<tr><td class="school-info-title">Play Ground</td><td class="school-info-vaule">' + (school.play_ground ==
                    1 ? 'Yes' : '<span style="color:red;">No</span>') + '</td>' +
                '<td class="school-info-title">Total Area</td><td class="school-info-vaule">' + school.area + '</td></tr>' +
                '</table></div>';
        }

        function attachEventListeners() {
            const legendsPanel = document.createElement('div');
            legendsPanel.classList.add('legends-panel');
            legendsPanel.innerHTML = `
            <div><img src="{{ asset('sica/assets/pins/male-p.png') }}"> Boys Primary</div>
            <div><img src="{{ asset('sica/assets/pins/female-p.png') }}"> Girls Primary</div>
            <div><img src="{{ asset('sica/assets/pins/male-md.png') }}"> Boys Middle</div>
            <div><img src="{{ asset('sica/assets/pins/female-md.png') }}"> Girls Middle</div>
            <div><img src="{{ asset('sica/assets/pins/male-h.png') }}"> Boys High</div>
            <div><img src="{{ asset('sica/assets/pins/female-h.png') }}"> Girls High</div>
            <div><img src="{{ asset('sica/assets/pins/male-hs.png') }}"> Boys H.Sec.</div>
            <div><img src="{{ asset('sica/assets/pins/female-hs.png') }}"> Girls H.Sec.</div>
        `;
            map.controls[google.maps.ControlPosition.RIGHT_TOP].push(legendsPanel);
        }
        window.initMap = initMap;
        window.onload = function() {
            const data = {!! json_encode($getSchoolsLocation) !!};
            initMap(data);
        }
    </script>
    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>
@endsection
