<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Library</title>
    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/aa6076f641.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset("css/style.css")}}">
    <link rel="stylesheet" href="{{asset("css/responsive.css")}}">

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg  navbar-dark bg-dark ">
        <div class="container">

            <a class="navbar-brand" href="/">
                <h3>LIBRARY <i class="fa fa-book" aria-hidden="true"></i></h3>
            </a>
            <button class="navbar-toggler  " type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon  ">
                    <i class="fa-solid color-blue fa-bars"></i>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mb-2 mb-lg-0">

                    @auth
                        <li class="nav-item ml-1 ">
                            <a class="nav-link  active  " href="/home">
                                HOME
                            </a>
                        </li>


                        @if(Auth::user()->role_id == $librarianRoleId->id)
                            <li class="nav-item ml-1 ">
                                <a class="nav-link  active  " href="/users">
                                    USERS
                                </a>
                            </li>
                            <li class="nav-item ml-1 ">
                                <a class="nav-link  active  " href="/users">
                                    AUTHORS
                                </a>
                            </li>
                            <li class="nav-item ml-1 ">
                                <a class="nav-link  active  " href="/users">
                                    BOOKS
                                </a>
                            </li>
                        @endif
                        <li class="nav-item  ml-1 ">
                            <a class="nav-link  active  logout" href="/">
                                LOGOUT <i class="fa fa-sign-out" aria-hidden="true"></i>

                            </a>
                        </li>

                        <form id="logout-form" action="{{ route('logout-form') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endauth
                    @guest
                        <li class="nav-item  ml-1 ">
                            <a class="nav-link  active " href="/">
                                HOME
                            </a>
                        </li>
                        <li class="nav-item  ml-1 ">
                            <a class="nav-link active  " href="/login">
                                LOGIN <i class="fa-solid fa-right-to-bracket"></i>
                            </a>
                        </li>
                    @endguest
                </ul>

            </div>
        </div>
    </nav>
    <header></header>
    <main>
        @yield('content')

    </main>
    <footer class="bg-dark"><br>
        <div class="container">
            <div class="row">
                <div class="col-6 d-flex align-items-center"><h5 class="text-light">Library </h5></div>
                <div class="col-6 text-right d-flex align-items-center justify-content-end"><p class="text-light">© 2023
                        COPYRIGHT : VUK ZDRAVKOVIĆ</p></div>
            </div>
        </div>
    </footer>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

<script src="{{ mix('/js/app.js') }}"></script>

<script>
    $(document).ready(function (){
        $(".logout").click(function (e){
            e.preventDefault()
            $("#logout-form").submit();
        })
    })
</script>
</body>
</html>
