<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Snack Store API Challenge</title>
  <style type="text/css">
    @import  url('https://fonts.googleapis.com/css?family=Dosis:300,400,700|Open+Sans:300,600,700');
    @import  url('{{mix('css/app.css')}}');
  </style>
</head>
<body class="font-body">
  <div id="app"></div>
  <script src="{{mix('js/app.js')}}"></script>
</body>
</html>
