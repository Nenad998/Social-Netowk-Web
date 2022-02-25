<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .center-block {
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-top: 20vh;
        }
        .form-login{
            padding-top: 16vh;
        }
        .boja{
            background: #eeeee4;
            padding: 20px;
        }

    </style>
    <title>Document</title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('images/home_image.jpg') }}" class="center-block">
        </div>
        <div class="col-md-6 form-login">
            <form class="boja" action="/loginNenad" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email">
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password">
                    <a href="#">Forgot password?</a>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
