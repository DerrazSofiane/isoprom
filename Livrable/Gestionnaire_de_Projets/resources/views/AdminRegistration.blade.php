<html lang="en" class="full-height">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome/css/all.css') }}"><!-- fa emoticones-->
    {{-- <link rel="stylesheet" href="{{ asset('css/mdb.min.css') }}" crossorigin="anonymous"> --}}
    <style>
        .intro-2 {
            background: url("https://mdbootstrap.com/img/Photos/Slides/img%20(142).jpg")no-repeat center center;
            background-size: cover;
        }

        /*.top-nav-collapse {
    background-color: #3f51b5 !important;
}
.navbar:not(.top-nav-collapse) {
    background: transparent !important;
}
@media (max-width: 768px) {
    .navbar:not(.top-nav-collapse) {
        background: #3f51b5 !important;
    }
}*/
        .hm-gradient .full-bg-img {
            /*    background: -webkit-linear-gradient(45deg, rgba(83, 125, 210, 0.4), rgba(178, 30, 123, 0.4) 100%);
    background: -webkit-gradient(linear, 45deg, from(rgba(29, 236, 197, 0.4)), to(rgba(96, 0, 136, 0.4)));
    background: linear-gradient(to 45deg, rgba(29, 236, 197, 0.4), rgba(96, 0, 136, 0.4) 100%);
}
.rgba-gradient {*/
            background: -webkit-linear-gradient(45deg, rgba(0, 0, 0, 0.7), rgba(72, 15, 144, 0.4) 100%);
            background: -webkit-gradient(linear, 45deg, from(rgba(0, 0, 0, 0.7), rgba(72, 15, 144, 0.4) 100%)));
            background: linear-gradient(to 45deg, rgba(0, 0, 0, 0.7), rgba(72, 15, 144, 0.4) 100%);
        }

        .card {
            background-color: rgba(229, 228, 255, 0.2);
        }

        .md-form .prefix {
            font-size: 1.5rem;
            margin-top: 1rem;
        }

        .md-form label {
            color: #ffffff;
        }

        h6 {
            line-height: 1.7;
        }

        @media (max-width: 740px) {

            .full-height,
            .full-height body,
            .full-height header,
            .full-height header .view {
                height: 1040px;
            }
        }

        .btn_learnMore {
            position: relative;
            border: 2px solid #fff !important;
            padding: .84rem 2.14rem;
            /*background-color:rgba(255,255,255,0.2);*/
        }

        .btn_learnMore:action {
            color: red;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .animated {
            /* -webkit-animation-duration: 1s; */
            /* animation-duration: 1s; */
            -webkit-animation-fill-mode: both;
            /* animation-fill-mode: both; */
        }

    </style>
</head>

<body>

    <!--Main Navigation-->
    <header>

        <nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar">
            <div class="container">
                <a class="navbar-brand" href="#">
                    {{-- <img src="{{url('/')}}/C2A_light.png" width="60" height="40" alt="c2a" class="btn bg-secondary"
                    style="border-radius: 30%"> --}}
                    <strong>Bienvenu !</strong>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent-7" aria-controls="navbarSupportedContent-7"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                {{-- <div class="collapse navbar-collapse" id="navbarSupportedContent-7">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Lien</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                </ul>
                <form class="form-inline">
                    <div class="md-form mt-0">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                    </div>
                </form>
            </div> --}}
            </div>
        </nav>

        <!--Intro Section-->
        <section class="view intro-2 hm-gradient">
            <div class="full-bg-img">
                <div class="container flex-center">
                    <div class="d-flex align-items-center content-height">
                        <div class="row flex-center pt-5 mt-3">
                            <div class="col-md-6 text-center text-md-left mb-5">
                                <div class="text-light">
                                    <h1 class="h1-responsive font-weight-bold wow fadeInLeft" data-wow-delay="0.3s">
                                        Inscrivez-vous! </h1>
                                    <hr class="hr-light wow fadeInLeft" data-wow-delay="0.3s">
                                    <h6 class="wow fadeInLeft" data-wow-delay="0.3s">Bonjour Admin ! Veuillez créer votre compte avant de continuer.
                                    </h6>
                                    <br>
                                    <a class="btn btn-outline-white wow fadeInLeft animated btn_learnMore"
                                        data-wow-delay="0.3s" style="">Apprendre plus<b></b></a>
                                </div>

                                @if ($errors->any())
                                <hr>
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                            </div>

                            <div class="col-md-6 col-xl-5 offset-xl-1">
                                <form class="form-horizontal" method="POST" action="{{ route('admin.register.save') }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="card {{-- wow fadeInRight --}}" {{-- data-wow-delay="0.3s" --}}
                                        style="margin-bottom:10px;">
                                        <div class="card-body">
                                            <!--Header-->
                                            {{-- <div class="text-center">
		                                    <h3 class="text-light"><i class="fa fa-user text-light"></i> Inscription:</h3>
		                                    <hr class="hr-light">
		                                </div> --}}

                                            <!--Body-->
                                            <div class="md-form">
                                                <i class="fas fa-user-tie prefix text-light active"></i>
                                                <label for="name" class="active">NOM et Prénom *</label>
                                                <input type="text" id="name" name="name" class="form-control">
                                            </div>
                                            <div class="md-form">
                                                <i class="fa fa-envelope prefix text-light active"></i>
                                                <label for="email" class="active">Email *</label>
                                                <input type="email" id="email" name="email"
                                                    class="form-control required" required>
                                            </div>

                                            <div class="md-form">
                                                <i class="fa fa-lock prefix text-light active"></i>
                                                <label for="password" class="active">Mot de passe *</label>
                                                <input type="password" id="password" name="password"
                                                    class="form-control required" required>
                                            </div>

                                            <div class="md-form">
                                                <i class="fa fa-lock prefix text-light active"></i>
                                                <label for="password_confirmation" class="active">Confirmation du mot de
                                                    passe *</label>
                                                <input type="password" id="password_confirmation"
                                                    name="password_confirmation" class="form-control required" required>
                                            </div>

                                            <div class="md-form">
                                                {{-- <input type="textar" id="form6" class="form-control"> --}}
                                                <label for="comment" class="active">Commentaire *</label>
                                                <textarea id="comment" name="comment"
                                                    class="form-control active required" required cols="30"
                                                    rows="3"></textarea>
                                            </div>
                                            <div class="text-center">
                                                <button class="btn btn-primary" type="submit"
                                                    onclick="return checkForm();"
                                                    style="margin-top:10px;">S'inscrire</button>
                                                <hr class="hr-light mb-3 mt-4">

                                                <div class="inline-ul text-center d-flex justify-content-center">
                                                    <a class="m-2 p-2"><i class="fab fa-twitter text-light"></i></a>
                                                    <a class="m-2 p-2"><i class="fab fa-linkedin-in text-light">
                                                        </i></a>
                                                    <a class="m-2 p-2"><i class="fab fa-instagram text-light"> </i></a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </header>
    <div class="container">
        <div class="row py-5">
            <div class="col-md-12 text-center">
                <p>Cette plateforme est destiné à la gestion de projets (tâche, client planning, etc.).
                </p>

                <p>L'outil est encore en version ALPHA ! Si vous souhaitez nous dire un mot, <a href="#">contactez-nous ici</a>.</p>
                <br><br>
                <b>DIGIFAB</b>
                <br><br>
                <b>Fait avec amour par Abdessamad & Sofiane DERRAZ</b>

            </div>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    {{-- <script src="{{ asset('js/mdb.min.js') }}" crossorigin="anonymous"></script> --}}
    <script>
        function checkForm() {
            if ($('form #password').val() != $('form #password_confirmation').val()) {
                alert("Erreur: le mot de passe ne correspond pas !");
                // form.password.focus();
                $('form #password').val('');
                $('form #password_confirmation').val('');
                return false;
            }
            return true;
        }
        // Animations init
        // new WOW().init();

    </script>
</body>

</html>
