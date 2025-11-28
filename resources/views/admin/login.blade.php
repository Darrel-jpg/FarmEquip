<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="wave"> <span></span> <span></span> <span></span>
    <div class="container" id="container"> <!-- Form Login -->
        <div class="form-box login">
            <form method="POST" action="{{ route('admin.login') }}"> @csrf <h1>Login</h1>
                <div class="input-box"> <input type="text" name="username" placeholder="Username" autocomplete="off"
                        required> <i class="fa-solid fa-user"></i> </div>
                <div class="input-box"> <input type="password" name="password" placeholder="Password"
                        id="login-password" required> <i class="fa-solid fa-eye-slash toggle-password"
                        data-target="login-password"></i> </div>
                <div class="remember-box"
                    style="display: flex; align-items: center; justify-content: space-between; margin-top: -10px; margin-bottom: 15px;">
                    <label style="font-size: 14px; color: #333;"> <input type="checkbox" name="remember"
                            style="margin-right: 6px;"> Remember Me </label>
                </div> <button type="submit" name="login" class="btn">Login</button>
            </form>
        </div> <!-- Panel toggle -->
        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Hello, Welcome</h1>
            </div>
        </div>
    </div>
    @if (session('error'))
    <div id="flash-alert" class="alert-error"> {{ session('error') }} </div>
    @elseif (session('success'))
    <div id="flash-alert" class="alert-success"> {{ session('success') }} </div>
    @endif
    <script src="/js/login_register.js"></script>
</body>

</html>