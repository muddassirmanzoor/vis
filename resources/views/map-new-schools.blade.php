@extends('layouts.main')
@section('content')
       
    <!----------------------->
    
   
    @include('includes.header')
     <!--------------------->

    <main >
		<section class="position-relative overflow-hidden text-center bg-light hero-area-map">
            <div class="row">
                <div class="col-md-12 p-lg-12 mx-auto">
                    <h1 class="indicator-heading">Punjab Schools : New SNE Schools</h1>
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
                    <form id="filterForm" method="POST" action="{{ route('get-sne-schools') }}">
                        @csrf
                        <div class="row">
                                <div class="col-md-2 mb-2">
                                    <label for="District" class="form-label">District</label>
                                    <select class="form-select" id="district" name="district" >
                                        <option value="">All Punjab</option>
                                        <!-- Populate options dynamically from database -->
                                        @foreach($districts as $district)
                                        
                                            <option value="{{ $district->d_name }}" <?php if($districtId == $district->d_name) { echo "selected"; } ?>>{{ $district->d_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                
                                <div class="col-md-12 text-right">
                            
                                <button class="btn btn-primary mb-2" type="submit" style="background: #28416f;border: 0px;margin-top: 10px;float:right;">Submit</button> 
                                <a href="{{ url('show-map-sne') }}" class="btn btn-danger mb-2 mr-3" style="border: 0px;margin-top: 10px;float:right;margin-right: 10px;">Reset </a>
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


        const markerIcons = {
        'Male Primary': '/img/pins/male-p.png',
        'MALE PRIMARY': '/img/pins/male-p.png',
        'MALE ELEMENTARY': '/img/pins/male-md.png',
        'Male sMosque': '/img/pins/male-p.png',
        'Female Primary': '/img/pins/female-p.png',
        'FEMALE PRIMARY': '/img/pins/female-p.png',
        'FEMALE ELEMENTARY': '/img/pins/female-md.png',
        'Male Middle': '/img/pins/male-md.png',
        'Female Middle': '/img/pins/female-md.png',
        'Male High': '/img/pins/male-h.png',
        'MALE HIGH': '/img/pins/male-h.png',
        'Female High': '/img/pins/female-h.png',
        'FEMALE HIGH': '/img/pins/female-h.png',
        'Male H.Sec.': '/img/pins/male-hs.png',
        'Female H.Sec.': '/img/pins/female-hs.png',
        'MALE H.Sec.': '/img/pins/male-hs.png',
        'FEMAL H.Sec.': '/img/pins/female-hs.png',
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
                            '<table class="table table-bordered table-striped ">' +
                            '<tr style="background-color: #c5e0ff !important;" ><td colspan="4"><h4 style="text-align:center !important; padding-top:10px;padding-bottom:10px; border-bottom: 2px solid #04578f; color: #04578f;font-weight:bold;" class="school-name-heading">'+   school.s_name + '</h4></td></tr>' +
                            '<tr><td class="school-info-title">District</td><td class="school-info-vaule">' + school.d_name + '</td></tr>' +
                            '<tr><td class="school-info-title">Tehsil</td><td class="school-info-vaule">' + school.t_name + '</td></tr>' +
                            '<tr><td class="school-info-title">Gender</td><td class="school-info-vaule">' + school.s_type + '</td></tr>' +
                            '<tr><td class="school-info-title">Level</td><td class="school-info-vaule">' + school.s_level + '</td></tr>' +
                            '<tr><td class="school-info-title">No Of Rooms</td><td class="school-info-vaule">' + school.s_no_of_rooms + '</td></tr>' +
                           
                           
                           
                           '<tr style="background-color: #c5e0ff !important;"><td colspan="4"><h4 style="text-align:center !important; padding-top:10px;padding-bottom:10px; border-bottom: 2px solid #04578f; color: #04578f;" class="school-facility-heading"><a href="/school/images/' + school.id + '">View Images</a></h4></td></tr>' +
           
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
    
</script>
      
@endsection
