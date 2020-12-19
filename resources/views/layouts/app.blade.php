<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Task') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    {!!Html::style('storage/css/font-awesome.min.css')!!}
    <!-- Parsley Form Validation -->
    {!!Html::style('storage/css/parsley.css')!!}
</head>
<body>
    @include('inc.navbar')

    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-95">
            @include('inc.messages')
            @yield('content')
        </div>
        <div class="col-md-2">

        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Parsley Form Validation -->
    {!!Html::script('storage/js/parsley.min.js')!!}
    <!-- ckeditor -->
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
    <!-- DataTable -->
    {!!Html::script('storage/js/jquery.dataTables.min.js')!!}
    {!!Html::script('storage/js/dataTables.bootstrap.min.js')!!}
    <script>
        $('.table').dataTable();
    </script>
</body>
</html>
