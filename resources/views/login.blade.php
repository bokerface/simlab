<!DOCTYPE html>
<html lang="en">

<!-- Copyright (c) 2019 Indri Junanda (https://github.com/indrijunanda/RuangAdmin) -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/logo.png" rel="icon">
    <title>RuangAdmin - Login</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-login">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-5 col-sm-6">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">

                                    <div class="text-center">
                                        <img class="mb-3" src="{{ URL::to('/') }}/img/logo/logoumy.png" />
                                        <h1 class="h4 text-gray-900 mb-4">Login SIM Praktikum</h1>
                                    </div>

                                    @if ($errors->any())
                                    <x-alert :type="$errors->first('type')" :message="$errors->first('message')" />
                                    @endif

                                    <form class="user" method="POST" action="{{ url('/login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control"
                                                placeholder="Username or email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control"
                                                placeholder="Password">
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="admin" value="1"
                                                id="sso">
                                            <label class="form-check-label small" for="sso">
                                                login sebagai admin
                                            </label>
                                        </div>
                                        <div class="form-group">

                                            {{-- <button class="btn btn-primary">
                                                <span class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true">
                                                </span>
                                                logging in
                                            </button> --}}

                                            <input type="submit" value="Login" class="btn btn-primary btn-block">
                                        </div>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="font-weight-bold small" href="register.html">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>

</body>

</html>