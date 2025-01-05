<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MapController extends Controller
{
    public function index()
    {
        $districts = DB::table('districts')
        ->select('district_id as s_district_idFk', 'district_name as d_name', 'lat', 'long')
        ->get();
        $districtId = 17; //default lahore
        $schools =DB::table('school_info as si')
        ->select('si.id', 'si.s_emis_code', 'si.s_name', 'si.d_name', 'si.t_name', 'si.m_name', 'si.s_district_idFk', 'si.s_tehsil_idFk', 'si.s_markaz_idFk', 'si.s_lat',
          'si.s_lng', 'si.s_type', 'si.s_level', 'si.no_of_teachers', 'si.total_students', 'si.electricity', 'si.dw', 'si.toilet_facility', 'si.bw', 'si.functional_classrooms',
          'si.computer_lab', 'si.science_lab', 'si.functional_computers', 'si.library', 'si.total_toilets', 'si.usable_toilets', 'si.play_ground','si.pp_seat','si.na_seat','sity.*', DB::raw("
            CASE
                WHEN (si.total_area_kanal > 0 AND si.total_area_marla > 0) THEN CONCAT(CAST(si.total_area_kanal AS CHAR), ' kanal & ', CAST(si.total_area_marla AS CHAR), ' marla')
                WHEN (si.total_area_kanal > 0 AND si.total_area_marla = 0) THEN CONCAT(CAST(si.total_area_kanal AS CHAR), ' kanal')
                WHEN (si.total_area_kanal = 0 AND si.total_area_marla > 0) THEN CONCAT(CAST(si.total_area_marla AS CHAR), ' marla')
                ELSE 'NA'
            END
         as area"))
         ->join('school_info_three_years as sity', 'si.s_emis_code', '=', 'sity.emis_code')
         ->where('si.s_lat', '!=', "")
         ->where('si.s_district_idFk', $districtId )
         ->get();

        //  $sql = $schools->toSql();

        //  // Get the bindings used in the query
        //          $bindings = $schools->getBindings();

        //          // Combine the SQL query and the bindings to form the complete query string
        //          $queryString = vsprintf(str_replace('?', '%s', $sql), collect($bindings)->map(function ($binding) {
        //              return is_numeric($binding) ? $binding : "'{$binding}'";
        //          })->toArray());

        //          // Now you can output the complete query string with bindings replaced
        //          dd($queryString);

       // dd($schools);
        //exit;
        $tehsilId = '';
        $markazId = '';
        $schoolId = '';
        $s_type = '';
        $s_level = '';
        $teachers = '';
        $project = '';
        \DB::statement("SET SQL_MODE=''");
        $pp_seat =  DB::table('school_info')
                    ->select('pp_no', 'pp_seat')
                    ->groupBy('pp_no')
                    ->where('pp_no', '!=', 0)
                    ->where('pp_seat', '!=', '0')
                    ->where('s_district_idFk', $districtId)
                    ->get();

        $ppId = '';
        $na_seat = DB::table('school_info')
                    ->select('na_no', 'na_seat')
                    ->groupBy('na_no')
                    ->where('na_no', '!=', 0)
                    ->where('na_seat', '!=', '0')
                    ->where('s_district_idFk', $districtId)
                    ->get();
       // dd($na_seat);
        $naId = '';
        $districtName = DB::table('districts')
        ->select('district_name')
        ->where('district_id', $districtId)
        ->first();
        $tehsilName = '';
        $markazName = '';
        $PPName = '';
        $NAName = '';
        $schoolName = '';

        $tehsils = DB::table('tehsils')
        ->select('tehsil_id as s_tehsil_idFk', 'tehsil_name as t_name')
        ->where('s_district_idFk', $districtId)
        ->get();
        $markazes = '';
        return view('map', compact('districts','tehsils','markazes', 'schools', 'districtId','teachers','project','markazId','schoolId','tehsilId','s_type','s_level', 'districtName', 'tehsilName',  'markazName', 'PPName', 'NAName', 'schoolName', 'pp_seat','ppId', 'na_seat', 'naId'));
    }

    public function getTehsils(Request $request)
    {
        // Fetch tehsils based on the selected district
        $districtId = $request->input('district_id');
        $tehsils = DB::table('tehsils')
            ->select('tehsil_id as s_tehsil_idFk', 'tehsil_name as t_name')
            ->where('s_district_idFk', $districtId)
            ->get();


        // Return tehsils as JSON response
        return response()->json($tehsils);
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

    public function getNASeats(Request $request)
    {
        // Fetch tehsils based on the selected district
        $districtId = $request->input('district_id');

        if($districtId){
            \DB::statement("SET SQL_MODE=''");
            $na_seat = DB::table('school_info')
                        ->select('na_no', 'na_seat')
                        ->groupBy('na_no')
                        ->orderBy('na_no','asc')
                        ->where('na_no', '!=', 0)
                        ->where('na_seat', '!=', '0')
                        ->where('s_district_idFk', $districtId)
                        ->get();
        }else{
            \DB::statement("SET SQL_MODE=''");
            $na_seat = DB::table('school_info')
                        ->select('na_no', 'na_seat')
                        ->groupBy('na_no')
                        ->orderBy('na_no','asc')
                        ->where('na_no', '!=', 0)
                        ->where('na_seat', '!=', '0')
                        ->get();
        }

        // Return tehsils as JSON response
        return response()->json($na_seat);
    }

    public function getMarkazes(Request $request)
    {
        // Fetch markazes based on the selected tehsil
        $tehsilId = $request->input('tehsil_id');
        $markazes = DB::table('markazes')
        ->select('m_id as s_markaz_idFk', 'm_name')
        ->where('m_tehsil_idFk', $tehsilId)->where('m_status', 1)
       ->get();

        // Return markazes as JSON response
        return response()->json($markazes);
    }
    public function getSchools(Request $request)
    {

        // Fetch schools with latitude and longitude data based on filters (if any)
        $districtId = $request->input('district');
        $tehsilId = $request->input('tehsil');
        $markazId = $request->input('markaz');
        $s_level = $request->input('s_level');
        $s_type = $request->input('s_type');
        $teachers = $request->input('teachers');
        $schoolId = $request->input('school');
        $project = $request->input('project');
        $ppId = $request->input('pp_seat');
        $naId = $request->input('na_seat');
       // dd($request->input());


        $query = DB::table('school_info as si')
        ->select('si.id', 'si.s_emis_code', 'si.s_name', 'si.d_name', 'si.t_name', 'si.m_name', 'si.s_district_idFk', 'si.s_tehsil_idFk', 'si.s_markaz_idFk', 'si.s_lat',
          'si.s_lng', 'si.s_type', 'si.s_level', 'si.no_of_teachers', 'si.total_students', 'si.electricity', 'si.dw', 'si.toilet_facility', 'si.bw', 'si.functional_classrooms',
          'si.computer_lab', 'si.science_lab', 'si.functional_computers', 'si.library', 'si.total_toilets', 'si.usable_toilets', 'si.play_ground','si.pp_seat','si.na_seat','si.is_phcip','si.is_asp','si.is_ece', 'sity.*', DB::raw("
            CASE
                WHEN (si.total_area_kanal > 0 AND si.total_area_marla > 0) THEN CONCAT(CAST(si.total_area_kanal AS CHAR), ' kanal & ', CAST(si.total_area_marla AS CHAR), ' marla')
                WHEN (si.total_area_kanal > 0 AND si.total_area_marla = 0) THEN CONCAT(CAST(si.total_area_kanal AS CHAR), ' kanal')
                WHEN (si.total_area_kanal = 0 AND si.total_area_marla > 0) THEN CONCAT(CAST(si.total_area_marla AS CHAR), ' marla')
                ELSE 'NA'
            END
         as area"))
         ->join('school_info_three_years as sity', 'si.s_emis_code', '=', 'sity.emis_code');

        if ($districtId) {
            //dd($districtId);
            $tehsils = DB::table('tehsils')
                        ->select('tehsil_id as s_tehsil_idFk', 'tehsil_name as t_name')
                        ->where('s_district_idFk', $districtId)
                        ->get();
            $query->where('si.s_district_idFk', $districtId);
            $districtName = DB::table('districts')
                            ->select('district_name')
                            ->where('district_id', $districtId)
                            ->first();
            \DB::statement("SET SQL_MODE=''");
            $pp_seat =  DB::table('school_info')
                            ->select('pp_no', 'pp_seat')
                            ->groupBy('pp_no')
                            ->where('pp_no', '!=', 0)
                            ->where('pp_seat', '!=', '0')
                            ->where('s_district_idFk', $districtId)
                            ->get();

                $na_seat = DB::table('school_info')
                            ->select('na_no', 'na_seat')
                            ->groupBy('na_no')
                            ->where('na_no', '!=', 0)
                            ->where('na_seat', '!=', '0')
                            ->where('s_district_idFk', $districtId)
                            ->get();

        }else{
            $tehsils='';
            $districtName = '';
            $pp_seat = '';
            $na_seat = '';
        }

        if ($tehsilId) {
            $markazes = DB::table('markazes')
            ->select('m_id as s_markaz_idFk', 'm_name')
            ->where('m_tehsil_idFk', $tehsilId)->where('m_status', 1)
            ->get();
            $query->where('si.s_tehsil_idFk', $tehsilId);
            $tehsilName = DB::table('tehsils')
                            ->select('tehsil_name')
                            ->where('tehsil_id', $tehsilId)
                            ->first();
        }else{
            $markazes='';
            $tehsilName = '';
        }

        if ($markazId) {
            $query->where('si.s_markaz_idFk', $markazId);
            $markazName = DB::table('markazes')
                            ->select('m_name')
                            ->where('m_id', $markazId)
                            ->first();
        }else{
            $markazName = '';
        }
        if ($schoolId) {
            $query->where('si.id', $schoolId);
            $schoolName = DB::table('school_info')
                            ->select('s_name')
                            ->where('id', $schoolId)
                            ->first();
        }else{
            $schoolId='';
            $schoolName = '';
        }

        if ($s_level) {
            $query->where('si.s_level', $s_level);
        }

        if ($s_type) {
            $query->where('si.s_type', $s_type);
        }
        if ($project) {
            if($project=='PHCIP'){
                $query->where('si.is_phcip', 1);
            }elseif($project=='ASP'){
                $query->where('si.is_asp', 1);
            }elseif($project=='ECE'){
                $query->where('si.is_ece', 1);
            }elseif($project=='MEAL'){
                $query->where('si.is_meal_program', 1);
            }

        }
        if (isset($teachers)) {

            $query->where('si.no_of_teachers', $teachers);
        }
        if (isset($ppId)) {

            $query->where('si.pp_no', $ppId);
            $PPName =  DB::table('school_info')
                            ->select('pp_no', 'pp_seat')
                            ->where('pp_no',  $ppId)
                            ->first();
        }else{
            $PPName = '';
        }
        if (isset($naId)) {

            $query->where('si.na_no', $naId);
            $NAName = DB::table('school_info')
                            ->select('na_no', 'na_seat')
                            ->where('na_no',  $naId)
                            ->first();
        }else{
            $NAName = '';
        }
        $query->where('si.s_lat', '!=', "");
        //$query->whereIn('no_of_teachers',[0,1,2]);
        $schools = $query->get();
       // dd($schools);
       // exit;

        $districts = DB::table('districts')
        ->select('district_id as s_district_idFk', 'district_name as d_name', 'lat', 'long')
        ->get();



      //  $sql = $query->toSql();

// Get the bindings used in the query
       // $bindings = $query->getBindings();

        // Combine the SQL query and the bindings to form the complete query string
      //  $queryString = vsprintf(str_replace('?', '%s', $sql), collect($bindings)->map(function ($binding) {
      //      return is_numeric($binding) ? $binding : "'{$binding}'";
      //  })->toArray());

        // Now you can output the complete query string with bindings replaced
        //dd($queryString);
        //dd($schools);
        return view('map', compact('districts','tehsils','markazes', 'schools', 'districtId', 'teachers','project','schoolId','markazId','tehsilId','s_type','s_level', 'districtName', 'tehsilName', 'PPName', 'NAName', 'markazName', 'schoolName', 'pp_seat','ppId', 'na_seat', 'naId'));

    }

    public function getSchoolsAjax(Request $request)
    {

        // Fetch schools with latitude and longitude data based on filters (if any)
        $districtId = $request->input('district_id');

        $tehsilId = $request->input('tehsil_id');
        $markazId = $request->input('markaz_id');
        $ppId = $request->input('pp_id');

        $query = DB::table('school_info')
                    ->select( 'id','s_emis_code',
                    's_name',
                    );

        if ($districtId) {

            $query->where('s_district_idFk', $districtId);
        }

        if ($tehsilId) {

            $query->where('s_tehsil_idFk', $tehsilId);
        }

        if ($markazId) {
            $query->where('s_markaz_idFk', $markazId);
        }
        if ($ppId) {
            $query->where('pp_no', $ppId);
        }

        $query->where('s_lat', '!=', "");
       // $query->whereIn('no_of_teachers',[0,1,2]);

        $schools = $query->get();


       // dd($schools);
        return response()->json($schools);

    }

    /***********************Stats of school in punjab method**************************/

    public function punjabStats()
    {
        $districts = DB::table('districts')
            ->select('district_id as s_district_idFk', 'district_name as d_name', 'lat', 'long')
            ->get();

        $district1 = '';
        $district2 = '';
        $comparison_type = '';
        // Execute the query to get the required statistics
        $school_stats = DB::select("
            SELECT
                (SELECT FORMAT(count(id), 0) FROM school_info) AS total_schools,
                (SELECT FORMAT(SUM(functional_classrooms), 0) FROM school_info) AS total_classrooms,
                (SELECT FORMAT(SUM(no_of_teachers),0) FROM school_info) AS total_teachers,
                (SELECT FORMAT(COALESCE(SUM(total_students), 0),0) FROM school_info) AS t_students,
                (SELECT SUM(total_students)/sum(no_of_teachers) FROM school_info) AS s_t_r,
                (SELECT SUM(total_students)/sum(functional_classrooms) FROM school_info) AS s_c_r,
                (SELECT COUNT(*) FROM school_info WHERE bw = 1) AS bw_1_count,
                (SELECT COUNT(*) FROM school_info WHERE bw = 0) AS bw_0_count,
                (SELECT COUNT(*) FROM school_info WHERE electricity = 1) AS electricity_1_count,
                (SELECT COUNT(*) FROM school_info WHERE electricity = 0 OR electricity IS NULL) AS electricity_0_null_count,
                (SELECT COUNT(*) FROM school_info WHERE dw = 1) AS dw_1_count,
                (SELECT COUNT(*) FROM school_info WHERE dw = 0) AS dw_0_count,
                (SELECT COUNT(*) FROM school_info WHERE toilet_facility = 1) AS toilet_facility_1_count,
                (SELECT COUNT(*) FROM school_info WHERE toilet_facility = 0) AS toilet_facility_0_count,
                (SELECT COUNT(*) FROM school_info WHERE science_lab = 1 AND (s_level='High' OR s_level='H.Sec.')) AS science_lab_1_count,
                (SELECT COUNT(*) FROM school_info WHERE science_lab = 0 AND (s_level='High' OR s_level='H.Sec.')) AS science_lab_0_count,
                (SELECT COUNT(*) FROM school_info WHERE computer_lab = 1 AND (s_level='High' OR s_level='H.Sec.')) AS computer_lab_1_count,
                (SELECT COUNT(*) FROM school_info WHERE computer_lab = 0 AND (s_level='High' OR s_level='H.Sec.')) AS computer_lab_0_count,
                (SELECT COUNT(*) FROM school_info WHERE library = 1 AND (s_level='High' OR s_level='H.Sec.')) AS library_1_count,
                (SELECT COUNT(*) FROM school_info WHERE library = 0 AND (s_level='High' OR s_level='H.Sec.')) AS library_0_count,
                (SELECT COUNT(*) FROM school_info WHERE play_ground = 1) AS play_ground_1_count,
                (SELECT COUNT(*) FROM school_info WHERE play_ground = 0) AS play_ground_0_count
        ");
       // dd($school_stats[0]->dw_1_count);

        // Return the view with the required data
        return view('punjab_stats', compact('districts', 'district1', 'district2', 'school_stats', 'comparison_type'));
    }

    public function compareDistricts(Request $request)
    {
        // Fetch markazes based on the selected tehsil
        $dropdown1 = $request->input('dropdown1');
        $dropdown2 = $request->input('dropdown2');
        $comparison_type = $request->input('comparison_type');
        \DB::statement("SET SQL_MODE=''");
        if($comparison_type=='district'){
            $stat_1 = DB::select("
            SELECT
                (select distinct(d_name) from school_info  WHERE s_district_idFk = ?) as district_name,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=0  and  s_district_idFk = ?) as zero_teacher,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=1  and s_district_idFk = ?) as one_teacher,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=2  and s_district_idFk = ?) as two_teachers,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers>2  and s_district_idFk = ?) as more_than_two_teachers,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=0  and  s_district_idFk = ?) as zero_teacher_enrollments,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=1  and s_district_idFk = ?) as one_teacher_enrollments,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=2  and s_district_idFk = ?) as two_teachers_enrollments,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers>2  and s_district_idFk = ?) as more_than_two_teachers_enrollments,
                (SELECT FORMAT(count(id),0) FROM school_info WHERE s_district_idFk = ?) AS total_schools,
                (SELECT FORMAT(SUM(functional_classrooms),0) FROM school_info WHERE s_district_idFk = ?) AS total_classrooms,
                (SELECT FORMAT(SUM(no_of_teachers),0) FROM school_info WHERE s_district_idFk = ?) AS total_teachers,
                (SELECT FORMAT(COALESCE(SUM(total_students), 0),0) FROM school_info WHERE s_district_idFk = ?) AS t_students,
                (SELECT SUM(total_students)/sum(no_of_teachers) FROM school_info WHERE s_district_idFk = ?) AS s_t_r,
                (SELECT SUM(total_students)/sum(functional_classrooms) FROM school_info WHERE s_district_idFk = ?) AS s_c_r,
                ((SELECT COUNT(*) FROM school_info WHERE electricity = 1 AND s_district_idFk = ?) / (SELECT COUNT(*) FROM school_info WHERE s_district_idFk = ?)) * 100 AS electricity_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE bw = 1 AND s_district_idFk = ?) / (SELECT COUNT(*) FROM school_info WHERE s_district_idFk = ?)) * 100 AS bw_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE dw = 1 AND s_district_idFk = ?) / (SELECT COUNT(*) FROM school_info WHERE s_district_idFk = ?)) * 100 AS dw_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE toilet_facility = 1 AND s_district_idFk = ?) / (SELECT COUNT(*) FROM school_info WHERE s_district_idFk = ?)) * 100 AS toilet_facility_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE science_lab = 1 AND s_district_idFk = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE s_district_idFk = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS science_lab_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE computer_lab = 1 AND s_district_idFk = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE s_district_idFk = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS computer_lab_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE library = 1 AND s_district_idFk = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE s_district_idFk = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS library_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE play_ground = 1 AND s_district_idFk = ?) / (SELECT COUNT(*) FROM school_info WHERE s_district_idFk = ?)) * 100 AS play_ground_1_percentage
                ", [$dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1]);

            $stat_2 = DB::select("
            SELECT
                (select distinct(d_name) from school_info  WHERE s_district_idFk = ?) as district_name,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=0  and  s_district_idFk = ?) as zero_teacher,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=1  and s_district_idFk = ?) as one_teacher,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=2  and s_district_idFk = ?) as two_teachers,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers>2  and s_district_idFk = ?) as more_than_two_teachers,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=0  and  s_district_idFk = ?) as zero_teacher_enrollments,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=1  and s_district_idFk = ?) as one_teacher_enrollments,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=2  and s_district_idFk = ?) as two_teachers_enrollments,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers>2  and s_district_idFk = ?) as more_than_two_teachers_enrollments,
                (SELECT FORMAT(count(id),0) FROM school_info WHERE s_district_idFk = ?) AS total_schools,
                (SELECT FORMAT(SUM(functional_classrooms),0) FROM school_info WHERE s_district_idFk = ?) AS total_classrooms,
                (SELECT FORMAT(SUM(no_of_teachers),0) FROM school_info WHERE s_district_idFk = ?) AS total_teachers,
                (SELECT FORMAT(COALESCE(SUM(total_students), 0),0) FROM school_info WHERE s_district_idFk = ?) AS t_students,
                (SELECT SUM(total_students)/sum(no_of_teachers) FROM school_info WHERE s_district_idFk = ?) AS s_t_r,
                (SELECT SUM(total_students)/sum(functional_classrooms) FROM school_info WHERE s_district_idFk = ?) AS s_c_r,
                ((SELECT COUNT(*) FROM school_info WHERE electricity = 1 AND s_district_idFk = ?) / (SELECT COUNT(*) FROM school_info WHERE s_district_idFk = ?)) * 100 AS electricity_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE bw = 1 AND s_district_idFk = ?) / (SELECT COUNT(*) FROM school_info WHERE s_district_idFk = ?)) * 100 AS bw_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE dw = 1 AND s_district_idFk = ?) / (SELECT COUNT(*) FROM school_info WHERE s_district_idFk = ?)) * 100 AS dw_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE toilet_facility = 1 AND s_district_idFk = ?) / (SELECT COUNT(*) FROM school_info WHERE s_district_idFk = ?)) * 100 AS toilet_facility_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE science_lab = 1 AND s_district_idFk = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE s_district_idFk = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS science_lab_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE computer_lab = 1 AND s_district_idFk = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE s_district_idFk = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS computer_lab_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE library = 1 AND s_district_idFk = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE s_district_idFk = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS library_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE play_ground = 1 AND s_district_idFk = ?) / (SELECT COUNT(*) FROM school_info WHERE s_district_idFk = ?)) * 100 AS play_ground_1_percentage
                ", [$dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2]);

        }elseif($comparison_type=='pp'){
            $stat_1 = DB::select("
            SELECT
                (select distinct(pp_seat) from school_info  WHERE pp_no = ? LIMIT 1) as pp_seat,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=0  and  pp_no = ?) as zero_teacher,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=1  and pp_no = ?) as one_teacher,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=2  and pp_no = ?) as two_teachers,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers>2  and pp_no = ?) as more_than_two_teachers,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=0  and  pp_no = ?) as zero_teacher_enrollments,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=1  and pp_no = ?) as one_teacher_enrollments,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=2  and pp_no = ?) as two_teachers_enrollments,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers>2  and pp_no = ?) as more_than_two_teachers_enrollments,
                (SELECT FORMAT(count(id),0) FROM school_info WHERE pp_no = ?) AS total_schools,
                (SELECT FORMAT(SUM(functional_classrooms),0) FROM school_info WHERE pp_no = ?) AS total_classrooms,
                (SELECT FORMAT(SUM(no_of_teachers),0) FROM school_info WHERE pp_no = ?) AS total_teachers,
                (SELECT FORMAT(COALESCE(SUM(total_students), 0),0) FROM school_info WHERE pp_no = ?) AS t_students,
                (SELECT SUM(total_students)/sum(no_of_teachers) FROM school_info WHERE pp_no = ?) AS s_t_r,
                (SELECT SUM(total_students)/sum(functional_classrooms) FROM school_info WHERE pp_no = ?) AS s_c_r,
                ((SELECT COUNT(*) FROM school_info WHERE electricity = 1 AND pp_no = ?) / (SELECT COUNT(*) FROM school_info WHERE pp_no = ?)) * 100 AS electricity_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE bw = 1 AND pp_no = ?) / (SELECT COUNT(*) FROM school_info WHERE pp_no = ?)) * 100 AS bw_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE dw = 1 AND pp_no = ?) / (SELECT COUNT(*) FROM school_info WHERE pp_no = ?)) * 100 AS dw_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE toilet_facility = 1 AND pp_no = ?) / (SELECT COUNT(*) FROM school_info WHERE pp_no = ?)) * 100 AS toilet_facility_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE science_lab = 1 AND pp_no = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE pp_no = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS science_lab_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE computer_lab = 1 AND pp_no = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE pp_no = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS computer_lab_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE library = 1 AND pp_no = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE pp_no = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS library_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE play_ground = 1 AND pp_no = ?) / (SELECT COUNT(*) FROM school_info WHERE pp_no = ?)) * 100 AS play_ground_1_percentage
                ", [$dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1]);

        $stat_2 = DB::select("
            SELECT
            (select distinct(pp_seat) from school_info  WHERE pp_no = ? LIMIT 1)  as pp_seat,
            (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=0  and  pp_no = ?) as zero_teacher,
            (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=1  and pp_no = ?) as one_teacher,
            (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=2  and pp_no = ?) as two_teachers,
            (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers>2  and pp_no = ?) as more_than_two_teachers,
            (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=0  and  pp_no = ?) as zero_teacher_enrollments,
            (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=1  and pp_no = ?) as one_teacher_enrollments,
            (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=2  and pp_no = ?) as two_teachers_enrollments,
            (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers>2  and pp_no = ?) as more_than_two_teachers_enrollments,
            (SELECT FORMAT(count(id),0) FROM school_info WHERE pp_no = ?) AS total_schools,
            (SELECT FORMAT(SUM(functional_classrooms),0) FROM school_info WHERE pp_no = ?) AS total_classrooms,
            (SELECT FORMAT(SUM(no_of_teachers),0) FROM school_info WHERE pp_no = ?) AS total_teachers,
            (SELECT FORMAT(COALESCE(SUM(total_students), 0),0) FROM school_info WHERE pp_no = ?) AS t_students,
            (SELECT SUM(total_students)/sum(no_of_teachers) FROM school_info WHERE pp_no = ?) AS s_t_r,
            (SELECT SUM(total_students)/sum(functional_classrooms) FROM school_info WHERE pp_no = ?) AS s_c_r,
            ((SELECT COUNT(*) FROM school_info WHERE electricity = 1 AND pp_no = ?) / (SELECT COUNT(*) FROM school_info WHERE pp_no = ?)) * 100 AS electricity_1_percentage,
            ((SELECT COUNT(*) FROM school_info WHERE bw = 1 AND pp_no = ?) / (SELECT COUNT(*) FROM school_info WHERE pp_no = ?)) * 100 AS bw_1_percentage,
            ((SELECT COUNT(*) FROM school_info WHERE dw = 1 AND pp_no = ?) / (SELECT COUNT(*) FROM school_info WHERE pp_no = ?)) * 100 AS dw_1_percentage,
            ((SELECT COUNT(*) FROM school_info WHERE toilet_facility = 1 AND pp_no = ?) / (SELECT COUNT(*) FROM school_info WHERE pp_no = ?)) * 100 AS toilet_facility_1_percentage,
            ((SELECT COUNT(*) FROM school_info WHERE science_lab = 1 AND pp_no = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE pp_no = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS science_lab_1_percentage,
            ((SELECT COUNT(*) FROM school_info WHERE computer_lab = 1 AND pp_no = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE pp_no = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS computer_lab_1_percentage,
            ((SELECT COUNT(*) FROM school_info WHERE library = 1 AND pp_no = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE pp_no = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS library_1_percentage,
            ((SELECT COUNT(*) FROM school_info WHERE play_ground = 1 AND pp_no = ?) / (SELECT COUNT(*) FROM school_info WHERE pp_no = ?)) * 100 AS play_ground_1_percentage
            ", [$dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2]);

        }elseif($comparison_type=='na'){
            $stat_1 = DB::select("
            SELECT
                (select distinct(na_seat) from school_info  WHERE na_no = ? LIMIT 1) as na_seat,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=0  and  na_no = ?) as zero_teacher,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=1  and na_no = ?) as one_teacher,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=2  and na_no = ?) as two_teachers,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers>2  and na_no = ?) as more_than_two_teachers,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=0  and  na_no = ?) as zero_teacher_enrollments,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=1  and na_no = ?) as one_teacher_enrollments,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=2  and na_no = ?) as two_teachers_enrollments,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers>2  and na_no = ?) as more_than_two_teachers_enrollments,
                (SELECT FORMAT(count(id),0) FROM school_info WHERE na_no = ?) AS total_schools,
                (SELECT FORMAT(SUM(functional_classrooms),0) FROM school_info WHERE na_no = ?) AS total_classrooms,
                (SELECT FORMAT(SUM(no_of_teachers),0) FROM school_info WHERE na_no = ?) AS total_teachers,
                (SELECT FORMAT(COALESCE(SUM(total_students), 0),0) FROM school_info WHERE na_no = ?) AS t_students,
                (SELECT SUM(total_students)/sum(no_of_teachers) FROM school_info WHERE na_no = ?) AS s_t_r,
                (SELECT SUM(total_students)/sum(functional_classrooms) FROM school_info WHERE na_no = ?) AS s_c_r,
                ((SELECT COUNT(*) FROM school_info WHERE electricity = 1 AND na_no = ?) / (SELECT COUNT(*) FROM school_info WHERE na_no = ?)) * 100 AS electricity_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE bw = 1 AND na_no = ?) / (SELECT COUNT(*) FROM school_info WHERE na_no = ?)) * 100 AS bw_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE dw = 1 AND na_no = ?) / (SELECT COUNT(*) FROM school_info WHERE na_no = ?)) * 100 AS dw_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE toilet_facility = 1 AND na_no = ?) / (SELECT COUNT(*) FROM school_info WHERE na_no = ?)) * 100 AS toilet_facility_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE science_lab = 1 AND na_no = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE na_no = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS science_lab_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE computer_lab = 1 AND na_no = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE na_no = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS computer_lab_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE library = 1 AND na_no = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE na_no = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS library_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE play_ground = 1 AND na_no = ?) / (SELECT COUNT(*) FROM school_info WHERE na_no = ?)) * 100 AS play_ground_1_percentage
                 ", [$dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1, $dropdown1]);

            $stat_2 = DB::select("
            SELECT
                (select distinct(na_seat) from school_info  WHERE na_no = ? LIMIT 1) as na_seat,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=0  and  na_no = ?) as zero_teacher,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=1  and na_no = ?) as one_teacher,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers=2  and na_no = ?) as two_teachers,
                (select FORMAT(count(no_of_teachers),0) from school_info  WHERE no_of_teachers>2  and na_no = ?) as more_than_two_teachers,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=0  and  na_no = ?) as zero_teacher_enrollments,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=1  and na_no = ?) as one_teacher_enrollments,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers=2  and na_no = ?) as two_teachers_enrollments,
                (select FORMAT(sum(total_students),0) from school_info  WHERE no_of_teachers>2  and na_no = ?) as more_than_two_teachers_enrollments,
                (SELECT FORMAT(count(id),0) FROM school_info WHERE na_no = ?) AS total_schools,
                (SELECT FORMAT(SUM(functional_classrooms),0) FROM school_info WHERE na_no = ?) AS total_classrooms,
                (SELECT FORMAT(SUM(no_of_teachers),0) FROM school_info WHERE na_no = ?) AS total_teachers,
                (SELECT FORMAT(COALESCE(SUM(total_students), 0),0) FROM school_info WHERE na_no = ?) AS t_students,
                (SELECT SUM(total_students)/sum(no_of_teachers) FROM school_info WHERE na_no = ?) AS s_t_r,
                (SELECT SUM(total_students)/sum(functional_classrooms) FROM school_info WHERE na_no = ?) AS s_c_r,
                ((SELECT COUNT(*) FROM school_info WHERE electricity = 1 AND na_no = ?) / (SELECT COUNT(*) FROM school_info WHERE na_no = ?)) * 100 AS electricity_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE bw = 1 AND na_no = ?) / (SELECT COUNT(*) FROM school_info WHERE na_no = ?)) * 100 AS bw_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE dw = 1 AND na_no = ?) / (SELECT COUNT(*) FROM school_info WHERE na_no = ?)) * 100 AS dw_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE toilet_facility = 1 AND na_no = ?) / (SELECT COUNT(*) FROM school_info WHERE na_no = ?)) * 100 AS toilet_facility_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE science_lab = 1 AND na_no = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE na_no = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS science_lab_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE computer_lab = 1 AND na_no = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE na_no = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS computer_lab_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE library = 1 AND na_no = ? AND (s_level='High' OR s_level='H.Sec.')) / (SELECT COUNT(*) FROM school_info WHERE na_no = ? AND (s_level='High' OR s_level='H.Sec.'))) * 100 AS library_1_percentage,
                ((SELECT COUNT(*) FROM school_info WHERE play_ground = 1 AND na_no = ?) / (SELECT COUNT(*) FROM school_info WHERE na_no = ?)) * 100 AS play_ground_1_percentage
                ", [$dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2, $dropdown2]);

        }

        //dd($stat_district_1,$stat_district_2);
        // Fetch all districts for the dropdown
        $districts = DB::table('districts')
            ->select('district_id as s_district_idFk', 'district_name as d_name', 'lat', 'long')
            ->get();

        $pps =  DB::table('school_info')
        ->select('pp_no', 'pp_seat')
        ->groupBy('pp_no')
        ->orderBy('pp_no','asc')
        ->where('pp_no', '!=', 0)
        ->where('pp_seat', '!=', '0')
        ->get();

        $nas = DB::table('school_info')
                        ->select('na_no', 'na_seat')
                        ->groupBy('na_no')
                        ->orderBy('na_no','asc')
                        ->where('na_no', '!=', 0)
                        ->where('na_seat', '!=', '0')
                        ->get();



        // dd($districtNames);
        // Return the view with the required data
        return view('district_comparison', compact('comparison_type', 'pps','nas' ,'districts', 'dropdown1', 'dropdown2', 'stat_1','stat_2'));
    }
    public function teachersSchoolWise(Request $request, $district_id = null, $teacher_count = null) {
       // dd($district_id,$teacher_count);


        $query = DB::table('school_info')
            ->select('id', 's_emis_code', 's_name', 'd_name', 't_name', 'm_name', 'no_of_teachers', 's_level', 's_type', 'total_students');
       // dd($district_id,$teacher_count);
       if ($district_id !== null && $district_id != 'all') {
        $query->where('s_district_idFk', $district_id);
        }

        if ($teacher_count !== null) {
            if ($teacher_count == 'zero') {
                $query->where('no_of_teachers', 0);
            } elseif ($teacher_count == 'one') {
                $query->where('no_of_teachers', 1);
            } elseif ($teacher_count == 'two') {
                $query->where('no_of_teachers', 2);
            } elseif ($teacher_count == 'more') {
                $query->where('no_of_teachers', '>', 2);
            }
        }

        $schoolsTeacherWise = $query->paginate(10);

        $districts = DB::table('districts')
            ->select('district_id as s_district_idFk', 'district_name as d_name', 'lat', 'long')
            ->get();

        return view('teachers_school_wise', compact('districts', 'district_id', 'teacher_count', 'schoolsTeacherWise'));
    }

    public function getComparisonDropdown(Request $request)
    {
        $comparison_type = $request->input('comparison_type');
        $result = [];
        \DB::statement("SET SQL_MODE=''");
        if ($comparison_type == 'district') {
            $result = DB::table('districts')
                ->select('district_id as s_district_idFk', 'district_name as d_name', 'lat', 'long')
                ->get();
        } elseif ($comparison_type == 'pp') {

            $result =  DB::table('school_info')
            ->select('pp_no', 'pp_seat')
            ->groupBy('pp_no')
            ->orderBy('pp_no','asc')
            ->where('pp_no', '!=', 0)
            ->where('pp_seat', '!=', '0')
            ->get();
        } elseif ($comparison_type == 'na') {
            $result = DB::table('school_info')
                        ->select('na_no', 'na_seat')
                        ->groupBy('na_no')
                        ->orderBy('na_no','asc')
                        ->where('na_no', '!=', 0)
                        ->where('na_seat', '!=', '0')
                        ->get();
        }

        return response()->json($result);
    }

    //methods for new Established schools

    public function newSchoolsMap()
    {
        $districts = DB::table('districts')
        ->select('district_id as s_district_idFk', 'district_name as d_name', 'lat', 'long')
        ->get();
        $districtId = ''; //default lahore
        $schools =DB::table('new_schools_sne')
        ->select('id', 's_emis_code', 's_name', 'd_name', 't_name',  's_lat', 's_lng', 's_type', 's_level', 's_sne_type','s_no_of_rooms')->where('s_lat', '!=', "0")
        ->get();


        $tehsilId = '';
        $markazId = '';
        $schoolId = '';
        $s_type = '';
        $s_level = '';
        $teachers = '';
        $project = '';
        \DB::statement("SET SQL_MODE=''");
        $pp_seat =  DB::table('school_info')
                    ->select('pp_no', 'pp_seat')
                    ->groupBy('pp_no')
                    ->where('pp_no', '!=', 0)
                    ->where('pp_seat', '!=', '0')
                    ->where('s_district_idFk', $districtId)
                    ->get();

        $ppId = '';
        $na_seat = DB::table('school_info')
                    ->select('na_no', 'na_seat')
                    ->groupBy('na_no')
                    ->where('na_no', '!=', 0)
                    ->where('na_seat', '!=', '0')
                    ->where('s_district_idFk', $districtId)
                    ->get();
       // dd($na_seat);
        $naId = '';
        $districtName = DB::table('districts')
        ->select('district_name')
        ->where('district_id', $districtId)
        ->first();
        $tehsilName = '';
        $markazName = '';
        $PPName = '';
        $NAName = '';
        $schoolName = '';

        $tehsils = DB::table('tehsils')
        ->select('tehsil_id as s_tehsil_idFk', 'tehsil_name as t_name')
        ->where('s_district_idFk', $districtId)
        ->get();
        $markazes = '';
        return view('map-new-schools', compact('districts','tehsils','markazes', 'schools', 'districtId','teachers','project','markazId','schoolId','tehsilId','s_type','s_level', 'districtName', 'tehsilName',  'markazName', 'PPName', 'NAName', 'schoolName', 'pp_seat','ppId', 'na_seat', 'naId'));


    }

    public function getSNESchools(Request $request)
    {

        // Fetch schools with latitude and longitude data based on filters (if any)
        $districtId = $request->input('district');
        $tehsilId = $request->input('tehsil');
        $markazId = $request->input('markaz');
        $s_level = $request->input('s_level');
        $s_type = $request->input('s_type');
        $teachers = $request->input('teachers');
        $schoolId = $request->input('school');
        $project = $request->input('project');
        $ppId = $request->input('pp_seat');
        $naId = $request->input('na_seat');
       // dd($request->input());


        $query =DB::table('new_schools_sne')
        ->select('id', 's_emis_code', 's_name', 'd_name', 't_name',  's_lat', 's_lng', 's_type', 's_level', 's_sne_type','s_no_of_rooms')->where('s_lat', '!=', "0");

        if ($districtId) {
            //dd($districtId);
            $tehsils = DB::table('tehsils')
                        ->select('tehsil_id as s_tehsil_idFk', 'tehsil_name as t_name')
                        ->where('s_district_idFk', $districtId)
                        ->get();
            $query->where('d_name', $districtId);
            $districtName = DB::table('districts')
                            ->select('district_name')
                            ->where('district_name', $districtId)
                            ->first();
            \DB::statement("SET SQL_MODE=''");
            $pp_seat =  DB::table('school_info')
                            ->select('pp_no', 'pp_seat')
                            ->groupBy('pp_no')
                            ->where('pp_no', '!=', 0)
                            ->where('pp_seat', '!=', '0')
                            ->where('s_district_idFk', $districtId)
                            ->get();

                $na_seat = DB::table('school_info')
                            ->select('na_no', 'na_seat')
                            ->groupBy('na_no')
                            ->where('na_no', '!=', 0)
                            ->where('na_seat', '!=', '0')
                            ->where('s_district_idFk', $districtId)
                            ->get();

        }else{
            $tehsils='';
            $districtName = '';
            $pp_seat = '';
            $na_seat = '';
        }

        if ($tehsilId) {
            $markazes = DB::table('markazes')
            ->select('m_id as s_markaz_idFk', 'm_name')
            ->where('m_tehsil_idFk', $tehsilId)->where('m_status', 1)
            ->get();
            $query->where('s_tehsil_idFk', $tehsilId);
            $tehsilName = DB::table('tehsils')
                            ->select('tehsil_name')
                            ->where('tehsil_id', $tehsilId)
                            ->first();
        }else{
            $markazes='';
            $tehsilName = '';
        }

        if ($markazId) {
            $query->where('s_markaz_idFk', $markazId);
            $markazName = DB::table('markazes')
                            ->select('m_name')
                            ->where('m_id', $markazId)
                            ->first();
        }else{
            $markazName = '';
        }
        if ($schoolId) {
            $query->where('id', $schoolId);
            $schoolName = DB::table('school_info')
                            ->select('s_name')
                            ->where('id', $schoolId)
                            ->first();
        }else{
            $schoolId='';
            $schoolName = '';
        }

        if ($s_level) {
            $query->where('s_level', $s_level);
        }

        if ($s_type) {
            $query->where('s_type', $s_type);
        }
        if ($project) {
            if($project=='PHCIP'){
                $query->where('is_phcip', 1);
            }elseif($project=='ASP'){
                $query->where('is_asp', 1);
            }elseif($project=='ECE'){
                $query->where('is_ece', 1);
            }

        }
        if (isset($teachers)) {

            $query->where('no_of_teachers', $teachers);
        }
        if (isset($ppId)) {

            $query->where('pp_no', $ppId);
            $PPName =  DB::table('school_info')
                            ->select('pp_no', 'pp_seat')
                            ->where('pp_no',  $ppId)
                            ->first();
        }else{
            $PPName = '';
        }
        if (isset($naId)) {

            $query->where('na_no', $naId);
            $NAName = DB::table('school_info')
                            ->select('na_no', 'na_seat')
                            ->where('na_no',  $naId)
                            ->first();
        }else{
            $NAName = '';
        }
        $query->where('s_lat', '!=', "");
        //$query->whereIn('no_of_teachers',[0,1,2]);
        $schools = $query->get();


        $districts = DB::table('districts')
        ->select('district_id as s_district_idFk', 'district_name as d_name', 'lat', 'long')
        ->get();
        //dd($query->toSql());
        //dd($ppId, $naId, $schools);
        return view('map-new-schools', compact('districts','tehsils','markazes', 'schools', 'districtId', 'teachers','project','schoolId','markazId','tehsilId','s_type','s_level', 'districtName', 'tehsilName', 'PPName', 'NAName', 'markazName', 'schoolName', 'pp_seat','ppId', 'na_seat', 'naId'));

    }

    public function showImages($id)
    {

        // Fetch the NewSchoolSnc entry based on $id
        $schoolSnc = DB::table('new_schools_sne')
        ->where('id', $id)
        ->first();
        // dd($schoolSnc);
        // exit;
        // Get the unique code (folder name)
        $uniqueCode = $schoolSnc->s_unique_code;
        //$school_name = $schoolSnc->s_name;
        // Fetch all images from the corresponding folder on the server
        $folderPath = public_path('/assets/sne_images/' . $uniqueCode); // Adjust 'images/' as per your folder structure
        //$images = [];
        $files = File::files($folderPath);

        foreach ($files as $file) {
            $documents[] = [
                'name' => pathinfo($file->getFilename(), PATHINFO_FILENAME),
                'path' => $file->getFilename() // You can adjust this according to your file structure
            ];
        }
        //dd($documents);
        //exit;


        return view('new-schools-gallery', compact('documents', 'uniqueCode', ));
    }






}
