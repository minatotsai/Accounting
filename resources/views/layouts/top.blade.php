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

<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="{{route('companys.index')}}">店家列表</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('contents.index')}}">查詢清單</a>
      </li>
  </div>
</nav>

<div class="container-fluid">
    @yield('bottom')
</div>

</body>
</html>