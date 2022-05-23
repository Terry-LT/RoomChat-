<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
</head>
<body>
    
    @auth
    <script>
        window.Laravel = {!!json_encode([
            'isLoggedin' => true,
            'user' => Auth::user()
        ])!!}
    </script>
    @endauth

    @guest
    <script>
        window.Laravel = {!!json_encode([
            'isLoggedin' => false
        ])!!}
    </script>
    @endguest
    
    <div id="app">
        <!--Content-->
        <router-view></router-view>
    </div>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{mix('js/app.js')}}"></script>
</body>
</html>