<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Laravel Todo App with Vue</title>
    <!-- Fonts -->
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/lumen/bootstrap.min.css" rel="stylesheet">
    <link href="{{mix('css/app.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>
<body>
    <div id="app">
        <navbar :routes="routes"></navbar>
        <div class="container pt-3">
            <router-view></router-view>
        </div>
    </div>
    <script src="{{mix('js/app.js')}}"></script>
</body>
</html>
