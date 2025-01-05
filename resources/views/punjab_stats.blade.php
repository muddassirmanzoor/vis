@extends('layouts.main')
@section('content')
    

	<script>
		Highcharts.setOptions({
			lang: {
				thousandsSep: ','
			}
		});
		jQuery(function ($) {
			$('#library').highcharts({
				chart: {
				type: 'column'
				},
				title: {
					text: 'Two Column Chart with Multiple Categories',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					categories: ['Library'] // Multiple categories
				},
				yAxis: {
					title: {
						text: 'Count'
					}
				},
				plotOptions: {

					column: {
					dataLabels: {
						enabled: true,
						color: "black",
						style: {
						textOutline: false
						}
					}
					}
				},
				series: [{
					name: 'Yes',
					data: [{{ $school_stats[0]->library_1_count }}], // Values for the first column for each category
					color:"#c39f3b"
				}, {
					name: 'No',
					data: [{{ $school_stats[0]->library_0_count }}], // Values for the second column for each category
					color:"#d3d3d3"
				}]
			});
			
			$('#str').highcharts({
				chart: {
					type: 'column' // Change chart type to column
				},
				title: {
					text: 'Student Teacher Ratio', // Change the title to reflect the data
					style: {
						display: 'none'
					}
				},
				xAxis: {
					categories: ['Ratio'] // Change x-axis category label
				},
				yAxis: {
					title: {
						text: 'Ratio (Students : Teacher)' // Change y-axis label
					}
				},
				plotOptions: {
					series: {
						pointPadding: 0.1, // Adjust this value to add padding between bars
						groupPadding: 0.1, // Adjust this value to add padding between groups of bars
					},
					column: { // Use column plot options
						dataLabels: {
							enabled: true,
							color: "black",
							style: {
								textOutline: false
							},
							formatter: function() {
								return Math.round(this.y) + ":1"; // Round the ratio to the nearest whole number
							}
						}
					}
				},
				tooltip: {
					formatter: function() {
						return '<b>' + this.series.name + '</b><br/>' +
							this.x + ': ' + Math.round(this.y) + ':1'; // Include both the ratio and its corresponding data
					}
				},
				series: [{
					name: 'STR',
					data: [{{ round($school_stats[0]->s_t_r) }}], // Rounded values represent the student to teacher ratio
					color: "#c39f3b"
				}]
			});



			$('#csr').highcharts({
				chart: {
					type: 'column' // Change chart type to column
				},
				title: {
					text: 'Class Student Ratio', // Change the title to reflect the data
					style: {
						display: 'none'
					}
				},
				xAxis: {
					categories: ['Ratio'] // Change x-axis category label
				},
				yAxis: {
					title: {
						text: 'Ratio (Student : Class)' // Change y-axis label
					}
				},
				
				plotOptions: {
					series: {
						pointPadding: 0.1, // Adjust this value to add padding between bars
						groupPadding: 0.1, // Adjust this value to add padding between groups of bars
					},
					column: { // Use column plot options
						dataLabels: {
							enabled: true,
							color: "black",
							style: {
								textOutline: false
							},
							formatter: function() {
								return Math.round(this.y) + ":1"; // Round the ratio to the nearest whole number
							}
						}
					}
				},
				tooltip: {
					formatter: function() {
						return '<b>' + this.series.name + '</b><br/>' +
							this.x + ': ' + Math.round(this.y) + ':1'; // Include both the ratio and its corresponding data
					}
				},
				series: [{
					name: 'CSR',
					data: [{{ round($school_stats[0]->s_c_r) }}], // Rounded values represent the student to teacher ratio
					color: "#d3d3d3"
				}]
			});
			$('#playGround').highcharts({
				chart: {
				type: 'column'
				},
				title: {
					text: 'Two Column Chart with Multiple Categories',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					categories: ['Play Grounds'] // Multiple categories
				},
				yAxis: {
					title: {
						text: 'Count'
					}
				},
				plotOptions: {

					column: {
					dataLabels: {
						enabled: true,
						color: "black",
						style: {
						textOutline: false
						}
					}
					}
				},
				series: [{
					name: 'Yes',
					data: [{{ $school_stats[0]->play_ground_1_count }}], // Values for the first column for each category
					color:"#c39f3b"
				}, {
					name: 'No',
					data: [{{ $school_stats[0]->play_ground_0_count }}], // Values for the second column for each category
					color:"#d3d3d3"
				}]
			});
			$('#computerLab').highcharts({
				chart: {
				type: 'column'
				},
				title: {
					text: 'Two Column Chart with Multiple Categories',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					categories: ['Computer Lab'] // Multiple categories
				},
				yAxis: {
					title: {
						text: 'Count'
					}
				},
				plotOptions: {

					column: {
					dataLabels: {
						enabled: true,
						color: "black",
						style: {
						textOutline: false
						}
					}
					}
				},
				series: [{
					name: 'Yes',
					data: [{{ $school_stats[0]->computer_lab_1_count }}], // Values for the first column for each category
					color:"#c39f3b"
				}, {
					name: 'No',
					data: [{{ $school_stats[0]->computer_lab_0_count }}], // Values for the second column for each category
					color:"#d3d3d3"
				}]
			});
			$('#scienceLab').highcharts({
				chart: {
				type: 'column'
				},
				title: {
					text: 'Two Column Chart with Multiple Categories',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					categories: ['Science Lab'] // Multiple categories
				},
				yAxis: {
					title: {
						text: 'Count'
					}
				},
				plotOptions: {

					column: {
					dataLabels: {
						enabled: true,
						color: "black",
						style: {
						textOutline: false
						}
					}
					}
				},
				series: [{
					name: 'Yes',
					data: [{{ $school_stats[0]->science_lab_1_count }}], // Values for the first column for each category
					color:"#c39f3b"
				}, {
					name: 'No',
					data: [{{ $school_stats[0]->science_lab_0_count }}], // Values for the second column for each category
					color:"#d3d3d3"
				}]
			});
			$('#toilet').highcharts({
				chart: {
				type: 'column'
				},
				title: {
					text: 'Two Column Chart with Multiple Categories',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					categories: ['Toilets'] // Multiple categories
				},
				yAxis: {
					title: {
						text: 'Count'
					}
				},
				plotOptions: {

					column: {
					dataLabels: {
						enabled: true,
						color: "black",
						style: {
						textOutline: false
						}
					}
					}
				},
				series: [{
					name: 'Yes',
					data: [{{ $school_stats[0]->toilet_facility_1_count }}], // Values for the first column for each category
					color:"#c39f3b"
				}, {
					name: 'No',
					data: [{{ $school_stats[0]->toilet_facility_0_count }}], // Values for the second column for each category
					color:"#d3d3d3"
				}]
			});
			$('#electricity').highcharts({
				chart: {
				type: 'column'
				},
				title: {
					text: 'Two Column Chart with Multiple Categories',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					categories: ['Electricity'] // Multiple categories
				},
				yAxis: {
					title: {
						text: 'Count'
					}
				},
				plotOptions: {

					column: {
					dataLabels: {
						enabled: true,
						color: "black",
						style: {
						textOutline: false
						}
					}
					}
				},
				series: [{
					name: 'Yes',
					data: [{{ $school_stats[0]->electricity_1_count }}], // Values for the first column for each category
					color:"#c39f3b"
				}, {
					name: 'No',
					data: [{{ $school_stats[0]->electricity_0_null_count }}], // Values for the second column for each category
					color:"#d3d3d3"
				}]
			});
			$('#boundaryWall').highcharts({
				chart: {
				type: 'column'
				},
				title: {
					text: 'Two Column Chart with Multiple Categories',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					categories: ['Boundary Wall'] // Multiple categories
				},
				yAxis: {
					title: {
						text: 'Count'
					}
				},
				plotOptions: {

					column: {
					dataLabels: {
						enabled: true,
						color: "black",
						style: {
						textOutline: false
						}
					}
					}
				},
				series: [{
					name: 'Yes',
					data: [{{ $school_stats[0]->bw_1_count }}], // Values for the first column for each category
					color:"#c39f3b"
				}, {
					name: 'No',
					data: [{{ $school_stats[0]->bw_0_count }}], // Values for the second column for each category
					color:"#d3d3d3"
				}]
			});
			$('#drinkingWater').highcharts({
				chart: {
				type: 'column'
				},
				title: {
					text: 'Two Column Chart with Multiple Categories',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					categories: ['Drinking Water'] // Multiple categories
				},
				yAxis: {
					title: {
						text: 'Count'
					}
				},
				plotOptions: {

					column: {
					dataLabels: {
						enabled: true,
						color: "black",
						style: {
						textOutline: false
						}
					}
					}
				},
				series: [{
					name: 'Yes',
					data: [{{ $school_stats[0]->dw_1_count }}], // Values for the first column for each category
					color:"#c39f3b"
				}, {
					name: 'No',
					data: [{{ $school_stats[0]->dw_0_count }}], // Values for the second column for each category
					color:"#d3d3d3"
				}]
			});
		});
	</script>
	<!----------------------->
	
	@include('includes.header')
  	
 	 <!---------main content area start------------>
	<main>
		<section class="position-relative overflow-hidden text-center bg-light hero-area">
			<div class="row">
				<div class="col-md-12 p-lg-12 mx-auto">
					<h1 class="indicator-heading">Punjab Districts Statistics</h1>
					<p class="indicator-sub-heading">POPULAR INDICATORS</p>
					<ul class="list-inline">
						<li class="list-inline-item indicator-box"><a href="#boundaryWall">Boundary Walls</a></li>
						<li class="list-inline-item indicator-box"><a href="#electricity">Electricity</a></li>	
						<li class="list-inline-item indicator-box"><a href="#drinkingWater">Drinking Water</a></li>
						<li class="list-inline-item indicator-box"><a href="#toilet">Toilet</a></li>
						<li class="list-inline-item indicator-box"><a href="#scienceLab">Science Lab</a></li>
						<li class="list-inline-item indicator-box"><a href="#computerLab">Computer Lab</a></li>	
						<li class="list-inline-item indicator-box"><a href="#library">Library</a></li>
										
						<li class="list-inline-item indicator-box"><a href="#playGround">Play Grounds</a></li>
						<li class="list-inline-item indicator-box"><a href="#str">STR</a></li>
						<li class="list-inline-item indicator-box"><a href="#csr">CSR</a></li>
					</ul>
				</div>	
			</div>
		</section>
		<section class="filter-wrapper">
			<div class="container">
			<form class="filter-action border-radius-xl" action="{{ route('district-comparison') }}" method="POST">
				@csrf
				<div class="row">
					<div class="form-group col-lg-3 col-md-3 mb-2">
						<select id="comparison_type" name="comparison_type" class="w-100 form-control mt-lg-1 mt-md-2 form-select" required>
						
							<option value="district" <?php if($comparison_type == "district") { echo "selected"; } ?>>District Wise Comparison</option>
							<option value="pp" <?php if($comparison_type == "pp") { echo "selected"; } ?>>PP Constituencies Wise Comparison</option>
							<option value="na" <?php if($comparison_type == "na") { echo "selected"; } ?>>NA Constituencies Wise Comparison</option>	
						</select>
					</div>
					<div class="form-group col-lg-3 col-md-3 mb-2">
						<select id="dropdown1" name="dropdown1" class="w-100 form-control mt-lg-1 mt-md-2 form-select" required>
						<option value="">Select First District</option>
							<!-- Populate options dynamically from database -->
							@foreach($districts as $district)
								<option value="{{ $district->s_district_idFk }}" <?php if($district1 == $district->s_district_idFk) { echo "selected"; } ?>>{{ $district->d_name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-lg-3 col-md-3  mb-2">
						<select id="dropdown2" name="dropdown2" class="w-100 form-control mt-lg-1 mt-md-2 form-select" required>
						<option value="">Select Second District</option>
							<!-- Populate options dynamically from database -->
							@foreach($districts as $district)
								<option value="{{ $district->s_district_idFk }}" <?php if($district2 == $district->s_district_idFk) { echo "selected"; } ?>>{{ $district->d_name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-xl-3 col-lg-3 col-md-6  mb-2 align-self-center">
						<button type="submit" class="btn btn-primary active w-100" style="background: #28416f;border: 0px;margin-top: 4px;float:right;">Comparison</button>
					</div>
				</div><!---Row End----->
			</form>
			</section>
			<section class="demographic-wrapper">
			<div class="container">	
				<div class="row mt-4 mb-4 after-hero-box-row"> <!----Row Start----->
					<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
						<div class="card">
							<div class="card-header p-3 pt-2">
								<div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
								<i class="material-icons opacity-10"><img class="demographic-icon" src="./assets/images/school.png" alt="Generic placeholder image" width="60" height="auto"></i>
								</div>
								<div class="text-end pt-1">
									<p class="text-sm mb-0 text-capitalize">Total Schools</p>
									<h4 class="mb-0">{{ $school_stats[0]->total_schools }}</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
						<div class="card">
							<div class="card-header p-3 pt-2">
								<div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
								<i class="material-icons opacity-10"><img class="demographic-icon" src="./assets/images/enrollment.png" alt="Generic placeholder image" width="60" height="auto"></i>
								</div>
								<div class="text-end pt-1">
									<p class="text-sm mb-0 text-capitalize">Total Enrollment</p>
									<h4 class="mb-0">{{ $school_stats[0]->t_students }}</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
						<div class="card">
							<div class="card-header p-3 pt-2">
								<div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
								<i class="material-icons opacity-10"><img class="demographic-icon" src="./assets/images/teacher.png" alt="Generic placeholder image" width="60" height="auto"></i>
								</div>
								<div class="text-end pt-1">
									<p class="text-sm mb-0 text-capitalize">Total Teachers</p>
									<h4 class="mb-0">{{ $school_stats[0]->total_teachers }}</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
						<div class="card">
							<div class="card-header p-3 pt-2">
								<div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
								<i class="material-icons opacity-10"><img class="demographic-icon" src="./assets/images/classroom.png" alt="Generic placeholder image" width="60" height="auto"></i>
								</div>
								<div class="text-end pt-1">
									<p class="text-sm mb-0 text-capitalize">Total Class Rooms</p>
									<h4 class="mb-0">{{ $school_stats[0]->total_classrooms }}</h4>
								</div>
							</div>
						</div>
					</div>
				</div><!----Row End----->			
				<div class="row mt-4 mb-4"><!----Row Star----->
					
					<div class="col-xl-3 col-lg-3 col-md-6 mb-4">
						<div class="card" href="#Boundary-Walls-link">				 
							<div class="card-header">					
								<h5 class="card-title"><span class="ml-1"><img src="./assets/images/boundary-wall.png" class="card-img-top card-image" alt="..."></span><span class="indicator-label"> Boundary Wall</span></h5>
							</div>
							<div class="card-body">
								<div id="boundaryWall" style="height:300px"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 mb-4">
						<div class="card" href="#content">				 
							<div class="card-header">					
								<h5 class="card-title"><span class="ml-1"><img src="./assets/images/bulb.png" class="card-img-top card-image" alt="..."></span><span class="indicator-label">  Electricity</span></h5>
							</div>
							<div class="card-body">
								<div id="electricity" style="height:300px"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 mb-4">
						<div class="card">				 
							<div class="card-header">					
								<h5 class="card-title"><span class="ml-1"><img src="./assets/images/glass-of-water.png" class="card-img-top card-image" alt="..."></span><span class="indicator-label">  Drinking Water</span></h5>
							</div>
							<div class="card-body">
								<div id="drinkingWater" style="height:300px"></div>
							</div>
						</div>
					</div>
					
					<div class="col-xl-3 col-lg-3 col-md-6 mb-4">
						<div class="card">				 
							<div class="card-header">					
								<h5 class="card-title"><span class="ml-1"><img src="./assets/images/toilet.png" class="card-img-top card-image" alt="..."></span><span class="indicator-label">  Toilet</span></h5>
							</div>
							<div class="card-body">
								<div id="toilet" style="height:300px"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-6 mb-4">
						<div class="card">				 
							<div class="card-header">					
								<h5 class="card-title"><span class="ml-1"><img src="./assets/images/science-lab.png" class="card-img-top card-image" alt="..."></span><span class="indicator-label">  Science Lab</span></h5>
							</div>
							<div class="card-body">
								<div id="scienceLab" style="height:300px"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-6 mb-4">
						<div class="card">				 
							<div class="card-header">					
								<h5 class="card-title"><span class="ml-1"><img src="./assets/images/computer-lab.jpg" class="card-img-top card-image" alt="..."></span><span class="indicator-label">  Computer Lab</span></h5>
							</div>
							<div class="card-body">
								<div id="computerLab" style="height:300px"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-6 mb-4">
						<div class="card">				 
							<div class="card-header">					
								<h5 class="card-title"><span class="ml-1"><img src="./assets/images/library.png" class="card-img-top card-image" alt="..."></span><span class="indicator-label">  Library</span></h5>
							</div>
							<div class="card-body">
								<div id="library" style="height:300px"></div>
							</div>
						</div>
					</div>
					<!--------Ratio Graph Start---------->
					<div class="col-xl-4 col-lg-4 col-md-6 mb-4">
						<div class="card">				 
							<div class="card-header">					
								<h5 class="card-title"><span class="ml-1"><img src="./assets/images/playground.png" class="card-img-top card-image" alt="..."></span><span class="indicator-label">  Play Grounds</span></h5>
							</div>
							<div class="card-body">
								<div id="playGround" style="height:300px"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-6 mb-4">
						<div class="card">				 
							<div class="card-header">					
								<h5 class="card-title"><span class="ml-1"><img src="./assets/images/str.png" class="card-img-top card-image" alt="..."></span><span class="indicator-label">  Student Teacher Ratio</span></h5>
							</div>
							<div class="card-body">
								<div id="str" style="height:300px"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-6 mb-4">
						<div class="card">				 
							<div class="card-header">					
								<h5 class="card-title"><span class="ml-1"><img src="./assets/images/csr.png" class="card-img-top card-image" alt="..."></span><span class="indicator-label">  Class Student Ratio</span></h5>
							</div>
							<div class="card-body">
								<div id="csr" style="height:300px"></div>
							</div>
						</div>
					</div>
					<!--------Ratio Graph END---------->		
				</div><!----Row End----->
			</div>
		</section>
	</main>
  	


  	<script src="{{ asset('/assets/dist/js/bootstrap.bundle.min.js') }}"></script>
	<script>
		document.getElementById("comparison_type").addEventListener("change", function() {
			const comparisonType = this.value;
			$.ajax({
				url: "/get-comparison-dropdown",
				type: "GET",
				data: { comparison_type: comparisonType, _token: '{{ csrf_token() }}' },
				success: function(data) {
					// Define function to populate dropdowns
					console.log(data);
				
					if (comparisonType == 'district') {
						$("#dropdown1").html('<option value="">Select First District</option>');
						$.each(data, function(key, value) {
							console.log(value);
							$("#dropdown1").append('<option value="' + value.s_district_idFk + '" >' + value.d_name + '</option>');

						});
						$("#dropdown2").html('<option value="">Select Second District</option>');
						$.each(data, function(key, value) {
							console.log(value);
							$("#dropdown2").append('<option value="' + value.s_district_idFk + '"  >' + value.d_name + '</option>');

						});
					} else if (comparisonType == 'pp') {
						$("#dropdown1").html('<option value="">Select First PP Constituency</option>');
						$.each(data, function(key, value) {
							console.log(value);
							$("#dropdown1").append('<option value="' + value.pp_no + '"  >' + value.pp_seat + '</option>');

						});
						$("#dropdown2").html('<option value="">Select Second PP Constituency</option>');
						$.each(data, function(key, value) {
							console.log(value);
							$("#dropdown2").append('<option value="' + value.pp_no + '" >' + value.pp_seat + '</option>');

						});
					} else if (comparisonType == 'na') {
						$("#dropdown1").html('<option value="">Select First NA Constituency</option>');
						$.each(data, function(key, value) {
							console.log(value);
							$("#dropdown1").append('<option value="' + value.na_no + '" >' + value.na_seat + '</option>');

						});
						$("#dropdown2").html('<option value="">Select Second NA Constituency</option>');
						$.each(data, function(key, value) {
							console.log(value);
							$("#dropdown2").append('<option value="' + value.na_no + '" >' + value.na_seat + '</option>');

						});
					}
					

					// Populate tehsil dropdown with fetched tehsils based on comparisonType
					
				}
			});
		});

	</script>


 @endsection
