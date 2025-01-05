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
				<form method="POST" action="{{ route('complaint.update', ['complaint_id' => $complaint->id]) }}">
						@csrf
						<div class="row">				
							<div  class="col-md-6">
								<div class="form-group">
									
									<label class="control-label font-weight-bold  my-2" for="inputPP">Complaint No.</label>
                                    <input type="text" class="form-control"  name="complaint_no"  id="complaint_no" value="{{ formatComplaintNo($complaint->district, $complaint->pp_id, $complaint->complaint_no) }}" readonly>
								</div>
							</div>
							<div  class="col-md-6">
								<div class="form-group">
									
									<label class="control-label font-weight-bold  my-2" for="inputPP">District</label>
                                    <input type="text" class="form-control"  name="district"  id="district" value="{{ $complaint->d_name }}" readonly>
								</div>
							</div>	
							<div  class="col-md-6">
								<div class="form-group">
								<label class="control-label font-weight-bold  my-2" for="inputPP">PP Seat</label>
								<input type="text" class="form-control"  name="pp_id"  id="pp_seat" value="{{ $complaint->pp_seat }}" readonly>
								</div>
							</div>				
							<div  class="col-md-6">
								<div class="form-group">
								<label class="control-label font-weight-bold my-2" for="inputSchool">School </label>	
								<input type="text" class="form-control"  name="school_id"  id="school" value="{{ $complaint->s_emis_code }} || {{ $complaint->s_name }}"  readonly>			  
									
								</div>				
							</div>				
							
							

							<div  class="col-md-6">				
								<div class="form-group">
									<label class="control-label font-weight-bold  my-2" for="inputMPAName">MPA Name <sup>*</sup></label>
									<input type="text" class="form-control"  name="mpa_name"  id="inputMPAName"  value="{{ $complaint->mpa_name }}" readonly>		
								</div>				
							</div>				
							<div  class="col-md-6">				
								<div class="form-group">
								<label class="control-label font-weight-bold  my-2" for="inputIssue">Select Issue <sup>*</sup></label>				  
								<input type="text" class="form-control"  name="issue_category"  id="inputIssue" value="{{ $complaint->issue_category }}" readonly>
								
								</div>				
							</div>
							@if( $complaint->issue_category=='Others')
							<div  class="col-md-6 option-content hidden" id="Others">				
								<div class="form-group">
									<label class="control-label font-weight-bold  my-2" for="inputOtherIssue">Other Issue</label>
									<input type="text" class="form-control"  name="issue_category_other"  id="inputOtherIssue" value="{{ $complaint->issue_category_other }}"  readonly>		
								</div>				
							</div>	
							@endif				
							<div  class="col-md-12">				
								<div class="form-group">
								<label class="control-label font-weight-bold  my-2" for="inputDetail">Provide Detail</label>				  
								<textarea  id="issue_details" class="form-control"  name="issue_details"   rows="5" readonly>{{ $complaint->issue_details }}</textarea>
								</div>
							</div>
							<div class="col-md-6 option-content" id="action">
								<div class="form-group">
									<label class="control-label font-weight-bold my-2" for="inputAction">Action</label>				  
									<select id="inputAction" name="action" class="form-control" {{ $complaint->action == 'Resolved' ? 'disabled' : 'required' }}>
										<option value="" selected>Choose...</option>
										<option value="Pending" {{ $complaint->action == 'Pending' ? 'selected' : '' }}>Pending</option>
										<option value="Resolved" {{ $complaint->action == 'Resolved' ? 'selected' : '' }}>Resolved</option>
									</select>		
								</div>				
							</div>					

							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label font-weight-bold my-2" for="inputRemarks">Remarks</label>				  
									<textarea id="inputRemarks" name="action_remarks" class="form-control" rows="5" placeholder="Add remarks here" {{ $complaint->action == 'Resolved' ? 'readonly' : '' }}>{{ $complaint->action_remarks }}</textarea>
								</div>
							</div>
							
							<div  class="col-md-6 mt-2 mb-3">	
							@if($complaint->action == 'Pending')				
								<button type="submit" class="btn btn-primary active w-30" style="background: #28416f;border: 0px;margin-top: 4px;float:right;">Submit</button>
								@endif
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
			//console.log("we are in it");
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
