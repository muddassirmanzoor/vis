@extends('layouts.sica.main')
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (Session::has('success_message'))
            <div class="alert alert-success">
                {{ Session::get('success_message') }}
            </div>
        @endif

        @if (Session::has('error_message'))
            <div class="alert alert-danger">
                {{ Session::get('error_message') }}
            </div>
        @endif
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">School Name /</span> EMIS {{ $emis_code }}</h4>
        <form action="{{ url('sica/add-remarks') }}" method="POST">
            @csrf
            <input type="hidden" name="emis_code" value="{{ $emis_code }}">
            <!-- Form START -->
            <div class="row mb-3">
                <div class="col-md-12 col-lg-12 mb-1">
                    <div class="form-check">
                        <input class="form-check-input " type="checkbox" id="select-all" @if($school_status_remarks_data && $school_status_remarks_data->status == 1) disabled @endif/>
                        <label class="form-check-label" for="select-all"> Select All </label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 col-lg-12 mb-3">
                    <div class="form-check">
                        <input type="hidden" name="school_section[gate_picture]" value="0">
                        <input class="form-check-input checkbox-group" name="school_section[gate_picture]" type="checkbox"
                            value="2" id="defaultCheck1" @if (isset($organized_data['gate_picture']['section_status']) && $organized_data['gate_picture']['section_status'] == 2) checked @endif @if($school_status_remarks_data && $school_status_remarks_data->status == 1) disabled @endif />

                        <label class="form-check-label" for="defaultCheck1"> School Gate </label>
                    </div>
                </div>
                @foreach ($organized_data['gate_picture']['images'] as $image)
                    <div class="col-md-4 col-lg-4 mb-3">
                        <div class="card sica-fit-height">
                            <a href="{{ asset('storage/' . $image['file_path']) }}" target="_blank">
                            <img class="img-fluid sica-fit-width" src="{{ asset('storage/' . $image['file_path']) }}"
                                alt="School Gate" />
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row mb-3">
                <div class="col-md-12 col-lg-12 mb-3">
                    <div class="form-check">
                        <input type="hidden" name="school_section[academic_block]" value="0">
                        <input class="form-check-input checkbox-group" type="checkbox" name="school_section[academic_block]"
                            value="2" id="defaultCheck2" @if (isset($organized_data['academic_block']['section_status']) &&
                                    $organized_data['academic_block']['section_status'] == 2) checked @endif @if($school_status_remarks_data && $school_status_remarks_data->status == 1) disabled @endif />

                        <label class="form-check-label" for="defaultCheck2">Academic Block</label>
                    </div>
                </div>
                @foreach ($organized_data['academic_block']['images'] as $image)
                    <div class="col-md-4 col-lg-4 mb-3">
                        <div class="card sica-fit-height">
                            <a href="{{ asset('storage/' . $image['file_path']) }}" target="_blank">
                                <img class="img-fluid sica-fit-width" src="{{ asset('storage/' . $image['file_path']) }}"
                                    alt="Academic Block" />
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row mb-3">
                <div class="col-md-12 col-lg-12 mb-3">
                    <div class="form-check">
                        <input type="hidden" name="school_section[drinking_water]" value="0">
                        <input class="form-check-input checkbox-group" name="school_section[drinking_water]" type="checkbox"
                            value="2" id="defaultCheck3" @if (isset($organized_data['drinking_water']['section_status']) &&
                                    $organized_data['drinking_water']['section_status'] == 2) checked @endif @if($school_status_remarks_data && $school_status_remarks_data->status == 1) disabled @endif />

                        <label class="form-check-label" for="defaultCheck3">Drinking Water</label>
                    </div>
                </div>
                @foreach ($organized_data['drinking_water']['images'] as $image)
                    <div class="col-md-4 col-lg-4 mb-3">
                        <div class="card sica-fit-height">
                            <a href="{{ asset('storage/' . $image['file_path']) }}" target="_blank">
                                <img class="img-fluid sica-fit-width" src="{{ asset('storage/' . $image['file_path']) }}"
                                    alt="Drinking Water" />
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row mb-3">
                <div class="col-md-12 col-lg-12 mb-3">
                    <div class="form-check">
                        <input type="hidden" name="school_section[toilet_block]" value="0">
                        <input class="form-check-input checkbox-group" type="checkbox" name="school_section[toilet_block]"
                            value="2" id="defaultCheck4" @if (isset($organized_data['toilet_block']['section_status']) && $organized_data['toilet_block']['section_status'] == 2) checked @endif @if($school_status_remarks_data && $school_status_remarks_data->status == 1) disabled @endif />

                        <label class="form-check-label" for="defaultCheck4">Toilet Block</label>
                    </div>
                </div>
                @forelse($organized_data['toilet_block']['images'] ?? [] as $image)
                    <div class="col-md-4 col-lg-4 mb-3">
                        <div class="card sica-fit-height">
                            <a href="{{ asset('storage/' . $image['file_path']) }}" target="_blank">
                                <img class="img-fluid sica-fit-width" src="{{ asset('storage/' . $image['file_path']) }}"
                                    alt="Toilet Block" />
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-md-4 col-lg-4 mb-3">
                        <div class="card sica-fit-height">
                            <img class="img-fluid sica-fit-width" src="{{ asset('sica/assets/img/no-image.jpg') }}"
                                alt="Computer Lab" />
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="row mb-3">
                <div class="col-md-12 col-lg-12 mb-3">
                    <div class="form-check">
                        <input type="hidden" name="school_section[play_ground]" value="0">
                        <input class="form-check-input checkbox-group" type="checkbox" name="school_section[play_ground]"
                            value="2" id="defaultCheck5" @if (isset($organized_data['play_ground']) && $organized_data['play_ground']['section_status'] == 2) checked @endif @if($school_status_remarks_data && $school_status_remarks_data->status == 1) disabled @endif/>
                        <label class="form-check-label" for="defaultCheck5">Play Ground</label>
                    </div>
                </div>

                @forelse($organized_data['play_ground']['images'] ?? [] as $image)
                    <div class="col-md-4 col-lg-4 mb-3">
                        <div class="card sica-fit-height">
                            <a href="{{ asset('storage/' . $image['file_path']) }}" target="_blank">
                                <img class="img-fluid sica-fit-width" src="{{ asset('storage/' . $image['file_path']) }}"
                                    alt="Play Ground" />
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-md-4 col-lg-4 mb-3">
                        <div class="card sica-fit-height">
                            <img class="img-fluid sica-fit-width" src="{{ asset('sica/assets/img/no-image.jpg') }}"
                                alt="Play Ground" />
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="row mb-3">
                <div class="col-md-12 col-lg-12 mb-3">
                    <div class="form-check">
                        <input type="hidden" name="school_section[library]" value="0">
                        <input class="form-check-input checkbox-group" type="checkbox"
                            name="school_section[library]" value="2" id="defaultCheck7"
                            @if (isset($organized_data['library']) && $organized_data['library']['section_status'] == 2) checked @endif @if($school_status_remarks_data && $school_status_remarks_data->status == 1) disabled @endif />
                        <label class="form-check-label" for="defaultCheck6">Library</label>
                    </div>
                </div>
                @forelse($organized_data['library']['images'] ?? [] as $image)
                    <div class="col-md-4 col-lg-4 mb-3">
                        <div class="card sica-fit-height">
                            <a href="{{ asset('storage/' . $image['file_path']) }}" target="_blank">
                                <img class="img-fluid sica-fit-width" src="{{ asset('storage/' . $image['file_path']) }}"
                                    alt="Library" />
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-md-4 col-lg-4 mb-3">
                        <div class="card sica-fit-height">
                            <img class="img-fluid sica-fit-width" src="{{ asset('sica/assets/img/no-image.jpg') }}"
                                alt="Computer Lab" />
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="row mb-3">
                <div class="col-md-12 col-lg-12 mb-3">
                    <div class="form-check">
                        <input type="hidden" name="school_section[computer_lab]" value="0">
                        <input class="form-check-input checkbox-group" type="checkbox"
                            name="school_section[computer_lab]" value="2" id="defaultCheck7"
                            @if (isset($organized_data['computer_lab']) && $organized_data['computer_lab']['section_status'] == 2) checked @endif @if($school_status_remarks_data && $school_status_remarks_data->status == 1) disabled @endif/>
                        <label class="form-check-label" for="defaultCheck7">Computer Lab</label>
                    </div>
                </div>
                @forelse($organized_data['computer_lab']['images'] ?? []  as $image)
                    <div class="col-md-4 col-lg-4 mb-3">
                        <div class="card sica-fit-height">
                            <a href="{{ asset('storage/' . $image['file_path']) }}" target="_blank">
                                <img class="img-fluid sica-fit-width" src="{{ asset('storage/' . $image['file_path']) }}"
                                    alt="Computer Lab" />
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-md-4 col-lg-4 mb-3">
                        <div class="card sica-fit-height">
                            <img class="img-fluid sica-fit-width" src="{{ asset('sica/assets/img/no-image.jpg') }}"
                                alt="Computer Lab" />
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="row mb-3">
                @forelse($organized_data['science_lab/physics']['images'] ?? []  as $image)
                    <div class="col-md-4 col-lg-4 mb-3">
                        <div class="form-check mb-3">
                            <input type="hidden" name="school_section[science_lab/physics]" value="0">
                            <input class="form-check-input checkbox-group" name="school_section[science_lab/physics]"
                                type="checkbox" value="2" id="defaultCheck8"
                                @if (isset($organized_data['science_lab/physics']) && $organized_data['science_lab/physics']['section_status'] == 2) checked @endif @if($school_status_remarks_data && $school_status_remarks_data->status == 1) disabled @endif />

                            <label class="form-check-label" for="defaultCheck8">Science Lab/Physics</label>
                        </div>
                        <div class="card sica-fit-height">
                            <a href="{{ asset('storage/' . $image['file_path']) }}" target="_blank">
                                <img class="img-fluid sica-fit-width" src="{{ asset('storage/' . $image['file_path']) }}"
                                    alt="Physics" />
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-md-4 col-lg-4 mb-3">
                        <div class="form-check mb-3">
                            <input type="hidden" name="school_section[science_lab/physics]" value="0">
                            <input class="form-check-input checkbox-group" name="school_section[science_lab/physics]"
                                type="checkbox" value="2" id="defaultCheck8"
                                @if (isset($organized_data['science_lab/physics']) && $organized_data['science_lab/physics']['section_status'] == 2) checked @endif @if($school_status_remarks_data && $school_status_remarks_data->status == 1) disabled @endif/>

                            <label class="form-check-label" for="defaultCheck9">Science Lab/Physics</label>
                        </div>
                        <div class="card sica-fit-height">
                            <img class="img-fluid sica-fit-width" src="{{ asset('sica/assets/img/no-image.jpg') }}"
                                alt="Physics" />
                        </div>
                    </div>
                @endforelse
                @foreach ($organized_data['science_lab/chemistry']['images'] ?? [] as $image)
                    <div class="col-md-4 col-lg-4 mb-3">
                        <div class="form-check mb-3">
                            <input type="hidden" name="school_section[science_lab/chemistry]" value="0">
                            <input class="form-check-input checkbox-group" name="school_section[science_lab/chemistry]"
                                type="checkbox" value="2" id="defaultCheck10"
                                @if ($organized_data['science_lab/chemistry']['section_status'] == 2) checked @endif  @if($school_status_remarks_data && $school_status_remarks_data->status == 1) disabled @endif/>
                            <label class="form-check-label" for="defaultCheck10">Science Lab/Chemistry</label>
                        </div>
                        <div class="card sica-fit-height">
                            <a href="{{ asset('storage/' . $image['file_path']) }}" target="_blank">
                                <img class="img-fluid sica-fit-width" src="{{ asset('storage/' . $image['file_path']) }}"
                                    alt="Chemistry" />
                            </a>
                        </div>
                    </div>
                @endforeach
                @foreach ($organized_data['science_lab/biology']['images'] ?? [] as $image)
                    <div class="col-md-4 col-lg-4 mb-3">
                        <div class="form-check mb-3">
                            <input type="hidden" name="school_section[science_lab/biology]" value="0">
                            <input class="form-check-input checkbox-group" type="checkbox"
                                name="school_section[science_lab/biology]" value="2" id="defaultCheck11"
                                @if ($organized_data['science_lab/biology']['section_status'] == 2) checked @endif @if($school_status_remarks_data && $school_status_remarks_data->status == 1) disabled @endif />
                            <label class="form-check-label" for="defaultCheck11">Science Lab/Biology</label>
                        </div>
                        <a href="{{ asset('storage/' . $image['file_path']) }}" target="_blank">
                            <div class="card sica-fit-height">
                                <img class="img-fluid sica-fit-width" src="{{ asset('storage/' . $image['file_path']) }}"
                                    alt="Biology" />
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="row mb-3">
                <div class="col-md-12 col-lg-12 mb-1">
                    <label class="form-label" for="basic-default-message">Remarks</label>
                    <textarea id="basic-default-message" name="remarks" class="form-control" placeholder="Put Remarks Here" required @if($school_status_remarks_data && $school_status_remarks_data->status == 1) disabled @endif>@if ($school_status_remarks_data){{ $school_status_remarks_data->remarks }}@endif</textarea>
                </div>
                <div class="col-md-12 col-lg-12 mb-1">
                    <div class="mb-3">
                        <label for="defaultSelect" class="form-label">Action</label>
                        <select id="defaultSelect" name="status" class="form-select" @if($school_status_remarks_data && $school_status_remarks_data->status == 1) disabled @endif>
                            <option>Default select</option>
                            <option value="1" @if ($school_status_remarks_data && $school_status_remarks_data->status == 1) selected @endif>Verified</option>
                            <option value="2" @if ($school_status_remarks_data && $school_status_remarks_data->status == 2) selected @endif>Send Back To School
                            </option>
                        </select>

                    </div>
                </div>
                <div class="col-md-12 col-lg-12 mb-1">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" @if($school_status_remarks_data && $school_status_remarks_data->status == 1) disabled @endif>Send</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- Form END -->
    </div>
    <!---------Popup Images--------->
    {{-- <div class="popup" id="popup">
        <span class="close-button" id="closeButton">&times;</span>
        <img src="" alt="Popup Image" id="popupImage">
    </div> --}}
    <!---------Popup Images--------->
    <!-- / Content -->
    <script>
        $(document).ready(function() {
            $('#select-all').change(function() {
                $('.checkbox-group').prop('checked', $(this).prop('checked'));
            });

            $('.checkbox-group').change(function() {
                if (false == $(this).prop('checked')) {
                    $('#select-all').prop('checked', false);
                }
                if ($('.checkbox-group:checked').length == $('.checkbox-group').length) {
                    $('#select-all').prop('checked', true);
                }
            });
        });
        document.getElementById("select-all").addEventListener("change", function() {
            var checkboxes = document.querySelectorAll('.checkbox-group');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            var images = document.querySelectorAll('.image');
            var popup = document.getElementById('popup');
            var popupImage = document.getElementById('popupImage');
            var closeButton = document.getElementById('closeButton');

            // Add click event listeners to each image
            images.forEach(function(image) {
                image.addEventListener('click', function() {
                    // Check if popupImage is not null before setting its src property
                    if (popupImage) {
                        // Set the source of the popup image to the clicked image source
                        popupImage.src = this.src;
                    }

                    // Display the popup
                    popup.style.display = 'block';
                });
            });

            // Close the popup when clicking outside the image
            popup.addEventListener('click', function(e) {
                if (e.target !== popupImage && e.target !== closeButton) {
                    popup.style.display = 'none';
                }
            });

            // Close the popup when clicking on the close button
            closeButton.addEventListener('click', function() {
                popup.style.display = 'none';
            });
        });
    </script>
@endsection
