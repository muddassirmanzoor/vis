<?php

namespace App\Http\Controllers\SICA;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\ImageMetaData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Input\Input;

class DashboardController extends Controller
{


    public function dashboard(Request $request)
    {
        $user = Auth::user();

        $total_Schools = $this->getTotalSchools($user);
        $total_verified = $this->getTotalVerified($user);
        $totalUnverified = $this->getTotalUnverified($user);
        $totalPendingReviewCount = $this->getTotalPendingReview($user);

        $totalsubmitted = $totalUnverified + $totalPendingReviewCount + $total_verified;
        $totalDatanotsubmitted = $total_Schools - $totalsubmitted;
        $total_Schools = number_format($total_Schools);
        $totalDatanotsubmitted = number_format($totalDatanotsubmitted);
        $totalPendingReview = number_format($totalPendingReviewCount);
        $getSchoolsLocation = $this->getSchoolsLocation($user);

        if ($user->user_type === 'ADMIN') {
            $districts = DB::table('districts')
                ->where('status', 1)
                ->get(['district_id', 'district_name']);
        } else {
            $districts = DB::table('districts')
                ->where('district_id', $user->district_idFk)
                ->where('status', 1)
                ->first(['district_id', 'district_name']);
        }

        if ($request->ajax()) {
            $data = [
                'total_verified' => $total_verified,
                'total_unverified' => $totalUnverified,
                'total_data_not_submitted' => $totalDatanotsubmitted,
                'total_pending_review' => $totalPendingReview
            ];
            return response()->json($data)
                ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        }
        //dd($districts);
        return view('sica.dashboard', compact('districts', 'total_Schools', 'total_verified', 'totalUnverified', 'totalPendingReview', 'totalDatanotsubmitted', 'user', 'getSchoolsLocation'));
    }

    public function getTehsils($districtId)
    {
        $tehsils = DB::table('tehsils')
            ->where('s_district_idFk', $districtId)
            ->where('status', 1)
            ->get(['tehsil_id', 'tehsil_name']);

        return response()->json($tehsils)
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }
    public function getMarkez($tehsilId)
    {
        $markez = DB::table('markazes')
            ->where('m_tehsil_idFk', $tehsilId)
            ->where('m_status', 1)
            ->get(['m_id', 'm_name']);
        return response()->json($markez)
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }
    public function getSchools($markezId)
    {
        $schools = DB::table('school_info')
            ->where('s_markaz_idFk', $markezId)
            //->where('m_status', 1)
            ->get(['id', 's_name', 's_emis_code']);
        return response()->json($schools)
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }
    public function data_not_submitted()
    {
        $user = Auth::user();
        $perPage = 40;
        $totalDataNotSubmitted = $this->getTotalDataNotSubmitted($user);

        // Fetch data based on user type
        if ($user->user_type === 'ADMIN') {
            $query = DB::table('school_info as si')
                ->leftJoin(
                    DB::raw('(SELECT emis_code, MAX(id) as max_id FROM image_metadata GROUP BY emis_code) as im_subquery'),
                    'si.s_emis_code',
                    '=',
                    'im_subquery.emis_code'
                )
                ->leftJoin('image_metadata as im', function ($join) {
                    $join->on('im_subquery.max_id', '=', 'im.id');
                })
                ->whereNull('im.emis_code')
                ->select('si.s_emis_code', 'si.d_name', 'si.t_name', 'si.s_name');
        } else {
            $query = DB::table('school_info as si')
                ->leftJoin('image_metadata as im', function ($join) use ($user) {
                    $join->on('si.s_emis_code', '=', 'im.emis_code')
                        ->whereNull('im.emis_code')
                        ->where('si.s_district_idFk', $user->district_idFk);
                })
                ->select('si.s_emis_code', 'si.d_name', 'si.t_name', 'si.s_name');
        }

        // Fetch paginated data
        $schoolsPaginated = $query->simplePaginate($perPage);

        // Create custom paginator
        $customPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $schoolsPaginated->items(),
            $totalDataNotSubmitted,
            $schoolsPaginated->perPage(),
            $schoolsPaginated->currentPage(),
            ['path' => $schoolsPaginated->path()]
        );

