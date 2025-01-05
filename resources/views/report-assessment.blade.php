<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="assets/"
    data-template="vertical-menu-template-free"
>
@include('includes.head')

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">

            @include('includes.nav')

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">Assessment to utilize Paras/Qaida/Translation of Holy Quran for Next Academic Session 2024-25</h4>
                    @if($errors->any())
                        <div class="alert alert-danger error">{{ $errors->first('link') }}</div>
                    @endif
                    @if(Request::is('report-assessment'))
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <a href="{{url('download-assessment')}}" class="btn btn-primary text-right">Download Data</a>
                            </div>
                        </div>
                    @endif
                    <!-- Basic Layout & Basic with Icons -->
                    <div class="row">
                        <!-- Basic Layout -->
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Report Info</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-form-label" for="basic-default-name">Total Submitted Schools</label>
                                                <div class="col-md-8 col-form-label">
                                                    <label>{{$total_submitted}}</label>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!----END COL---->

                        @yield('content')
                    </div>
                </div>
                <!-- / Content -->

                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0">
                            © Designed & Developed by PMIU Data Center <script>
                                document.write(new Date().getFullYear());
                            </script>
                        </div>
                    </div>
                </footer>
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<!-- / Content -->

<!-- Core JS -->
@include('includes.js')

</body>
</html>

