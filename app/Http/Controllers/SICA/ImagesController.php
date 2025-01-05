<?php

namespace App\Http\Controllers\SICA;

use App\Http\Controllers\Controller;
use App\Models\ImageMetaData;
use App\Models\Images;
use App\Models\LocationData;
use App\Models\Schools;
use App\Models\SISUser;
use App\Models\SchoolInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ImagesController extends Controller
{

    /**
     * @return View
     */
    public function schoolData(Request $request)
    {
        $user = Auth::user();
        $districtID = $request->input('districtid');
        $emisCode_school = $request->input('school_emis_code');
        $tehsil_select = $request->input('tehsil');
        $markez_select = $request->input('markez_select');
        $school_select = $request->input('school_emis_code');
        $status_select = $request->input('status_select');

        // Fetch image metadata data regardless of user type
        $imageMetaDatas = ImageMetaData::paginate(20);
        $data = [];
        $tehsils = [];
        $markazes = [];

        foreach ($imageMetaDatas as $imageMetaData) {
            // Extract the EMIS code
            $emisCode = $imageMetaData->emis_code;

            // Check if the EMIS code exists in the transformed data array
            if (!isset($data[$emisCode])) {
                // If the EMIS code doesn't exist, initialize it with an empty array
                $data[$emisCode] = [];
            }

            // Append the current image metadata to the array for the corresponding EMIS code
            $data[$emisCode][] = [
                'id' => $imageMetaData->id,
                'u_id' => $imageMetaData->u_id,
                'category_type' => $imageMetaData->category_type,
                'created_at' => $imageMetaData->created_at,
                'updated_at' => $imageMetaData->updated_at,
                'verify' => $imageMetaData->verify,
                'deleted_at' => $imageMetaData->deleted_at,
            ];
        }

        // Convert the associative array to indexed array
        $data = array_values($data);

        // Fetch additional data based on user type
        if ($user->user_type === 'ADMIN') {
            $district_user = DB::table('districts')
                ->select(
                    'districts.district_id',
                    'districts.district_name',
                    'school_info.s_emis_code',
                    'school_info.d_name',
                    'school_info.t_name',
                    'school_info.s_name',
                    'school_status_remarks.status' // Include the status column
                )
                ->join('school_info', 'school_info.s_district_idFk', '=', 'districts.district_id')
                ->leftJoin('school_status_remarks', 'school_status_remarks.emis_code', '=', 'school_info.s_emis_code')
                ->distinct()
                ->get();

            $districts = DB::table('districts')
                ->select('districts.district_id', 'districts.district_name')
                ->distinct()
                ->get();

            // Fetch tehsils and markazes
            $tehsils = DB::table('tehsils')
                ->select('tehsil_id as s_tehsil_idFk', 'tehsil_name as t_name')
                ->get();

            $markazes = DB::table('markazes')
                ->select('m_id as s_markaz_idFk', 'm_name')
                ->where('m_status', 1)
                ->get();

            $query = SchoolInfo::query();
        } else {
            // Fetch data based on the user's district for non-admin users
            $userDistrictId = $user->district_idFk;
            $district_user = DB::table('districts')
                ->select(
                    'districts.district_id',
                    'districts.district_name',
                    'school_info.s_emis_code',
                    'school_info.d_name',
                    'school_info.t_name',
                    'school_info.s_name',
                    'school_status_remarks.status' // Include the status column
                )
                ->join('users', 'users.district_idFk', '=', 'districts.district_id')
                ->join('school_info', 'school_info.s_district_idFk', '=', 'districts.district_id')
                ->leftJoin('school_status_remarks', 'school_status_remarks.emis_code', '=', 'school_info.s_emis_code')
                ->where('users.district_idFk', $userDistrictId)
                ->distinct()
                ->get();

            $districts = DB::table('districts')
                ->select('districts.district_id', 'districts.district_name')
                ->join('users', 'users.district_idFk', '=', 'districts.district_id')
                ->where('users.district_idFk', $userDistrictId)
                ->distinct()
                ->first();

            $query = SchoolInfo::where('s_district_idFk', $userDistrictId);
        }

        // Apply additional query conditions
        if ($emisCode_school != "0" && $emisCode_school != null) {
            $query->where('id', $emisCode_school);
        } elseif ($tehsil_select != "0" && ($markez_select == "0" || $markez_select === null) && $tehsil_select != null) {
            $query->where('s_tehsil_idFk', $tehsil_select);
        } elseif ($markez_select != "0" && $markez_select != null) {
            $query->where('s_markaz_idFk', $markez_select);
        }

        if ($status_select) {
            $schools = $query->get(); // Fetch all results at once
        } else {
            $schools = $query->paginate(40)->appends(request()->query());
        }
        $emisCodes = $schools->pluck('s_emis_code')->toArray();

        if ($status_select == '1') {
            $imageMetadata = DB::table('image_metadata')
                ->join('school_status_remarks', 'school_status_remarks.emis_code', '=', 'image_metadata.emis_code')
                ->whereNull('image_metadata.deleted_at')
                ->whereIn('image_metadata.emis_code', $emisCodes)
                ->where('school_status_remarks.status', 1)
                ->select('image_metadata.*')
                ->get();
            $validEmisCodes = $imageMetadata->pluck('emis_code')->toArray();

            $query->whereIn('s_emis_code', $validEmisCodes);
        } elseif ($status_select == '2') {
            $imageMetadata = DB::table('image_metadata')
                ->join('school_status_remarks', 'school_status_remarks.emis_code', '=', 'image_metadata.emis_code')
                ->whereNull('image_metadata.deleted_at')
                ->whereIn('image_metadata.emis_code', $emisCodes)
                ->where('school_status_remarks.status', 2)
                ->select('image_metadata.*')
                ->get();
            $validEmisCodes = $imageMetadata->pluck('emis_code')->toArray();
            $query->whereIn('s_emis_code', $validEmisCodes);
        } elseif ($status_select == '4') {
            // $imageMetadata = DB::table('image_metadata')
            //     ->whereIn('emis_code', $emisCodes)
            //     ->whereNull('deleted_at')
            //     ->where('verify', 0)
            //     ->whereNotIn('emis_code', function ($query) {
            //         $query->select('emis_code')
            //             ->from('image_metadata')
            //             ->where('verify', 2);
            //     })
            //     ->whereNotIn('emis_code', function ($query) {
            //         $query->select('emis_code')
            //             ->from('school_status_remarks');
            //     })
            //     ->distinct('emis_code')
            //     ->pluck('emis_code');
            $validEmisCodes = DB::table('image_metadata')
                ->whereIn('emis_code', $emisCodes)
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
                ->distinct('emis_code')
                ->pluck('emis_code');

            // Filter the SchoolInfo query using the valid emis_codes
            $query->whereIn('s_emis_code', $validEmisCodes);
        } elseif ($status_select == '3') {
            $imageMetadata = DB::table('image_metadata')
                ->whereIn('emis_code', $emisCodes)
                ->whereNotNull('emis_code')
                ->whereNull('deleted_at')
                ->distinct()
                ->pluck('emis_code')
                ->toArray();
            $query->whereNotIn('s_emis_code', $imageMetadata);
        } elseif ($status_select == '0' || $status_select == null) {
            $imageMetadata = DB::table('image_metadata')
                ->whereNull('deleted_at')
                ->whereIn('emis_code', $emisCodes)
                ->get();
        }
        $schools = $query->paginate(40)->appends(request()->query());
        $emisCodes = $schools->pluck('s_emis_code')->toArray();
        if ($status_select == '4') {
            $imageMetadata = DB::table('image_metadata')
                ->whereIn('emis_code', $emisCodes)
                ->select('emis_code', 'id', 'category_type', 'verify')
                ->get();
        }
        $grouped_and_mapped_metadata = collect($imageMetadata)->groupBy('emis_code')->map(function ($items, $emis_code) use ($district_user) {
            $district = $district_user->first(function ($district) use ($emis_code) {
                return $district->s_emis_code == $emis_code;
            });

            if ($district) {
                $latest_location = DB::table('location_data')
                    ->select('lat', 'long')
                    ->where('emis_code', $emis_code)
                    ->orderBy('created_at', 'desc')
                    ->first();

                return [
                    'emis_code' => $emis_code,
                    'd_name' => $district->d_name,
                    't_name' => $district->t_name,
                    'school_name' => $district->s_name,
                    's_lat' => $latest_location ? $latest_location->lat : null,
                    's_lng' => $latest_location ? $latest_location->long : null,
                    'status' => $district->status,
                    'items' => $items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'category_type' => $item->category_type,
                            'verify' => $item->verify,
                        ];
                    }),
                ];
            } else {
                return [
                    'emis_code' => $emis_code,
                    'status' => 'District information not found'
                ];
            }
        });

        // Add metadata and district information to each school
        $schools->each(function ($school) use ($grouped_and_mapped_metadata) {
            $emisCode = $school->s_emis_code;
            if ($grouped_and_mapped_metadata->has($emisCode)) {
                $school->metadata = $grouped_and_mapped_metadata[$emisCode];
                $school->metadata_status = 'Data available in ImageMetadata';
            } else {
                $school->metadata_status = 'no';
            }
        });

        // Map related data for non-admin users
        $grouped_and_mapped = $schools->map(function ($school) use ($grouped_and_mapped_metadata) {
            if ($grouped_and_mapped_metadata->has($school->s_emis_code)) {
                $school->metadata = $grouped_and_mapped_metadata[$school->s_emis_code];
                $school->metadata_status = 'yes';
            } else {
                $school->metadata_status = 'no';
                $school->metadata = [
                    'emis_code' => $school->s_emis_code,
                    'status' => 'Metadata not available',
                ];
            }
            return $school;
        });
        //dd($grouped_and_mapped_metadata);
        return view('sica.school-data', compact('user', 'data', 'district_user', 'districts', 'tehsils', 'tehsil_select', 'markazes', 'markez_select', 'school_select', 'grouped_and_mapped', 'schools', 'status_select', 'districtID'));
    }

    /**
     * @return View
     */
    public function schoolImages($emis_code): view
    {
        $emis_code = decrypt($emis_code);
        $images_data = ImageMetaData::where('emis_code', $emis_code)->with('images')->get();

        $organized_data = [];

        foreach ($images_data as $metadata) {
            $category_type = $metadata->category_type;
            $section_status = $metadata->verify;
            $remarks = $metadata->remarks;
            $status = $metadata->status;
            //dd($metadata);

            if (!isset($organized_data[$category_type])) {
                $organized_data[$category_type] = [
                    'category_type' => $category_type,
                    'section_status' => $section_status,
                    'images' => []
                ];
            }

            foreach ($metadata->images as $image) {
                $organized_data[$category_type]['images'][] = $image;
            }
        }

        $school_status_remarks_data = DB::table('school_status_remarks')
            ->where('emis_code', $emis_code)
            ->first();

        return view('sica.school-images', compact('organized_data', 'emis_code', 'school_status_remarks_data'));
    }

    public function addRemarks(Request $request): RedirectResponse
    {
        $user = Auth::user();
        // Get the user ID
        $userId = $user ? $user->id : null;

        $emisCode = (int)$request['emis_code'];
        $schoolSection = $request['school_section'];
        $remarks = $request['remarks'];
        $status_school = (int)$request['status'];

        $hasAnySectionTwo = false;

        foreach ($schoolSection as $section) {
            if ($section == '2') {
                $hasAnySectionTwo = true;
                break;
            }
        }

        if ($status_school == '0' || empty($remarks)) {
            return redirect()->back()->withInput()->with('error_message', 'Please add comments and select action accordingly.');
        }

        if ($status_school == '1' && $hasAnySectionTwo) {
            return redirect()->back()->withInput()->with('error_message', 'Some sections are still in verification process please verify all sections for verification');
        }

        if ($status_school == '2' && !$hasAnySectionTwo) {
            return redirect()->back()->withInput()->with('error_message', 'Please Select any section which you want to send back to school.');
        }

        if ($status_school == '1' && !$hasAnySectionTwo) {
            foreach ($schoolSection as &$verifyStatus) {
                if ($verifyStatus != '2') {
                    $verifyStatus = '1';
                }
            }
        }

        try {
            foreach ($schoolSection as $categoryType => $verifyStatus) {
                $previousVerifyStatus = DB::table('image_metadata')
                    ->where('emis_code', $emisCode)
                    ->where('category_type', $categoryType)
                    ->whereNull('deleted_at')
                    ->value('verify');

                DB::table('image_metadata')
                    ->where('emis_code', $emisCode)
                    ->where('category_type', $categoryType)
                    ->whereNull('deleted_at')
                    ->update([
                        'verify' => (int)$verifyStatus,
                        'u_id' => $userId
                    ]);

                if ($verifyStatus != $previousVerifyStatus && $verifyStatus != 0) {
                    DB::table('schools_verify_logs')->insert([
                        'emis_code' => $emisCode,
                        'u_id' => $userId,
                        'user_type' => 'dmo',
                        'category_type' => $categoryType,
                        'verify' => (int)$verifyStatus,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            DB::table('school_status_remarks')->updateOrInsert(
                [
                    'emis_code' => $emisCode,
                    'u_id' => $userId
                ],
                [
                    'remarks' => $remarks,
                    'status' => $status_school,
                    'source' => 'dmo',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
            return redirect()->back()->withInput()->with('success_message', 'Data has been successfully updated');
        } catch (\Exception $e) {
            Log::error('Failed to update/insert data: ' . $e->getMessage());
            Session::flash('error_message', 'Failed to update/insert data.');
        }
        return redirect()->back();
    }
}
