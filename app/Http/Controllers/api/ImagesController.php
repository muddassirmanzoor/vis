<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ImageMetaData;
use App\Models\Images;
use App\Models\SchoolsVerifyLogs;
use App\Models\SchoolStatusRemarks;
use App\Models\LocationData;
use App\Models\Schools;
use App\Models\SISUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ImagesController extends Controller
{

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function uploadImages(Request $request)
{
    try {
        // Define validation rules for each image type
        $rules = [
            'gate_picture' => 'max:10240', // Max size 10MB
            'academic_block' => 'max:10240',
            'drinking_water' => 'max:10240',
            'toilet_block' => 'max:10240',
            'play_ground' => 'max:10240',
            'library' => 'max:10240',
            'computer_lab' => 'max:10240',
            'science_lab' => 'max:10240',
            // Add more image types here
        ];

        // Validate the incoming request with defined rules
        $validatedData = $request->validate($rules);
        $emis_code = Auth::user()->u_username;
        $delete_categories = [];
        $images_text = '';
        $changed_images = [];

        // Handle file upload and store images
        foreach ($request->all() as $key => $data) {
            if (is_array($data)) {
                foreach ($data as $index => $file) {
                    // Check if the key is an image type and the file is uploaded
                    if ($file !== null) {
                        if (array_key_exists($key, $rules) && $request->hasFile($key)) {
                            // Store the file in the appropriate directory with a unique name
                            $lab_dir = '';
                            $lab_cat = '';
                            if ($key == 'science_lab') {
                                if ($index == 0) {
                                    $lab_dir = '/' . $emis_code . '_physics';
                                    $lab_cat = '/physics';
                                }
                                if ($index == 1) {
                                    $lab_dir = '/' . $emis_code . '_chemistry';
                                    $lab_cat = '/chemistry';
                                }
                                if ($index == 2) {
                                    $lab_dir = '/' . $emis_code . '_biology';
                                    $lab_cat = '/biology';
                                }
                            }
                            $directory = 'uploads/' . $emis_code . '/' . $emis_code . '_' . $key . $lab_dir; // Example directory path
                            $fileName = $emis_code . '_' . $file->getClientOriginalName(); // Get the original file name
                            $file->storeAs('public/' . $directory, $fileName); // Store the file

                            // Check if image changed
                            $existing_image = ImageMetaData::where('emis_code', $emis_code)
                                ->where('category_type', $key . $lab_cat)
                                ->where('verify', 2)
                                ->first();

                            if ($existing_image) {
                                $existing_image_path = public_path($existing_image->images->file_path);
                                if (file_exists($existing_image_path)) {
                                    $new_image_path = public_path($directory . '/' . $fileName);
                                    if (hash_file('sha256', $existing_image_path) !== hash_file('sha256', $new_image_path)) {
                                        $changed_images[] = $existing_image->category_type;
                                    }
                                }
                            }

                            if (!in_array($key, $delete_categories)) {
                                $already_exist = ImageMetaData::where('emis_code', $emis_code)
                                    ->where('category_type', $key . $lab_cat)
                                    ->get();
                                if (count($already_exist) > 0) {
                                    foreach ($already_exist as $data) {
                                        $data->images()->delete();
                                        $data->delete();
                                    }
                                    $delete_categories[] = $key . $lab_cat;
                                }
                            }

                            $imageData = new ImageMetaData;
                            $imageData->u_id = Auth::user()->u_id;
                            $imageData->emis_code = $emis_code;
                            $imageData->category_type = $key . $lab_cat;
                            $imageData->save();

                            $images = new Images();
                            $images->metadata_id = $imageData->id;
                            $images->file_path = $directory . '/' . $fileName;
                            $images->save();

                            $images_text = 'Images/ ';
                        }
                    }
                }
            }
        }

        // Save logs in schools_verify_logs if images changed
        if (!empty($changed_images)) {
            foreach ($changed_images as $changed_image) {
                $log = new SchoolsVerifyLogs;
                $log->emis_code = $emis_code;
                $log->u_id = Auth::user()->u_id;
                $log->category_type = $changed_image;
                $log->save();
            }
        }

        // Update school_status_remarks source column to "user"
        SchoolStatusRemarks::where('emis_code', $emis_code)->update(['source' => 'user']);

        $locationData = new LocationData();
        $locationData->u_id = Auth::user()->u_id;
        $locationData->emis_code = $emis_code;
        $locationData->lat = $request->get('lat');
        $locationData->long = $request->get('long');
        $locationData->accuracy = $request->get('accuracy');
        $locationData->save();

        // Return a success response or redirect back with a success message
        $response = [
            'status' => 'success',
            'message' => $images_text . 'Location uploaded successfully.',
        ];

        return response()->json($response, 200);
    } catch (\Exception $ex) {
        $response = [
            'status' => 'false',
            'message' => $ex->getMessage(),
        ];
        return response()->json($response, 400);
    }
}

    public function getRemarks($emis_code)
    {
        try {
            
            $images_data = ImageMetaData::where('emis_code', $emis_code)
                ->with(['images' => function ($query) {
                    $query->select('id', 'metadata_id', 'file_path');
                }])
                ->select('id', 'category_type', 'verify')
                ->get();

            // Group the images_data collection by category_type
            $grouped_data = $images_data->groupBy('category_type');

            // Initialize an empty array to store the limited data
            $limited_data = [];

            foreach ($grouped_data as $category_type => $images) {
                // Transform the images collection to include only the required attributes
                $transformed_images = $images->map(function ($item) {
                    return [
                        'id' => $item->images->pluck('id')->first(),
                        'metadata_id' => $item->images->pluck('metadata_id')->first(),
                        'file_path' => $item->images->pluck('file_path')->first(),
                        'verify' => $item->verify,
                    ];
                });

                $limited_item = [
                    'category_type' => $category_type,
                    'images' => $transformed_images,
                ];

                $limited_data[] = $limited_item;
            }

            // Fetch school_status_remarks_data
            $school_status_remarks_data = DB::table('school_status_remarks')
                ->where('emis_code', $emis_code)
                ->select('emis_code', 'u_id', 'remarks', 'status')
                ->first();

            $response_data = [
                'section_data' => $limited_data,
                'school_status_remarks_data' => $school_status_remarks_data,
            ];

            return response()->json($response_data, 200);
        } catch (\Exception $e) {
            $response = [
                'status' => 'false',
                'message' => $e->getMessage(),
            ];
            return response()->json($response, 400);
        }
    }
    public function getSchoolstatus($emis_code)
{
    try { 
        // Get school status remarks data and check if it exists
        $school_status_remarks_data = DB::table('school_status_remarks')
            ->where('emis_code', $emis_code)
            ->select('emis_code', 'u_id', 'remarks', 'status', 'source')
            ->get();

        if ($school_status_remarks_data->isNotEmpty()) {
            // Check if image_metadata has records
            $activity = ImageMetaData::where('emis_code', $emis_code)
                ->whereNull('deleted_at')
                ->exists();

            // Check if DMO remarks provided
            $dmo_remarks_provided = $school_status_remarks_data->contains('source', 'dmo');

            // Check if user remarks data submitted
            $user_remarks_data_submitted = $school_status_remarks_data->contains('source', 'user');

            $response_data = [
                'status' => 'success',
                'message' => 'Data retrieved successfully',
                'activity' => $activity,
                'dmo_remarks_provided' => $dmo_remarks_provided,
                'user_remarks_data_submitted' => $user_remarks_data_submitted,
                'school_status_remarks_data' => $school_status_remarks_data,
            ];

            return response()->json($response_data, 200);
        } else {
            $response = [
                'status' => 'false',
                'message' => 'No Remarks Submitted by DMO',
                'activity' => false,
                'dmo_remarks_provided' => false,
                'user_remarks_data_submitted' => false,
                'school_status_remarks_data' => [],
            ];
            return response()->json($response, 200);
        }
    } catch (\Exception $e) {
        $response = [
            'status' => 'false',
            'message' => $e->getMessage(),
        ];
        return response()->json($response, 400);
    }
}

}