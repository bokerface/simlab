<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/logo.png" rel="icon">
    <title>RuangAdmin - Dashboard</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="{{ url('/') }}">
                                <span class="ml-2 d-none d-lg-inline small mr-2">
                                    Kembali ke aplikasi
                                </span>
                                <i class="fas fa-sign-out-alt"></i>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Container Fluid-->
                <div class="container-fluid mb-5" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-center">
                        <h1 class="h3 mb-0 text-gray-800 mt-3">{{ $survey->survey_name }}</h1>
                    </div>
                    <div class="d-sm-flex align-items-center justify-content-center mb-4">
                        <p>{{ $survey->survey_description }}</p>
                    </div>

                    <div class="row mb-3">
                        <form action="{{ url('survey') }}" enctype="multipart/form-data" method="POST"
                            class="col-12">
                            <div class="col-9 mx-auto">
                                <ul class="list-group">
                                    @csrf
                                    <input type="hidden" name="survey_id" value="{{ $survey->id_survey }}">
                                    @foreach($daftar_pertanyaan as $pertanyaan)
                                        <li class="list-group-item mb-2">
                                            <p><b>{{ $pertanyaan['pertanyaan'] }}</b></p>
                                            <div class="mx-3">
                                                @if(!empty( $pertanyaan['jawaban']))
                                                    {!! $pertanyaan['jawaban'] !!}
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                <input type="submit" value="submit" class="btn btn-primary btn-lg">
                            </div>
                        </form>
                    </div>
                    <!--Row-->
                </div>
                <!---Container Fluid-->
            </div>
        </div>
    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
</body>

</html>
