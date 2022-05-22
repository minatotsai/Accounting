<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side</title>
    <!-- css -->
    <link rel="stylesheet" href={{ asset('css/style.css') }}>
    <!-- js -->
    <script scr="{{ asset('js/script.js') }}"></script>
    <!-- JQuery -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script> -->
    <!-- bootstrap -->
    <link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }}>
</head>
<body>
<div class="container-all">
    <!-- left side narbar -->
    <div class="container-left">
        <nav id ="sidebar">
            <!-- list -->
            <ul class="list-unstyled">
                <p>計算器</p>
                <li>
                    <a href="{{route('companys.index')}}">店家列表</a>
                </li>
                <li>
                    <a href="{{route('contents.index')}}">查詢清單</a>
                </li>
                <li>
                    <a href="#c">暫定</a>
                </li>
        
            </ul>
        </nav>
    </div>
    <!-- right -->
    <div class="container-right">
        <div class="container-fluid">
            @yield('right')
        </div>
    </div>
</div>
</body>
</html>