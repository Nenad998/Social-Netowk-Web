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
        .form-register{
            margin-top: 10vh;
        }
    </style>
    <title>Document</title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('images/home_image.jpg') }}" class="center-block">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4>Already have account?</h4>
                    <a class="btn btn-primary w-50" href="/customLogin" role="button">Login</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <form class="form-register" action="/registerNenad" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">First and Last Name</label>
                    <input type="text" class="form-control" name="name">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email">
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation">
                </div>

                <div class="mb-3">
                    <label  class="form-label">Choose gender</label>
                    <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" name="gender">
                        <option>Choose gender</option>
                        <option>male</option>
                        <option>female</option>
                    </select>
                </div>
                <div class="custom-file">
                    <label  class="form-label">Choose image</label>
                    <input type="file" name="image" class="custom-file-input form-control">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Register</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>