        return view('sica.data-not-submitted', [
            'schoolsPaginated' => $customPaginated,
            'totalDataNotSubmittedFormatted' => $totalDataNotSubmitted
        ]);
    }



    // public function data_not_submitted()
    // {
    //     $user = Auth::user();
    //     $perPage = 40; // Define the number of records per page

    //     // Prepare the base query depending on user type
    //     $schoolsQuery = DB::table('school_info')
    //         ->select('s_emis_code', 'd_name', 't_name', 's_name');

    //     if ($user->user_type !== 'ADMIN') {
    //         $userDistrictId = $user->district_idFk;
    //         $schoolsQuery->where('s_district_idFk', $userDistrictId);
    //     }

    //     // Fetch all EMIS codes from image_metadata
    //     $metadataEmisCodes = DB::table('image_metadata')
    //         ->select('emis_code')
    //         ->distinct()
    //         ->pluck('emis_code')
    //         ->toArray();

    //     // Use cursor to iterate over large datasets efficiently
    //     $schools = collect();
    //     $schoolsQuery->cursor()->each(function ($school) use (&$schools, $metadataEmisCodes) {
    //         if (!in_array($school->s_emis_code, $metadataEmisCodes)) {
    //             $schools->push($school);
    //         }
    //     });

    //     // Manual pagination of results
    //     $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
    //     $currentItems = $schools->slice(($currentPage - 1) * $perPage, $perPage);
    //     $schoolsPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
    //         $currentItems, // Items for the current page
    //         $schools->count(), // Total items
    //         $perPage, // Items per page
    //         $currentPage, // Current page
    //         ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
    //     );
    //     return view('sica.data-not-submitted', [
    //         'schoolsPaginated' => $schoolsPaginated
    //     ]);
    // }


    private function getTotalDataNotSubmitted($user)
    {
        $total_Schools = $this->getTotalSchools($user);
        $total_verified = $this->getTotalVerified($user);
        $totalUnverified = $this->getTotalUnverified($user);
        $totalPendingReview = $this->getTotalPendingReview($user);

        $totalsubmitted = $totalUnverified + $totalPendingReview + $total_verified;
        $totalDatanotsubmitted = $total_Schools - $totalsubmitted;

        return $totalDatanotsubmitted;
    }

    public function data_verified()
    {
        $user = Auth::user();

        // Check if the user is an admin
        if ($user->user_type === 'ADMIN') {
            // Fetch verified schools with status from school_status_remarks
            $verifiedSchools = DB::table('school_status_remarks')
                ->select(
                    'school_status_remarks.emis_code',
                    'school_status_remarks.status'
                )
                ->join('school_info', 'school_info.s_emis_code', '=', 'school_status_remarks.emis_code')
                ->where('school_status_remarks.status', 1) // Filter only verified schools
                ->distinct()
                ->get();
        } else {
            $userDistrictId = $user->district_idFk;

            // Fetch verified schools with status from school_status_remarks
            $verifiedSchools = DB::table('school_status_remarks')
                ->select(
                    'school_status_remarks.emis_code',
                    'school_status_remarks.status'
                )
                ->join('school_info', 'school_info.s_emis_code', '=', 'school_status_remarks.emis_code')
                ->where('school_info.s_district_idFk', $userDistrictId)
                ->where('school_status_remarks.status', 1) // Filter only verified schools
                ->distinct()
                ->get();
        }
        // Get the EMIS codes of the verified schools
        $verified_emis_codes = $verifiedSchools->pluck('emis_code')->toArray();

        // Fetch image metadata for the verified EMIS codes
        $imageMetadataQuery = DB::table('image_metadata')
            ->whereNull('deleted_at')
            ->whereIn('emis_code', $verified_emis_codes)
            ->get();

        // Group image metadata by emis_code
        $groupedImageMetadata = $imageMetadataQuery->groupBy('emis_code');

        // Fetch school information for the verified schools
        $schools = DB::table('school_info')
            ->select(
                'school_info.s_emis_code',
                'school_info.d_name',
                'school_info.t_name',
                'school_info.s_name',
            )
            ->whereIn('s_emis_code', $verified_emis_codes)
            ->get();

        // Map the image metadata to the verified schools and fetch location data
        $schools = $schools->map(function ($school) use ($groupedImageMetadata) {
            // Get the image metadata for the current school's emis_code
            $metadata = $groupedImageMetadata->get($school->s_emis_code);

            // Fetch the latest latitude and longitude from location_data table
            $latest_location_data = DB::table('location_data')
                ->select('lat', 'long')
                ->where('emis_code', $school->s_emis_code)
                ->orderBy('created_at', 'desc')
                ->first();

            // If metadata exists for the current school, map it to the school
            if ($metadata) {
                $school->items = $metadata->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'category_type' => $item->category_type,
                        'verify' => $item->verify,
                    ];
                })->toArray();
            } else {
                $school->items = []; // No metadata found for this school
            }

            // If location data exists, add it to the school object
            if ($latest_location_data) {
                $school->s_lat = $latest_location_data->lat;
                $school->s_lng = $latest_location_data->long;
            } else {
                $school->s_lat = null;
                $school->s_lng = null;
            }

            return $school;
        })
            ->filter(function ($school) {
                return !empty($school->items);
            });

        // Paginate the queried schools
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $perPage = 40;
        $schoolsPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $schools->forPage($page, $perPage),
            $schools->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );
        //dd($schoolsPaginated);
        return view('sica.data_verified', compact('schoolsPaginated'));
    }

    public function data_unverified()
    {

        $user = Auth::user();
        if ($user->user_type === 'ADMIN') {
            $schoolsQuery = DB::table('school_info')
                ->select(
                    'school_info.s_emis_code',
                    'school_info.d_name',
                    'school_info.t_name',
                    'school_info.s_name',
                )
                ->get();

            $verified_emis_codes = $schoolsQuery->pluck('s_emis_code')->toArray();
        } else {
            $userDistrictId = $user->district_idFk;

            // Fetch school information
            $schoolsQuery = DB::table('school_info')
                ->select(
                    'school_info.s_emis_code',
                    'school_info.d_name',
                    'school_info.t_name',
                    'school_info.s_name',
                )
                ->where('school_info.s_district_idFk', $userDistrictId)
                ->get();

            $verified_emis_codes = $schoolsQuery->pluck('s_emis_code')->toArray();
        }
        $imageMetadataQuery = DB::table('image_metadata')
            ->whereNull('deleted_at')
            ->whereIn('emis_code', $verified_emis_codes)
            ->where('verify', 2)
            ->get();

        // Group image metadata by emis_code
        $groupedImageMetadata = $imageMetadataQuery->groupBy('emis_code');

        // Fetch the latest location data for each school
        $latest_location_data = DB::table('location_data')
            ->select('emis_code', 'lat', 'long')
            ->whereIn('emis_code', $verified_emis_codes)
            ->orderBy('created_at', 'desc')
            ->distinct('emis_code')
            ->get()
            ->keyBy('emis_code'); // Index the result by emis_code for easier retrieval

        // Map the image metadata and location data to the unverified schools
        $schools = $schoolsQuery->map(function ($school) use ($groupedImageMetadata, $latest_location_data) {
            // Get the image metadata for the current school's emis_code
            $metadata = $groupedImageMetadata->get($school->s_emis_code);

            // Get the latest location data for the current school
            $location_data = $latest_location_data->get($school->s_emis_code);

            // If metadata exists for the current school, map it to the school
            if ($metadata) {
                $school->items = $metadata->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'category_type' => $item->category_type,
                        'verify' => $item->verify,
                    ];
                })->toArray();
            } else {
                $school->items = []; // No metadata found for this school
            }

            // If location data exists, add it to the school object
            if ($location_data) {
                $school->s_lat = $location_data->lat;
                $school->s_lng = $location_data->long;
            } else {
                $school->s_lat = null;
                $school->s_lng = null;
            }

            return $school;
        })
            ->filter(function ($school) {
                return !empty($school->items);
            });

        // Paginate the mapped schools
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $perPage = 40;
        $schoolsPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $schools->forPage($page, $perPage),
            $schools->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );
        //dd($schoolsPaginated);
        return view('sica.data_unverified', compact('schoolsPaginated', 'schools'));
    }
    public function data_pending()
    {
        $user = Auth::user();

        if ($user->user_type === 'ADMIN') {
            $schoolsQuery = DB::table('school_info')
                ->select(
                    'school_info.s_emis_code',
                    'school_info.d_name',
                    'school_info.t_name',
                    'school_info.s_name'
                )
                ->get();
        } else {
            $userDistrictId = $user->district_idFk;

            $schoolsQuery = DB::table('school_info')
                ->select(
                    'school_info.s_emis_code',
                    'school_info.d_name',
                    'school_info.t_name',
                    'school_info.s_name',
                )
                ->where('school_info.s_district_idFk', $userDistrictId)
                ->get();
        }

        $verifiedEmisCodes = $schoolsQuery->pluck('s_emis_code')->toArray();

        $imageMetadataQuery = DB::table('image_metadata')
            ->whereIn('emis_code', $verifiedEmisCodes)
            ->whereNull('deleted_at')
            ->where('verify', 0)
            ->whereNotIn('emis_code', function ($query) {
                $query->select('emis_code')
                    ->from('image_metadata')
                    ->where('verify', 2);
            })
            ->whereNotIn('emis_code', function ($query) {
                $query->select('emis_code')
                    ->from('school_status_remarks');
            })
            ->get();

        $groupedImageMetadata = $imageMetadataQuery->groupBy('emis_code');

        $schools = $schoolsQuery->map(function ($school) use ($groupedImageMetadata) {
            $metadata = $groupedImageMetadata->get($school->s_emis_code);

            if ($metadata) {
                $school->items = $metadata->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'category_type' => $item->category_type,
                        'verify' => $item->verify,
                    ];
                })->toArray();
            } else {
                $school->items = [];
            }

            return $school;
        })
            ->filter(function ($school) {
                return !empty($school->items);
            });

        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $perPage = 40;

        // Instead of using simple paginate, use LengthAwarePaginator directly with inner join
        $offset = ($page - 1) * $perPage;
        $total = count($schools);
        $schoolsPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            array_slice($schools->toArray(), $offset, $perPage),
            $total,
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        return view('sica.data_pending', compact('schoolsPaginated', 'schools'));
    }

    public function DashboardStat(Request $request)
    {

        $user = Auth::user();

        if ($request->input('districtId')) {
            $districtId = $request->input('districtId');
        } else {
            $districtId = '';
        }
        if ($request->input('tehsilId')) {
            $tehsilId = $request->input('tehsilId');
        } else {
            $tehsilId = '';
        }
        if ($request->input('markezId')) {
            $markezId = $request->input('markezId');
        } else {
            $markezId = '';
        }

        $total_Schools = $this->getTotalSchools($user, $districtId, $tehsilId, $markezId);
        $total_verified = $this->getTotalVerified($user, $districtId, $tehsilId, $markezId);
        $totalUnverified = $this->getTotalUnverified($user, $districtId, $tehsilId, $markezId);
        $totalPendingReview = $this->getTotalPendingReview($user, $districtId, $tehsilId, $markezId);
        $getSchoolsLocation = $this->getSchoolsLocation($user, $districtId, $tehsilId, $markezId);
        // Calculate other counts as needed
        $totalsubmitted = $totalUnverified + $totalPendingReview + $total_verified;
        $totalDatanotsubmitted = $total_Schools - $totalsubmitted;


        // Return the counts or any other data as needed
        $data = [
            'schools_location' => $getSchoolsLocation,
            'total_schools' => $total_Schools,
            'total_verified' => $total_verified,
            'total_unverified' => $totalUnverified,
            'total_pending_review' => $totalPendingReview,
            'total_data_not_submitted' => $totalDatanotsubmitted
        ];
        return response()->json($data)
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }
    private function getTotalSchools($user, $districtId = null, $tehsilId = null, $markezId = null)
    {
        $query = DB::table('school_info');

        if ($user->user_type !== 'ADMIN') {
            $emis_codes = $this->getEmisCodesForUser($user);
            $query->whereIn('s_emis_code', $emis_codes);
        }
        if ($districtId != null || $districtId != "") {

            $query->where('s_district_idFk', $districtId);
        }
        if ($tehsilId != null || $tehsilId != "") {

            $query->where('s_tehsil_idFk', $tehsilId); // Corrected to 'tehsil_id'
        }
        if ($markezId != null || $markezId != "") {
            $query->where('s_markaz_idFk', $markezId); // Corrected to 'markez_id'
        }
        return $query->count();
    }
    private function getSchoolsLocation($user, $districtId = null, $tehsilId = null, $markezId = null)
    {
        // $results = DB::table('location_data AS ld')
        // ->select('ld.emis_code', 'ld.lat', 'ld.long', 'ld.created_at', 'si.d_name', 'si.t_name', 'si.s_name', 'ssr.remarks', 'ssr.source')
        // ->join('school_info AS si', 'ld.emis_code', '=', 'si.s_emis_code')
        // ->leftJoin('school_status_remarks AS ssr', 'ld.emis_code', '=', 'ssr.emis_code')
        // ->where('ld.created_at', '=', DB::raw('(SELECT MAX(ld2.created_at) FROM location_data AS ld2 WHERE ld2.emis_code = ld.emis_code)'))
        // ->get();

        if ($districtId === null && $tehsilId === null && $markezId === null) {
            $emis_codes = $this->getEmisCodesForUser($user);
        } else {
            $emis_codes = $this->getEmisCodes($user, $districtId, $tehsilId, $markezId);
        }


        if ($user->user_type !== 'ADMIN' || $districtId !== null && $districtId !== "" || $tehsilId !== null && $tehsilId !== "" || $markezId !== null && $markezId !== "") {
            $emis_codes_str = implode(',', $emis_codes);
            $school_stats = DB::select("
            SELECT 
            ld.emis_code, 
            ld.lat, 
            ld.long, 
            ld.created_at, 
            si.d_name, 
            si.t_name, 
            si.s_name,
            si.s_type,
            si.s_level,
            si.m_name,  
            ssr.remarks, 
            ssr.source
    FROM location_data ld
    INNER JOIN school_info si ON ld.emis_code = si.s_emis_code
    LEFT JOIN school_status_remarks ssr ON ld.emis_code = ssr.emis_code
    WHERE ld.emis_code IN ($emis_codes_str)
    AND ld.created_at = (
        SELECT MAX(ld2.created_at)
        FROM location_data ld2
        WHERE ld2.emis_code = ld.emis_code
        AND ld2.lat IS NOT NULL
        AND ld2.long IS NOT NULL
        AND ld2.lat != 0.0
        AND ld2.long != 0.0
    )
    AND ld.lat IS NOT NULL
    AND ld.long IS NOT NULL
    AND ld.lat != 0.0
    AND ld.long != 0.0
");
        } else {
            $school_stats = DB::select("
                            SELECT 
                                ld.emis_code, 
                                ld.lat, 
                                ld.long, 
                                ld.created_at, 
                                si.d_name, 
                                si.t_name, 
                                si.s_name,
                                si.s_type,
                                si.s_level,
                                si.m_name,  
                                ssr.remarks, 
                                ssr.source
                            FROM 
                                location_data ld
                            INNER JOIN 
                                school_info si ON ld.emis_code = si.s_emis_code
                            LEFT JOIN
                                school_status_remarks ssr ON ld.emis_code = ssr.emis_code
                            WHERE
                                ld.created_at = (
                                    SELECT MAX(ld2.created_at)
                                    FROM location_data ld2
                                    WHERE ld2.emis_code = ld.emis_code
                                    AND ld2.lat IS NOT NULL
                                    AND ld2.long IS NOT NULL
                                    AND ld2.lat != 0.0
                                    AND ld2.long != 0.0
                                )
                                AND ld.lat IS NOT NULL
                                AND ld.long IS NOT NULL
                                AND ld.lat != 0.0
                                AND ld.long != 0.0
                        ");
        }
        //dd($school_stats);
        // if ($user->user_type !== 'ADMIN' || $districtId !== null && $districtId !== "" || $tehsilId !== null && $tehsilId !== "" || $markezId !== null && $markezId !== "") {
        //     $query = DB::table('location_data AS ld')
        //       ->select('ld.emis_code', 'ld.lat', 'ld.long', 'ld.created_at', 'si.d_name', 'si.t_name', 'si.s_name', 'ssr.remarks', 'ssr.source')
        //       ->join('school_info AS si', 'ld.emis_code', '=', 'si.s_emis_code')
        //       ->leftJoin('school_status_remarks AS ssr', 'ld.emis_code', '=', 'ssr.emis_code')
        //       ->whereIn('ld.emis_code', $emis_codes)
        //       ->whereNotNull('ld.lat')
        //       ->whereNotNull('ld.long')
        //       ->latest('ld.created_at')
        //       ->distinct('ld.emis_code')
        //       ->get();
        //   } else {
        //     $query = DB::table('location_data AS ld')
        //       ->select('ld.emis_code', 'ld.lat', 'ld.long', 'ld.created_at', 'si.d_name', 'si.t_name', 'si.s_name', 'ssr.remarks', 'ssr.source')
        //       ->join('school_info AS si', function ($join) use ($user) {
        //         $join->on('ld.emis_code', '=', 'si.s_emis_code')
        //           ->useIndex($user->user_type === 'ADMIN' ? 'idx_ld_emis_code' : null);
        //       })
        //       ->leftJoin('school_status_remarks AS ssr', function ($join) use ($user) {
        //         $join->on('ld.emis_code', '=', 'ssr.emis_code')
        //           ->useIndex($user->user_type === 'ADMIN' ? 'idx_ssr_emis_code' : null);
        //       })
        //       ->whereNotNull('ld.lat')
        //       ->whereNotNull('ld.long')
        //       ->latest('ld.created_at')
        //       ->distinct('ld.emis_code')
        //       ->get();
        //   }
        return $school_stats;
    }
    private function getTotalVerified($user, $districtId = null, $tehsilId = null, $markezId = null)
    {
        $query = DB::table('school_status_remarks')->where('status', 1);
        if ($districtId == null && $tehsilId == null && $markezId == null) {
            $emis_codes = $this->getEmisCodesForUser($user);
        } else {
            $emis_codes = $this->getEmisCodes($user, $districtId, $tehsilId, $markezId);
        }

        if ($user->user_type !== 'ADMIN' || $districtId !== null && $districtId !== "" || $tehsilId !== null && $tehsilId !== "" || $markezId !== null && $markezId !== "") {
            return DB::table('school_status_remarks')
                ->whereIn('emis_code', $emis_codes)
                ->where('status', 1)
                ->count('emis_code');
        }

        return $query->count('emis_code');
    }

    // private function getTotalUnverified($user, $districtId = null, $tehsilId = null, $markezId = null)
    // {
    //     if ($user->user_type === 'ADMIN') {
    //         return DB::table('image_metadata')
    //             ->whereNull('deleted_at')
    //             ->where('verify', 2)
    //             ->selectRaw('COUNT(DISTINCT emis_code) as total_unverified')
    //             ->value('total_unverified');
    //     } else {
    //         $emis_codes = $this->getEmisCodesForUser($user);
    //         return DB::table('image_metadata')
    //             ->whereIn('emis_code', $emis_codes)
    //             ->whereNull('deleted_at')
    //             ->where('verify', 2)
    //             ->selectRaw('COUNT(DISTINCT emis_code) as total_unverified')
    //             ->value('total_unverified');
    //     }
    // }
    private function getTotalUnverified($user, $districtId = null, $tehsilId = null, $markezId = null)
    {
        $query = DB::table('image_metadata')
            ->whereNull('deleted_at')
            ->where('verify', 2);

        if ($districtId === null && $tehsilId === null && $markezId === null) {
            $emis_codes = $this->getEmisCodesForUser($user);
        } else {
            $emis_codes = $this->getEmisCodes($user, $districtId, $tehsilId, $markezId);
        }

        if ($user->user_type !== 'ADMIN' || $districtId !== null && $districtId !== "" || $tehsilId !== null && $tehsilId !== "" || $markezId !== null && $markezId !== "") {
            $total_unverified = $query->whereIn('emis_code', $emis_codes)->selectRaw('COUNT(DISTINCT emis_code) as total_unverified')->value('total_unverified');
        } else {
            $total_unverified = $query->selectRaw('COUNT(DISTINCT emis_code) as total_unverified')->value('total_unverified');
        }
        return $total_unverified;
    }
    private function getTotalPendingReview($user, $districtId = null, $tehsilId = null, $markezId = null)
    {
        if ($districtId === null && $tehsilId === null && $markezId === null) {
            $emis_codes = $this->getEmisCodesForUser($user);
        } else {
            $emis_codes = $this->getEmisCodes($user, $districtId, $tehsilId, $markezId);
        }
        if ($user->user_type !== 'ADMIN' || $districtId !== null && $districtId !== "" || $tehsilId !== null && $tehsilId !== "" || $markezId !== null && $markezId !== "") {
            return DB::table('image_metadata')
                ->whereIn('emis_code', $emis_codes)
                ->where('verify', 0)
                ->whereNotIn('emis_code', function ($query) {
                    $query->select('emis_code')
                        ->from('image_metadata')
                        ->where('verify', 2);
                })
                ->whereNotIn('emis_code', function ($query) {
                    $query->select('emis_code')
                        ->from('school_status_remarks');
                })
                ->groupBy('emis_code')
                ->select('emis_code', DB::raw('COUNT(*) as count'))
                ->get()
                ->count();
        } else {
            return DB::table('image_metadata')
                ->where('verify', 0)
                ->whereNotIn('emis_code', function ($query) {
                    $query->select('emis_code')
                        ->from('image_metadata')
                        ->where('verify', 2);
                })
                ->whereNotIn('emis_code', function ($query) {
                    $query->select('emis_code')
                        ->from('school_status_remarks');
                })
                ->groupBy('emis_code')
                ->select('emis_code', DB::raw('COUNT(*) as count'))
                ->get()
                ->count();
        }
    }

    // private function getTotalPendingReview($user, $districtId = null, $tehsilId = null, $markezId = null)
    // {
    //     if ($user->user_type === 'ADMIN') {
    //         return DB::table('image_metadata')
    //             ->where('verify', 0)
    //             ->whereNotIn('emis_code', function ($query) {
    //                 $query->select('emis_code')
    //                     ->from('image_metadata')
    //                     ->where('verify', 2);
    //             })
    //             ->whereNotIn('emis_code', function ($query) {
    //                 $query->select('emis_code')
    //                     ->from('school_status_remarks');
    //             })
    //             ->groupBy('emis_code')
    //             ->select('emis_code', DB::raw('COUNT(*) as count'))
    //             ->get()
    //             ->count();
    //     } else {
    //         $emis_codes = $this->getEmisCodesForUser($user);
    //         return DB::table('image_metadata')
    //             ->whereIn('emis_code', $emis_codes)
    //             ->where('verify', 0)
    //             ->whereNotIn('emis_code', function ($query) {
    //                 $query->select('emis_code')
    //                     ->from('image_metadata')
    //                     ->where('verify', 2);
    //             })
    //             ->whereNotIn('emis_code', function ($query) {
    //                 $query->select('emis_code')
    //                     ->from('school_status_remarks');
    //             })
    //             ->groupBy('emis_code')
    //             ->select('emis_code', DB::raw('COUNT(*) as count'))
    //             ->get()
    //             ->count();
    //     }
    // }

    private function getEmisCodesForUser($user)
    {
        return DB::table('districts')
            ->select('school_info.s_emis_code')
            ->join('users', function ($join) use ($user) {
                $join->on('users.district_idFk', '=', 'districts.district_id')
                    ->where('users.district_idFk', '=', $user->district_idFk);
            })
            ->join('school_info', function ($join) {
                $join->on('school_info.s_district_idFk', '=', 'districts.district_id');
            })
            ->distinct()
            ->pluck('s_emis_code')
            ->toArray();
    }
    private function getEmisCodes($user, $districtId = null, $tehsilId = null, $markezId = null)
    {

        $query = DB::table('districts')
            ->select('school_info.s_emis_code')
            ->join('users', 'users.district_idFk', '=', 'districts.district_id')
            ->join('school_info', 'school_info.s_district_idFk', '=', 'districts.district_id')
            ->distinct();

        // Apply optional filters if provided
        if ($districtId !== null && $districtId !== "") {
            $query->where('school_info.s_district_idFk', $districtId);
        }
        if ($tehsilId !== null && $tehsilId !== "") {
            $query->where('school_info.s_tehsil_idFk', $tehsilId);
        }
        if ($markezId !== null && $markezId !== "") {
            $query->where('school_info.s_markaz_idFk', $markezId);
        }

        return $query->pluck('s_emis_code')->toArray();
        //dd($emisCodes);
    }
}
