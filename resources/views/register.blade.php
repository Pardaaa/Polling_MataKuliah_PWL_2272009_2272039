<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    {{--  CSS Bootstrap  --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{--  Google Font  --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        html,body {
            height: 100%;
            background-color: coral;
            font-family: "Roboto";
        }

        .global-container {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-form {
            width: 380px;
            height: 450px;
            padding: 20px;
            background-color: tomato  !important;
            border-radius: 10px;
            color: white;
            box-shadow: 0px 3px 15px lightcoral;
        }

        input[type="email"],
        input[type="password"] {
            border: 2px solid red;
            border-radius: 10px;
            margin-bottom: 40px;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border: none;
            background: lightgrey;
            color: black;
            font-size: 16px;
        }

        .btn {
            margin-top: 20px;
            background: white;
            color: black;
            font-size: 15px;
            font-weight: bold;
            border: 2px solid red;
        }

        a {
            color: black;
            text-decoration: none;
        }

    </style>
</head>
<body>
<div class="global-container">
    <div class="card login-form">
        <div class="card-body">
            <h1 class="card-title text-center">REGISTER</h1>
        </div>
        <div class="card-text">
            <form>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn register"><a href="{{ route('route-register') }}">Register</a></button>
                </div>

            </form>
        </div>
    </div>
</div>



{{--  JS Bootstrap  --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
