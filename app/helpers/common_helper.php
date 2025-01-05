<?php

// Example helper function
if (!function_exists('formatComplaintNo')) {
     function formatComplaintNo($districtId, $ppId, $complaintNo)
    {
        // Get the last complaint number for the given district and pp_id
        

        // Determine the district part (two digits)
        $districtPart = str_pad($districtId, 2, '0', STR_PAD_LEFT);

        // Determine the pp_id part (three digits)
        $ppIdPart = str_pad($ppId, 3, '0', STR_PAD_LEFT);
        $complaintNoPart = str_pad($complaintNo, 5, '0', STR_PAD_LEFT);

       

        // Formulate the complaint number
        $complaintNo ="{$districtPart}-{$ppIdPart}-{$complaintNoPart}";

        return $complaintNo;
    }
}