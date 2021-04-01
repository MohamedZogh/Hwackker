<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hwackker</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;1,200;1,300;1,400;1,600;1,700;1,800" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <link href="https://rawgit.com/shprink/BttrLazyLoading/master/dist/bttrlazyloading.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="https://rawgit.com/shprink/BttrLazyLoading/master/dist/jquery.bttrlazyloading.js"></script>
    <script>
        $(function() {
            $('.bttrlazyloading').bttrlazyloading({
                delay: 500
            });
        });
    </script>
</head>

<body class="antialiased">
    @yield('content')
</body>

</html>