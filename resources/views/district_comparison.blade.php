@extends('layouts.main')
@section('content')
    

	<script>
	jQuery(function ($) {
			$('#library').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: 'No of library',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					type: 'category',
					labels: {
						autoRotation: [-45, -90],
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'No. of Libraries'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: 'No. of Libraries: <b>{point.y:.1f} %</b>'
				},
				series: [{
					name: 'District',
					colors: ['#c39f3b', '#d3d3d3'],
					colorByPoint: true,
					groupPadding: 0,
					data: [
						
						@if($comparison_type == 'district')
							['{{ $stat_1[0]->district_name }}', {{ $stat_1[0]->library_1_percentage }}],
							['{{ $stat_2[0]->district_name }}', {{ $stat_2[0]->library_1_percentage }}],
						@elseif($comparison_type == 'pp')
							['{{ $stat_1[0]->pp_seat }}', {{ $stat_1[0]->library_1_percentage }}],
							['{{ $stat_2[0]->pp_seat }}', {{ $stat_2[0]->library_1_percentage }}],
						@elseif($comparison_type == 'na')
							['{{ $stat_1[0]->na_seat }}', {{ $stat_1[0]->library_1_percentage }}],
							['{{ $stat_2[0]->na_seat }}', {{ $stat_2[0]->library_1_percentage }}],
						@endif
					],
					dataLabels: {
						enabled: true,
						color: '#000000',
						inside: true,
						verticalAlign: 'top',
						formatter: function() {
							return this.y.toFixed(1) + '%'; // Round to one decimal point
						},
						y: -20, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif',
							textOutline: false
						}
					}
				}]
			});
			$('#computerLab').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: 'No. of Computer Labs',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					type: 'category',
					labels: {
						autoRotation: [-45, -90],
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'No. of Computer Labs'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: 'No. of Computer Labs: <b>{point.y:.1f}%</b>'
				},
				series: [{
					name: 'District',
					colors: ['#c39f3b', '#d3d3d3'],
					colorByPoint: true,
					groupPadding: 0,
					data: [
						@if($comparison_type == 'district')
							['{{ $stat_1[0]->district_name }}', {{ $stat_1[0]->computer_lab_1_percentage }}],
							['{{ $stat_2[0]->district_name }}', {{ $stat_2[0]->computer_lab_1_percentage }}],
						@elseif($comparison_type == 'pp')
							['{{ $stat_1[0]->pp_seat }}', {{ $stat_1[0]->computer_lab_1_percentage }}],
							['{{ $stat_2[0]->pp_seat }}', {{ $stat_2[0]->computer_lab_1_percentage }}],
						@elseif($comparison_type == 'na')
							['{{ $stat_1[0]->na_seat }}', {{ $stat_1[0]->computer_lab_1_percentage }}],
							['{{ $stat_2[0]->na_seat }}', {{ $stat_2[0]->computer_lab_1_percentage }}],
						@endif
						
					],
					dataLabels: {
						enabled: true,
						color: '#000000',
						inside: true,
						verticalAlign: 'top',
						formatter: function() {
							return this.y.toFixed(1) + '%'; // Round to one decimal point
						},
						y: -20, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif',
							textOutline: false
						}
					}
				}]
			});
			$('#scienceLab').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: 'No. of Science Labs',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					type: 'category',
					labels: {
						autoRotation: [-45, -90],
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'No. of Science Labs'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: 'No. of Science Labs: <b>{point.y:.1f}%</b>'
				},
				series: [{
					name: 'District',
					colors: ['#c39f3b', '#d3d3d3'],
					colorByPoint: true,
					groupPadding: 0,
					data: [
						@if($comparison_type == 'district')
							['{{ $stat_1[0]->district_name }}', {{ $stat_1[0]->science_lab_1_percentage }}],
							['{{ $stat_2[0]->district_name }}', {{ $stat_2[0]->science_lab_1_percentage }}],
						@elseif($comparison_type == 'pp')
							['{{ $stat_1[0]->pp_seat }}', {{ $stat_1[0]->science_lab_1_percentage }}],
							['{{ $stat_2[0]->pp_seat }}', {{ $stat_2[0]->science_lab_1_percentage }}],
						@elseif($comparison_type == 'na')
							['{{ $stat_1[0]->na_seat }}', {{ $stat_1[0]->science_lab_1_percentage }}],
							['{{ $stat_2[0]->na_seat }}', {{ $stat_2[0]->science_lab_1_percentage }}],
						@endif
						
					],
					dataLabels: {
						enabled: true,
						color: '#000000',
						inside: true,
						verticalAlign: 'top',
						formatter: function() {
							return this.y.toFixed(1) + '%'; // Round to one decimal point
						},
						y: -20, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif',
							textOutline: false
						}
					}
				}]
			});
			$('#toilet').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: 'No of Toilet',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					type: 'category',
					labels: {
						autoRotation: [-45, -90],
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'No. of Toilets'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: 'No. of Toilets: <b>{point.y:.1f}%</b>'
				},
				series: [{
					name: 'District',
					colors: ['#c39f3b', '#d3d3d3'],
					colorByPoint: true,
					groupPadding: 0,
					data: [
						@if($comparison_type == 'district')
							['{{ $stat_1[0]->district_name }}', {{ $stat_1[0]->toilet_facility_1_percentage }}],
							['{{ $stat_2[0]->district_name }}', {{ $stat_2[0]->toilet_facility_1_percentage }}],
						@elseif($comparison_type == 'pp')
							['{{ $stat_1[0]->pp_seat }}', {{ $stat_1[0]->toilet_facility_1_percentage }}],
							['{{ $stat_2[0]->pp_seat }}', {{ $stat_2[0]->toilet_facility_1_percentage }}],
						@elseif($comparison_type == 'na')
							['{{ $stat_1[0]->na_seat }}', {{ $stat_1[0]->toilet_facility_1_percentage }}],
							['{{ $stat_2[0]->na_seat }}', {{ $stat_2[0]->toilet_facility_1_percentage }}],
						@endif
					
					],
					dataLabels: {
						enabled: true,
						color: '#000000',
						inside: true,
						verticalAlign: 'top',
						formatter: function() {
							return this.y.toFixed(1) + '%'; // Round to one decimal point
						},
						y: -20, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif',
							textOutline: false
						}
					}
				}]
			});
			$('#electricity').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: 'Electricity',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					type: 'category',
					labels: {
						autoRotation: [-45, -90],
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Electricity'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: 'Electricity: <b>{point.y:.1f}%</b>'
				},
				series: [{
					name: 'District',
					colors: ['#c39f3b', '#d3d3d3'],
					colorByPoint: true,
					groupPadding: 0,
					data: [
						@if($comparison_type == 'district')
							['{{ $stat_1[0]->district_name }}', {{ $stat_1[0]->electricity_1_percentage }}],
							['{{ $stat_2[0]->district_name }}', {{ $stat_2[0]->electricity_1_percentage }}],
						@elseif($comparison_type == 'pp')
							['{{ $stat_1[0]->pp_seat }}', {{ $stat_1[0]->electricity_1_percentage }}],
							['{{ $stat_2[0]->pp_seat }}', {{ $stat_2[0]->electricity_1_percentage }}],
						@elseif($comparison_type == 'na')
							['{{ $stat_1[0]->na_seat }}', {{ $stat_1[0]->electricity_1_percentage }}],
							['{{ $stat_2[0]->na_seat }}', {{ $stat_2[0]->electricity_1_percentage }}],
						@endif
					
					],
					dataLabels: {
						enabled: true,
						color: '#000000',
						inside: true,
						verticalAlign: 'top',
						formatter: function() {
							return this.y.toFixed(1) + '%'; // Round to one decimal point
						},
						y: -20, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif',
							textOutline: false
						}
					}
				}]
			});
			$('#boundaryWall').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: 'Boundary Walls',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					type: 'category',
					labels: {
						autoRotation: [-45, -90],
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Boundary Walls'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: 'Boundary Walls: <b>{point.y:.1f}%</b>'
				},
				series: [{
					name: 'District',
					colors: ['#c39f3b', '#d3d3d3'],
					colorByPoint: true,
					groupPadding: 0,
					data: [
						@if($comparison_type == 'district')
							['{{ $stat_1[0]->district_name }}', {{ $stat_1[0]->bw_1_percentage }}],
							['{{ $stat_2[0]->district_name }}', {{ $stat_2[0]->bw_1_percentage }}],
						@elseif($comparison_type == 'pp')
							['{{ $stat_1[0]->pp_seat }}', {{ $stat_1[0]->bw_1_percentage }}],
							['{{ $stat_2[0]->pp_seat }}', {{ $stat_2[0]->bw_1_percentage }}],
						@elseif($comparison_type == 'na')
							['{{ $stat_1[0]->na_seat }}', {{ $stat_1[0]->bw_1_percentage }}],
							['{{ $stat_2[0]->na_seat }}', {{ $stat_2[0]->bw_1_percentage }}],
						@endif
						
					],
					dataLabels: {
						enabled: true,
						color: '#000000',
						inside: true,
						verticalAlign: 'top',
						formatter: function() {
							return this.y.toFixed(1) + '%'; // Round to one decimal point
						},
						y: -20, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif',
							textOutline: false
						}
					}
				}]
			});
			$('#drinkingWater').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: 'Drinking Water',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					type: 'category',
					labels: {
						autoRotation: [-45, -90],
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Drinking Water'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: 'Drinking Water: <b>{point.y:.1f}%</b>'
				},
				series: [{
					name: 'District',
					colors: ['#c39f3b', '#d3d3d3'],
					colorByPoint: true,
					groupPadding: 0,
					data: [
						@if($comparison_type == 'district')
							['{{ $stat_1[0]->district_name }}', {{ $stat_1[0]->dw_1_percentage }}],
							['{{ $stat_2[0]->district_name }}', {{ $stat_2[0]->dw_1_percentage }}],
						@elseif($comparison_type == 'pp')
							['{{ $stat_1[0]->pp_seat }}', {{ $stat_1[0]->dw_1_percentage }}],
							['{{ $stat_2[0]->pp_seat }}', {{ $stat_2[0]->dw_1_percentage }}],
						@elseif($comparison_type == 'na')
							['{{ $stat_1[0]->na_seat }}', {{ $stat_1[0]->dw_1_percentage }}],
							['{{ $stat_2[0]->na_seat }}', {{ $stat_2[0]->dw_1_percentage }}],
						@endif
						
					],
					dataLabels: {
						enabled: true,
						color: '#000000',
						inside: true,
						verticalAlign: 'top',
						formatter: function() {
							return this.y.toFixed(1) + '%'; // Round to one decimal point
						},
						y: -20, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif',
							textOutline: false
						}
					}
				}]
			});
			$('#str').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: 'Student Teacher Ratio',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					type: 'category',
					labels: {
						autoRotation: [-45, -90],
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Student Teacher Ratio'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: 'Student Teacher Ratio: <b>{point.y:.0f}:1</b>'
				},
				series: [{
					name: 'District',
					colors: ['#c39f3b', '#d3d3d3'],
					colorByPoint: true,
					groupPadding: 0,
					data: [
						@if($comparison_type == 'district')
							['{{ $stat_1[0]->district_name }}', {{ $stat_1[0]->s_t_r }}],
							['{{ $stat_2[0]->district_name }}', {{ $stat_2[0]->s_t_r }}],
						@elseif($comparison_type == 'pp')
							['{{ $stat_1[0]->pp_seat }}', {{ $stat_1[0]->s_t_r }}],
							['{{ $stat_2[0]->pp_seat }}', {{ $stat_2[0]->s_t_r }}],
						@elseif($comparison_type == 'na')
							['{{ $stat_1[0]->na_seat }}', {{ $stat_1[0]->s_t_r }}],
							['{{ $stat_2[0]->na_seat }}', {{ $stat_2[0]->s_t_r }}],
						@endif
						
					],
					dataLabels: {
						enabled: true,
						color: '#000000',
						inside: true,
						verticalAlign: 'top',
						format: '{point.y:.0f}:1', // one decimal
						y: -20, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif',
							textOutline: false
						}
					}
				}]
			});
			$('#csr').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: 'Class Student Ratio',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					type: 'category',
					labels: {
						autoRotation: [-45, -90],
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Class Student Ratio'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: 'Class Student Ratio: <b>{point.y:.0f}:1</b>'
				},
				series: [{
					name: 'District',
					colors: ['#c39f3b', '#d3d3d3'],
					colorByPoint: true,
					groupPadding: 0,
					data: [
						@if($comparison_type == 'district')
							['{{ $stat_1[0]->district_name }}', {{ $stat_1[0]->s_c_r }}],
							['{{ $stat_2[0]->district_name }}', {{ $stat_2[0]->s_c_r }}],
						@elseif($comparison_type == 'pp')
							['{{ $stat_1[0]->pp_seat }}', {{ $stat_1[0]->s_c_r }}],
							['{{ $stat_2[0]->pp_seat }}', {{ $stat_2[0]->s_c_r }}],
						@elseif($comparison_type == 'na')
							['{{ $stat_1[0]->na_seat }}', {{ $stat_1[0]->s_c_r }}],
							['{{ $stat_2[0]->na_seat }}', {{ $stat_2[0]->s_c_r }}],
						@endif
					
					],
					dataLabels: {
						enabled: true,
						color: '#000000',
						inside: true,
						verticalAlign: 'top',
						format: '{point.y:.0f}:1', // one decimal
						y: -20, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif',
							textOutline: false
						}
					}
				}]
			});
			$('#playGround').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: 'Play Grounds',
					style: {
						display: 'none'
					}
				},
				xAxis: {
					type: 'category',
					labels: {
						autoRotation: [-45, -90],
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Play Grounds'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: 'Play Grounds: <b>{point.y:.1f}%</b>'
				},
				series: [{
					name: 'District',
					colors: ['#c39f3b', '#d3d3d3'],
					colorByPoint: true,
					groupPadding: 0,
					data: [
						@if($comparison_type == 'district')
							['{{ $stat_1[0]->district_name }}', {{ $stat_1[0]->play_ground_1_percentage }}],
							['{{ $stat_2[0]->district_name }}', {{ $stat_2[0]->play_ground_1_percentage }}],
						@elseif($comparison_type == 'pp')
							['{{ $stat_1[0]->pp_seat }}', {{ $stat_1[0]->play_ground_1_percentage }}],
							['{{ $stat_2[0]->pp_seat }}', {{ $stat_2[0]->play_ground_1_percentage }}],
						@elseif($comparison_type == 'na')
							['{{ $stat_1[0]->na_seat }}', {{ $stat_1[0]->play_ground_1_percentage }}],
							['{{ $stat_2[0]->na_seat }}', {{ $stat_2[0]->play_ground_1_percentage }}],
						@endif
						
					],
					dataLabels: {
						enabled: true,
						color: '#000000',
						inside: true,
						verticalAlign: 'top',
						formatter: function() {
							return this.y.toFixed(1) + '%'; // Round to one decimal point
						},
						y: -20, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif',
							textOutline: false
						}
					}
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
				<h1 class="indicator-heading">Punjab Districts Comparison</h1>
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
						@if($comparison_type=='district')
						<option value="">Select First District</option>
							<!-- Populate options dynamically from database -->
							@foreach($districts as $district)
								<option value="{{ $district->s_district_idFk }}" <?php if($dropdown1 == $district->s_district_idFk) { echo "selected"; } ?>>{{ $district->d_name }}</option>
							@endforeach
						@elseif($comparison_type=='pp')
							<option value="">Select First PP Constituency</option>
								<!-- Populate options dynamically from database -->
								@foreach($pps as $pp)
									<option value="{{ $pp->pp_no }}" <?php if($dropdown1 == $pp->pp_no) { echo "selected"; } ?>>{{ $pp->pp_seat }}</option>
								@endforeach
						@elseif($comparison_type=='na')
							<option value="">Select First NA Constituency</option>
								<!-- Populate options dynamically from database -->
								@foreach($nas as $na)
									<option value="{{ $na->na_no }}" <?php if($dropdown1 == $na->na_no) { echo "selected"; } ?>>{{ $na->na_seat }}</option>
								@endforeach
						@endif
						</select>
					</div>
					<div class="form-group col-lg-3 col-md-3  mb-2">
						<select id="dropdown2" name="dropdown2" class="w-100 form-control mt-lg-1 mt-md-2 form-select" required>
						@if($comparison_type=='district')
						<option value="">Select Second District</option>
							<!-- Populate options dynamically from database -->
							@foreach($districts as $district)
								<option value="{{ $district->s_district_idFk }}" <?php if($dropdown2 == $district->s_district_idFk) { echo "selected"; } ?>>{{ $district->d_name }}</option>
							@endforeach
						@elseif($comparison_type=='pp')
							<option value="">Select Second PP Constituency</option>
								<!-- Populate options dynamically from database -->
								@foreach($pps as $pp)
									<option value="{{ $pp->pp_no }}" <?php if($dropdown2 == $pp->pp_no) { echo "selected"; } ?>>{{ $pp->pp_seat }}</option>
								@endforeach
						@elseif($comparison_type=='na')
							<option value="">Select Second NA Constituency</option>
								<!-- Populate options dynamically from database -->
								@foreach($nas as $na)
									<option value="{{ $na->na_no }}" <?php if($dropdown2 == $na->na_no) { echo "selected"; } ?>>{{ $na->na_seat }}</option>
								@endforeach
						@endif
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
								@if($comparison_type == 'district')
									<h4 class="mb-0 district-label-name">{{ ucwords(strtolower($stat_1[0]->district_name)) }}: {{ $stat_1[0]->total_schools }}</h4>
									<h4 class="mb-0 district-label-name">{{ ucwords(strtolower($stat_2[0]->district_name)) }}: {{ $stat_2[0]->total_schools }}</h4>
								@elseif($comparison_type == 'pp')
									<h4 class="mb-0 district-label-name">{{ $stat_1[0]->pp_seat }}: {{ $stat_1[0]->total_schools }}</h4>
									<h4 class="mb-0 district-label-name">{{ $stat_2[0]->pp_seat }}: {{ $stat_2[0]->total_schools }}</h4>
								@elseif($comparison_type == 'na')
									<h4 class="mb-0 district-label-name">{{ $stat_1[0]->na_seat }}: {{ $stat_1[0]->total_schools }}</h4>
									<h4 class="mb-0 district-label-name">{{ $stat_2[0]->na_seat }}: {{ $stat_2[0]->total_schools }}</h4>
								@endif
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
								@if($comparison_type == 'district')
									<h4 class="mb-0 district-label-name">{{  ucwords(strtolower($stat_1[0]->district_name)) }}: {{ $stat_1[0]->t_students }}</h4>
									<h4 class="mb-0 district-label-name">{{  ucwords(strtolower($stat_2[0]->district_name)) }}: {{ $stat_2[0]->t_students }}</h4>
								@elseif($comparison_type == 'pp')
									<h4 class="mb-0 district-label-name">{{  $stat_1[0]->pp_seat }}: {{ $stat_1[0]->t_students }}</h4>
									<h4 class="mb-0 district-label-name">{{  $stat_2[0]->pp_seat }}: {{ $stat_2[0]->t_students }}</h4>
								@elseif($comparison_type == 'na')
									<h4 class="mb-0 district-label-name">{{  $stat_1[0]->na_seat }}: {{ $stat_1[0]->t_students }}</h4>
									<h4 class="mb-0 district-label-name">{{  $stat_2[0]->na_seat }}: {{ $stat_2[0]->t_students }}</h4>
								@endif
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
								
								@if($comparison_type == 'district')
									<h4 class="mb-0 district-label-name">{{  ucwords(strtolower($stat_1[0]->district_name)) }}: {{ $stat_1[0]->total_teachers }}</h4>
									<h4 class="mb-0 district-label-name">{{  ucwords(strtolower($stat_2[0]->district_name)) }}: {{ $stat_2[0]->total_teachers }}</h4>
								@elseif($comparison_type == 'pp')
									<h4 class="mb-0 district-label-name">{{  $stat_1[0]->pp_seat }}: {{ $stat_1[0]->total_teachers }}</h4>
									<h4 class="mb-0 district-label-name">{{  $stat_2[0]->pp_seat }}: {{ $stat_2[0]->total_teachers }}</h4>
								@elseif($comparison_type == 'na')
									<h4 class="mb-0 district-label-name">{{  $stat_1[0]->na_seat }}: {{ $stat_1[0]->total_teachers }}</h4>
									<h4 class="mb-0 district-label-name">{{  $stat_2[0]->na_seat }}: {{ $stat_2[0]->total_teachers }}</h4>
								@endif
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
								@if($comparison_type == 'district')
									<h4 class="mb-0 district-label-name">{{  ucwords(strtolower($stat_1[0]->district_name)) }}: {{ $stat_1[0]->total_classrooms }}</h4>
									<h4 class="mb-0 district-label-name">{{  ucwords(strtolower($stat_2[0]->district_name)) }}: {{ $stat_2[0]->total_classrooms }}</h4>
								@elseif($comparison_type == 'pp')
									<h4 class="mb-0 district-label-name">{{  $stat_1[0]->pp_seat }}: {{ $stat_1[0]->total_classrooms }}</h4>
									<h4 class="mb-0 district-label-name">{{  $stat_2[0]->pp_seat }}: {{ $stat_2[0]->total_classrooms }}</h4>
								@elseif($comparison_type == 'na')
									<h4 class="mb-0 district-label-name">{{  $stat_1[0]->na_seat }}: {{ $stat_1[0]->total_classrooms }}</h4>
									<h4 class="mb-0 district-label-name">{{  $stat_2[0]->na_seat }}: {{ $stat_2[0]->total_classrooms }}</h4>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div><!----Row End----->			
			<div class="row mt-4 mb-4"><!----Row Star----->				
				<div class="col-xl-6 col-lg-6 col-md-6 mb-4">
					<div class="card">				 
						<div class="card-header">					
						<h5 class="card-title">
							<span class="ml-1">
								<img src="./assets/images/count-teacher-icon.png" class="card-img-top card-image" alt="...">
							</span>
							<span class="indicator-label">
								School Count Teachers wise in 
								@if($comparison_type == 'district')
									{{ ucwords(strtolower($stat_1[0]->district_name)) }}
								@elseif($comparison_type == 'pp')
									{{ $stat_1[0]->pp_seat }}
								@elseif($comparison_type == 'na')
									{{ $stat_1[0]->na_seat }}
								@endif
							</span>
						</h5>
						</div>
						<div class="card-body">
							<div class="row"><!----Row Star----->				
								<!-- <div class="col-md-12"><div class="count-teacter-wrapper"><div class="batch-icon-label">> 3 Teachers</div><div class="batch-icon-bg">800</div><div class="teacher-image"><img class="teacher-image-placeholder" src="./assets/images/yes-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/yes-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/yes-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/yes-teacher-icon.svg"></div></div></div> -->
								<div class="col-md-12">
									<a href="{{ $comparison_type == 'district' ? url('/teachers-school-wise/' . $dropdown1 . '/more') : '#' }}" class="count-teacter-wrapper">
										<div class="batch-icon-label">More than two Teachers</div>
										<div class="batch-icon-bg">{{ $stat_1[0]->more_than_two_teachers }}</div>
										<div class="teacher-image">
											<img class="teacher-image-placeholder" src="./assets/images/yes-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/yes-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/yes-teacher-icon.svg">
											<span>{{ $stat_1[0]->more_than_two_teachers_enrollments }}</span>
										</div>
										<div class=""></div>
									</a>
								</div>
								<div class="col-md-12">
									<a href="{{ $comparison_type == 'district' ? url('/teachers-school-wise/' . $dropdown1 . '/two') : '#' }}" class="count-teacter-wrapper">
										<div class="batch-icon-label">Two Teachers</div>
										<div class="batch-icon-bg">{{ $stat_1[0]->two_teachers }}</div>
										<div class="teacher-image">
											<img class="teacher-image-placeholder" src="./assets/images/yes-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/yes-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/no-teacher-icon.svg">
											<span>{{ $stat_1[0]->two_teachers_enrollments }}</span>
										</div>
										
									</a>
								</div>
								<div class="col-md-12">
									<a href="{{ $comparison_type == 'district' ? url('/teachers-school-wise/' . $dropdown1 . '/one') : '#' }}" class="count-teacter-wrapper">
										<div class="batch-icon-label">One Teacher</div>
										<div class="batch-icon-bg">{{ $stat_1[0]->one_teacher }}</div>
										<div class="teacher-image">
											<img class="teacher-image-placeholder" src="./assets/images/yes-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/no-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/no-teacher-icon.svg">
											<span>{{ $stat_1[0]->one_teacher_enrollments }}</span>
										</div>
										
									</a>
								</div>
								<div class="col-md-12">
									<a href="{{ $comparison_type == 'district' ? url('/teachers-school-wise/' . $dropdown1 . '/zero') : '#' }}" class="count-teacter-wrapper">
										<div class="batch-icon-label">Zero Teacher</div>
										<div class="batch-icon-bg">{{ $stat_1[0]->zero_teacher }}</div>
										<div class="teacher-image">
											<img class="teacher-image-placeholder" src="./assets/images/no-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/no-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/no-teacher-icon.svg">
											<span>{{ $stat_1[0]->zero_teacher_enrollments }}</span>
										</div>
										
									</a>
								</div>

							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 mb-4">
					<div class="card">				 
						<div class="card-header">					
							<h5 class="card-title">
								<span class="ml-1">
									<img src="./assets/images/count-teacher-icon.png" class="card-img-top card-image" alt="...">
								</span>
								<span class="indicator-label">
									School Count Teachers wise in 
									@if($comparison_type == 'district')
										{{ ucwords(strtolower($stat_2[0]->district_name)) }}
									@elseif($comparison_type == 'pp')
										{{ $stat_2[0]->pp_seat }}
									@elseif($comparison_type == 'na')
										{{ $stat_2[0]->na_seat }}
									@endif
								</span>
							</h5>
						</div>
						<div class="card-body">
							<div class="row"><!----Row Star----->				
							<div class="col-md-12">
									<a href="{{ $comparison_type == 'district' ? url('/teachers-school-wise/' . $dropdown2 . '/more') : '#' }}" class="count-teacter-wrapper">
										<div class="batch-icon-label">More than two Teachers</div>
										<div class="batch-icon-bg">{{ $stat_2[0]->more_than_two_teachers }}</div>
										<div class="teacher-image">
											<img class="teacher-image-placeholder" src="./assets/images/yes-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/yes-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/yes-teacher-icon.svg">
											<span >{{ $stat_2[0]->more_than_two_teachers_enrollments }}</span >
										</div>
										
									</a>
								</div>
								<div class="col-md-12">
									<a href="{{ $comparison_type == 'district' ? url('/teachers-school-wise/' . $dropdown2 . '/two') : '#' }}" class="count-teacter-wrapper">
										<div class="batch-icon-label">Two Teachers</div>
										<div class="batch-icon-bg">{{ $stat_2[0]->two_teachers }}</div>
										<div class="teacher-image">
											<img class="teacher-image-placeholder" src="./assets/images/yes-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/yes-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/no-teacher-icon.svg">
											<span >{{ $stat_2[0]->two_teachers_enrollments }}</span>
										</div>
										
									</a>
								</div>
								<div class="col-md-12">
									<a href="{{ $comparison_type == 'district' ? url('/teachers-school-wise/' . $dropdown2 . '/one') : '#' }}" class="count-teacter-wrapper">
										<div class="batch-icon-label">One Teacher</div>
										<div class="batch-icon-bg">{{ $stat_2[0]->one_teacher }}</div>
										<div class="teacher-image">
											<img class="teacher-image-placeholder" src="./assets/images/yes-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/no-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/no-teacher-icon.svg">
											<span>{{ $stat_2[0]->one_teacher_enrollments }}</span>
										</div>
										
									</a>
								</div>
								<div class="col-md-12">
									<a href="{{ $comparison_type == 'district' ? url('/teachers-school-wise/' . $dropdown2 . '/zero') : '#' }}" class="count-teacter-wrapper">
										<div class="batch-icon-label">Zero Teacher</div>
										<div class="batch-icon-bg">{{ $stat_2[0]->zero_teacher }}</div>
										<div class="teacher-image">
											<img class="teacher-image-placeholder" src="./assets/images/no-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/no-teacher-icon.svg"><img class="teacher-image-placeholder" src="./assets/images/no-teacher-icon.svg">
											<span >{{ $stat_2[0]->zero_teacher_enrollments }}</span>
										</div>
										
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-4">
					<div class="card">				 
						<div class="card-header">					
							<h5 class="card-title"><span class="ml-1"><img src="./assets/images/boundary-wall.png" class="card-img-top card-image" alt="..."></span> <span class="indicator-label"> Boundary Wall</span></h5>
						</div>
						<div class="card-body">
							<div id="boundaryWall" style="height:300px"></div>
						</div>
					</div>
				</div>	
				
				<div class="col-xl-3 col-lg-3 col-md-6 mb-4">
					<div class="card">				 
						<div class="card-header">					
							<h5 class="card-title"><span class="ml-1"><img src="./assets/images/bulb.png" class="card-img-top card-image" alt="..."></span> <span class="indicator-label"> Electricity</span></h5>
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
							<h5 class="card-title"><span class="ml-1"><img src="./assets/images/computer-lab.jpg" class="card-img-top card-image" alt="..."></span> <span class="indicator-label"> Computer Lab</span></h5>
						</div>
						<div class="card-body">
							<div id="computerLab" style="height:300px"></div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-6 mb-4">
					<div class="card">				 
						<div class="card-header">					
							<h5 class="card-title"><span class="ml-1"><img src="./assets/images/library.png" class="card-img-top card-image" alt="..."></span> <span class="indicator-label"> Library</span></h5>
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
							<h5 class="card-title"><span class="ml-1"><img src="./assets/images/playground.png" class="card-img-top card-image" alt="..."></span> <span class="indicator-label"> Play Ground</span></h5>
						</div>
						<div class="card-body">
							<div id="playGround" style="height:300px"></div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-6 mb-4">
					<div class="card">				 
						<div class="card-header">					
							<h5 class="card-title"><span class="ml-1"><img src="./assets/images/str.png" class="card-img-top card-image" alt="..."></span> <span class="indicator-label"> Student Teacher Ratio</span></h5>
						</div>
						<div class="card-body">
							<div id="str" style="height:300px"></div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-6 mb-4">
					<div class="card">				 
						<div class="card-header" >					
							<h5 class="card-title"><span class="ml-1"><img src="./assets/images/csr.png" class="card-img-top card-image" alt="..."></span> <span class="indicator-label"> Class Student Ratio</span></h5>
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
