<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Complaint;

class ComplaintController extends Controller
{
    public function showForm()
    {
        $districts = DB::table('districts')
        ->select('district_id as s_district_idFk', 'district_name as d_name', 'lat', 'long')
        ->get();
        return view('complaints.complaint-add', compact('districts') );
    }
    public function getPPSeats(Request $request)
    {   
        // Fetch tehsils based on the selected district
        $districtId = $request->input('district_id');
     //   return response()->json($districtId);
        if($districtId){
            \DB::statement("SET SQL_MODE=''");
            $pp_seat =  DB::table('school_info')
            ->select('pp_no', 'pp_seat')
            ->groupBy('pp_no')
            ->orderBy('pp_no','asc')
            ->where('pp_no', '!=', 0)
            ->where('pp_seat', '!=', '0')
            ->where('s_district_idFk', $districtId)
            ->get();
        }else{
            \DB::statement("SET SQL_MODE=''");
            $pp_seat =  DB::table('school_info')
            ->select('pp_no', 'pp_seat')
            ->groupBy('pp_no')
            ->orderBy('pp_no','asc')
            ->where('pp_no', '!=', 0)
            ->where('pp_seat', '!=', '0')
            ->get();
        }
       
        

        // Return tehsils as JSON response
        return response()->json($pp_seat);
    }


    public function storeComplaints(Request $request)
    {
        // dd($request->input());
        // exit;
        // Validate the form data
        $validatedData = $request->validate([
            'district' => 'required',
            'pp_id' => 'required',
            'school_id' => 'required',
            'mpa_name' => 'required',
            'issue_category' => 'required',
            'issue_details' => 'required',
           
        ]);

        // If 'Others' issue selected, validate 'otherIssue' field
        if ($request->issue_category == 'Others') {
            $validatedData['issue_category_other'] = $request->input('issue_category_other');
        }
        $validatedData['created_by'] = Auth::id();
        $validatedData['created_at'] = now();

        $districtId = $validatedData['district'];
        $ppId = $validatedData['pp_id'];
        $validatedData['complaint_no'] = $this->generateComplaintNo($districtId, $ppId);
        $complaintNo = $validatedData['complaint_no']; 
        // dd( $validatedData['complaint_no']);
        // exit;
        Complaint::create($validatedData);

        $formattedComplaintNo = formatComplaintNo($districtId, $ppId, $complaintNo);
        

        // Redirect back to the form with a success message
        return redirect()->route('complaint.form')->with('success', 'Complaint ' . $formattedComplaintNo . ' submitted successfully!');
    }

    public function generateComplaintNo($districtId, $ppId)
    {
        // Get the last complaint number for the given district and pp_id
        $lastComplaint = Complaint::where('district', $districtId)
            ->where('pp_id', $ppId)
            ->orderBy('id', 'desc')
            ->first();

        // Determine the district part (two digits)
        //$districtPart = str_pad($districtId, 2, '0', STR_PAD_LEFT);

        // Determine the pp_id part (three digits)
        //$ppIdPart = str_pad($ppId, 3, '0', STR_PAD_LEFT);

        // Determine the complaint number part (incremental within district and pp_id)
        if ($lastComplaint) {
            $lastComplaintNo = $lastComplaint->complaint_no;
            //$lastNumber = intval(substr($lastComplaintNo, 6)); // Extract last 5 digits and convert to integer
            $nextNumber = $lastComplaintNo + 1;//str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = 1; // Starting number if no previous complaint exists
        }

        // Formulate the complaint number
        $complaintNo = $nextNumber;//"{$districtPart}-{$ppIdPart}-{$nextNumber}";

        return $complaintNo;
    }

    
    public function complaintList(){
        $user = Auth::user();
        if($user->role=='Support'){
            $complaints = DB::table('support_complaints')
            ->select('support_complaints.*', 'school_info.s_name','school_info.d_name','school_info.s_emis_code', 'school_info.pp_seat')
            ->join('school_info', 'support_complaints.school_id', '=', 'school_info.id')
            ->whereNotNull('support_complaints.pp_id') // Adjust as per your conditions
            ->get();
            // dd($complaints);
            // exit;
        }
        return view('complaints.complaint-listing', compact('complaints') );
    }

    public function updateComplaint(Request $request, $complaint_id)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'action' => 'required',
            'action_remarks' => 'required',
           
        ]);

        // If 'Others' issue selected, validate 'issue_category_other' field
       

        // Update additional data
        $validatedData['updated_by'] = Auth::id();
        $validatedData['updated_at'] = now();

       
        //exit;

        // Update the complaint
        $complaint = Complaint::findOrFail($complaint_id);
        
        $complaint->update($validatedData);

        // Redirect back to the form with a success message
        return redirect()->route('complaint.list')->with('success', 'Complaint updated successfully!');
    }
    public function viewComplaint($complaint_id)
    {
        // Find the complaint by its ID
       // $complaint = Complaint::findOrFail($complaint_id);
        $complaint = DB::table('support_complaints')
            ->select('support_complaints.*', 'school_info.s_name','school_info.d_name','school_info.s_emis_code', 'school_info.pp_seat')
            ->join('school_info', 'support_complaints.school_id', '=', 'school_info.id')
            ->whereNotNull('support_complaints.pp_id')
            ->where('support_complaints.id', $complaint_id) // Adjust as per your conditions
            ->first();
        //dd($complaint);
        // You can optionally load related data if needed
        // $complaint->load('related_model');

        // Return a view to display the complaint details
        return view('complaints.complaint-detail', compact('complaint'));
    }

}
