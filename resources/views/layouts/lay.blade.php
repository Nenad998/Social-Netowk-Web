<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <title>Document</title>
</head>
<body>
<div class="container fluid">
<div class="row">
    <div class="col-md-6">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShfS0OF8apDo9E4cJphlcqK_H2Gmj65Q4AsA&usqp=CAU" width="180" height="60">
        <p class="navbar-brand" style="display: inline-block; font-size: 25px"><a  href="/user/dashboard" style="text-decoration: none; color: #1a202c"> Dashboard</a></p>
    </div>
{{--    @dd(auth()->user()->unreadNotifications['0']->notifiable_id)--}}
    <div class="col-md-2">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 19px; color: #2d3748">
                    Notifications
                </a>
                <ul class="dropdown-menu dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                    @if(\Illuminate\Support\Facades\Auth::check())
            {{--      <p>numbers: {{ auth()->user()->unreadNotifications->count() }}</p>     --}}

                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <p><a href="/user/markAsRead">Mark as read</a></p>
                        @else
                            <p>Notifications does't exist</p>
                        @endif

                        @foreach(auth()->user()->unreadNotifications as $notification)
                            <p><b>{{ $notification->data['user_name'] }}</b> liked your post</p>
                        @endforeach
                    @endif
                </ul>
            </li>
        </ul>
    </div>
    <div class="col-md-4">

        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 19px; color: #2d3748">
                    @if(Auth::user()) Welcome <a href="/user/profile/{{ Auth::user()->slug }}">{{ Auth::user()->name }}</a> @endif
                </a>
                <ul class="dropdown-menu dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                    @if(Auth::user())  <li><form method="post" action="/logout">@csrf <button class="dropdown-item">Logout</button></form></li>  @endif
                </ul>
            </li>
        </ul>
    </div>
</div>
<hr>

@yield('content')

</div>
</body>
</html>
