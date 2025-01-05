@extends('layouts.main')
@section('content')
    
    
  @include('includes.header')


<main>
		
	<section class="position-relative overflow-hidden text-center bg-light hero-area  mb-3">
		<div class="col-md-12 p-lg-12">
			<h3 class="page-heading">Constituency Wise Complaints of School</h3>
		</div>		
    </section class="mb-3">
	<section>
		<div class="col-12">
				@if (session('success'))
					<div class="alert alert-success">
						{{ session('success') }}
					</div>
				@endif
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th scope="col">Sr.No</th>
							<th scope="col">Complaint No</th>							
							<th scope="col">District</th>
							<th scope="col">PP</th>
							<th scope="col">MPA Name</th>
							<th scope="col">EMIS Code</th>
							<th scope="col">School Name</th>
							<th scope="col">Complaint Type</th>
							<th scope="col">Status</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						
						@foreach ($complaints as $index => $complaint)
							<tr>
								<td>{{ $index + 1 }}</td>
								<td>{{ formatComplaintNo($complaint->district,$complaint->pp_id, $complaint->complaint_no) }}</td>
								<td>{{ $complaint->d_name }}</td>
								<td>{{ $complaint->pp_seat }}</td>
								<td>{{ $complaint->mpa_name }}</td>
								<td>{{ $complaint->s_emis_code }}</td>
								<td>{{ $complaint->s_name }}</td>
								<td>{{ $complaint->issue_category }}</td>
								<td>{{ $complaint->action }}</td>
								<td class="text-center">
									<a href="{{ route('complaint.view', ['complaint_id' => $complaint->id]) }}" class="table-cta-btn">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="16" height="16">
											<path d="M572.5 241.4C518.3 135.6 410.9 64 288 64S57.7 135.6 3.5 241.4a32.4 32.4 0 0 0 0 29.2C57.7 376.4 165.1 448 288 448s230.3-71.6 284.5-177.4a32.4 32.4 0 0 0 0-29.2zM288 400a144 144 0 1 1 144-144 143.9 143.9 0 0 1 -144 144zm0-240a95.3 95.3 0 0 0 -25.3 3.8 47.9 47.9 0 0 1 -66.9 66.9A95.8 95.8 0 1 0 288 160z"/>
										</svg>
									</a>
								</td>
							</tr>
						@endforeach
																
					</tbody>
				</table>
			</div>
		</div>			
    </section>

  </main>
  


    <script src="./assets/dist/js/bootstrap.bundle.min.js"></script>
	<script>
		function openNav() {
		  document.getElementById("mySidenav").style.width = "250px";
		}
		
		function closeNav() {
		  document.getElementById("mySidenav").style.width = "0";
		}
		window.onscroll = function() {myFunction()};

		var header = document.getElementById("myHeader");
		var sticky = header.offsetTop;

		function myFunction() {
		if (window.pageYOffset > sticky) {
			header.classList.add("sticky");
		} else {
			header.classList.remove("sticky");
		}
		}
		/******************************/
	
	</script>
@endsection
