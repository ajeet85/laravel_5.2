<!doctype html>
<!--[if lt IE 7]>   <html  ng-app="ProvisionTracker" lang="en" class="lt-ie9 lt-ie8 lt-ie7 no-media-queries no-js no-position-fixed"> <![endif]-->
<!--[if IE 7]>      <html  ng-app="ProvisionTracker" lang="en" class="lt-ie9 lt-ie8 no-media-queries no-js no-position-fixed""> <![endif]-->
<!--[if IE 8]>      <html  ng-app="ProvisionTracker" lang="en" class="lt-ie9 no-media-queries no-js"> <![endif]-->
<!--[if gt IE 8]><!--><html  ng-app="ProvisionTracker" lang="en" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <base href="http://192.168.99.100:3000">
  <title>Provision Tracker - @yield('title')</title>
  <meta name="description" content="">
  <meta name="author" content="Provision Tracker">
  <meta name="keywords" content="">
  <meta name="robots" content="index, follow">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="stylesheet" href="/css/main.css">

</head>
<body class="app">
    <div class=" @yield('content-area-class')">
        @yield('content-area')
    </div>
</body>
</html>
