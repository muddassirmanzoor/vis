@extends('layouts.main')
@section('content')
    
    
  @include('includes.header')

  <main>
		
	<section class="position-relative overflow-hidden text-center bg-light hero-area  mb-3">
		<div class="col-md-12 p-lg-12">
			<h3 class="page-heading pt-3">Complaint Form</h3>
		</div>		
    </section class="mb-3">
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-12 p-lg-12">
				@if (session('success'))
					<div class="alert alert-success">
						{{ session('success') }}
					</div>
				@endif
				<form method="POST" action="{{ route('complaint.submit') }}">
						@csrf
						<div class="row">				
							<div  class="col-md-6">
								<div class="form-group">
									
									<label class="control-label font-weight-bold  my-2" for="inputPP">District <sup>*</sup></label>
                                    <select class="form-select" id="district" name="district" required >
                                        <option value="">Select District</option>
                                        <!-- Populate options dynamically from database -->
                                        @foreach($districts as $district)
                                        
                                            <option value="{{ $district->s_district_idFk }}" >{{ $district->d_name }}</option>
                                        @endforeach
                                    </select>
								</div>
							</div>	
							<div  class="col-md-6">
								<div class="form-group">
								<label class="control-label font-weight-bold  my-2" for="inputPP">PP Seat<sup>*</sup></label>				  
									<select class="form-select select2-w-100"  id="pp_seat" name="pp_id" style="width: 100%;">
									<option value="">Select PP</option>
                                            
                                    </select>
								</div>
							</div>				
							<div  class="col-md-6">
								<div class="form-group">
								<label class="control-label font-weight-bold my-2" for="inputSchool">School EMIS Code <sup>*</sup></label>				  
									<select class="form-select select2-w-100"  id="school" name="school_id" style="width: 100%;">
										
									</select>
								</div>				
							</div>				
										
							<div  class="col-md-6">				
								<div class="form-group">
									<label class="control-label font-weight-bold  my-2" for="inputMPAName">MPA Name <sup>*</sup></label>
									<input type="text" class="form-control"  name="mpa_name"  id="inputMPAName" placeholder="Enter Name" required>		
								</div>				
							</div>				
							<div  class="col-md-6">				
								<div class="form-group">
								<label class="control-label font-weight-bold  my-2" for="inputIssue">Select Issue <sup>*</sup></label>				  
								<select id="inputIssue" class="form-control"  name="issue_category" required>
									<option selected>Choose School Issue</option>
									<option  value="Missing School Facility">Missing School Facility</option>
									<option  value="Available Teacher">Available Teacher</option>
									<option  value="Issue in school List">Issue in school List</option>
									<option  value="Others">Others</option>
								</select>
								</div>				
							</div>
				
							<div  class="col-md-6 option-content hidden" id="Others">				
								<div class="form-group">
									<label class="control-label font-weight-bold  my-2" for="inputOtherIssue">Other Issue</label>
									<input type="text" class="form-control"  name="issue_category_other"  id="inputOtherIssue" placeholder="Please specify">		
								</div>				
							</div>					
							<div  class="col-md-12">				
								<div class="form-group">
								<label class="control-label font-weight-bold  my-2" for="inputDetail">Provide Detail</label>				  
								<textarea  id="issue_details" class="form-control"  name="issue_details"  rows="5" required></textarea>
								</div>
							</div> 			
							<div  class="col-md-6 mt-2 mb-3">					
								<button type="submit" class="btn btn-primary active w-30" style="background: #28416f;border: 0px;margin-top: 4px;float:right;">Submit</button>
							</div>
						</div>
					</form>
				</div>				
			</div>
		</div>

    </section>

  </main>
 



    <script src="./assets/dist/js/bootstrap.bundle.min.js"></script>
	<script>
		$(document).ready(function() {
			//$('#pp_seat').select2();
			$('#school').select2();
			
			
		});
		document.getElementById('inputIssue').addEventListener('change', function() {
			console.log("we are in it");
			var selectedOption = this.value;
			var optionContents = document.querySelectorAll('.option-content');

			optionContents.forEach(function(content) {
			if (content.id === selectedOption) {
				content.classList.remove('hidden');
			} else {
				content.classList.add('hidden');
			}
			});
		});

		document.getElementById("pp_seat").addEventListener("change", function() {
            const ppId = this.value;
            // Enable markaz dropdown
            

            // Fetch markazes based on selected tehsil using AJAX
            $.ajax({
                url: "/get-schools-ajax",
                type: "POST",
                data: { pp_id: ppId, _token: '{{ csrf_token() }}' },
                success: function(data) {
                    // Populate markaz dropdown with fetched markazes
                    $("#school").html('<option value="">Select School</option>');
                    $.each(data, function(key, value) {
                        $("#school").append('<option value="' + value.id + '" >' + value.s_emis_code + ' || ' + value.s_name +'</option>');
                    });
                }
            });
        });
		document.getElementById("district").addEventListener("change", function() {
           
		   const districtId = this.value;
		   

		   $.ajax({
			   url: "/fetch-pp-seats",
			   type: "POST",
			   data: { district_id: districtId, _token: '{{ csrf_token() }}' },
			   success: function(data) {
				   // Populate tehsil dropdown with fetched tehsils
				   
				   $("#pp_seat").html('<option value="">Select PP</option>');
				   $.each(data, function(key, value) {
					   console.log(value);
					   $("#pp_seat").append('<option value="' + value.pp_no + '" >' + value.pp_seat + '</option>');

				   });
			   }
		   });

		  




	   });
	
	</script>
      
 @endsection
