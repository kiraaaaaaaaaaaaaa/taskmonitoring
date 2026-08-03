<!doctype html>


<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Sign In | Task Monitoring</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />


</head>

<style>
        :root {
            --bs-dark-green: #0b3c29;
            --bs-medium-green: #134e38;
            --bs-golden-yellow: #d4af37;
            --bs-golden-yellow-light: #fef9e7;
            --bs-light-bg: #f4f7f5;
        }

        body {
            background-color: var(--bs-light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-card {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 1rem 3rem rgba(11, 60, 41, 0.08);
            background-color: #ffffff;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .auth-header-bg {
            background: linear-gradient(135deg, var(--bs-dark-green), var(--bs-medium-green));
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
        }

        .auth-header-bg::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 6px;
            background-color: var(--bs-golden-yellow);
        }

        .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            border: 1px solid #dee2e6;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--bs-dark-green);
            box-shadow: 0 0 0 0.25rem rgba(11, 60, 41, 0.15);
        }

        .btn-theme-primary {
            background-color: var(--bs-dark-green);
            color: white;
            border-radius: 0.75rem;
            padding: 0.75rem;
            font-weight: 600;
            border: none;
            transition: background-color 0.2s;
        }

        .btn-theme-primary:hover {
            background-color: var(--bs-medium-green);
            color: white;
        }

        .btn-google {
            border-radius: 0.75rem;
            padding: 0.75rem;
            font-weight: 600;
            border: 1px solid #dee2e6;
            background-color: #ffffff;
            color: #333;
            transition: background-color 0.2s;
        }

        .btn-google:hover {
            background-color: #f8f9fa;
        }

        .form-check-input:checked {
            background-color: var(--bs-dark-green);
            border-color: var(--bs-dark-green);
        }

        /* Action Bar */
        .action-bar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 12px 30px;
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .btn-action-download {
            background-color: var(--bs-golden-yellow);
            color: var(--bs-dark-green);
            border-radius: 50px;
            padding: 8px 22px;
            font-weight: 700;
            border: none;
        }
        .btn-action-download:hover {
            background-color: #c19e31;
            color: var(--bs-dark-green);
        }
    </style>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="index.html" class="d-inline-block auth-logo">
                                    <img src="assets/images/logo-light.png" alt="" height="20">
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5 col-xl-4">
                
                <div class="card auth-card">
                    <div class="auth-header-bg">
                        <h4 class="fw-bold text-white mb-1">BRO Task Monitoring</h4>
                        <p class="text-white-50 mb-0 fs-14">Sign in to continue to your dashboard</p>
                    </div>

                    <div class="card-body p-4 p-lg-5">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold fs-13 text-secondary">Username or Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted"><i class="ri-user-line"></i></span>
                                    <input type="text" class="form-control border-start-0 ps-0" name="email" id="email" placeholder="Enter username" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label fw-semibold fs-13 text-secondary mb-0" for="password-input">Password</label>
                                    <a href="auth-pass-reset-basic.html" class="text-muted fs-12 text-decoration-none text-hover-success">Forgot password?</a>
                                </div>
                                <div class="position-relative auth-pass-inputgroup">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted"><i class="ri-lock-password-line"></i></span>
                                        <input type="password" class="form-control border-start-0 border-end-0 ps-0 password-input" name="password" placeholder="Enter password" id="password-input" required>
                                        <button class="btn btn-light bg-light border border-start-0 rounded-end-3 text-muted shadow-none password-addon" type="button" id="password-addon">
                                            <i class="ri-eye-fill align-middle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 form-check">
                                <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                <label class="form-check-label fs-13 text-muted" for="auth-remember-check">Remember me</label>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-theme-primary w-100 shadow-sm" type="submit">Sign In</button>
                            </div>

                            <div class="text-center my-3 text-muted fs-12 text-uppercase">
                                <span class="bg-white px-2">Or connect with</span>
                            </div>

                            <div>
                                <a href="{{ route('google.login') }}" class="btn btn-google w-100 d-flex align-items-center justify-content-center gap-2 shadow-sm">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" width="18">
                                    <span>Sign in with Google</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->

        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="assets/js/plugins.js"></script>

    <!-- particles js -->
    <script src="assets/libs/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="assets/js/pages/particles.app.js"></script>
    <!-- password-addon init -->
    <script src="assets/js/pages/password-addon.init.js"></script>
</body>

</html>
