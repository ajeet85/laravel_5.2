<!doctype html>
<!--[if lt IE 7]>   <html  ng-app="ProvisionTracker" lang="en" class="lt-ie9 lt-ie8 lt-ie7 no-media-queries no-js no-position-fixed"> <![endif]-->
<!--[if IE 7]>      <html  ng-app="ProvisionTracker" lang="en" class="lt-ie9 lt-ie8 no-media-queries no-js no-position-fixed""> <![endif]-->
<!--[if IE 8]>      <html  ng-app="ProvisionTracker" lang="en" class="lt-ie9 no-media-queries no-js"> <![endif]-->
<!--[if gt IE 8]><!--><html  ng-app="ProvisionTracker" lang="en" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <title>Provision Tracker - @yield('title')</title>
  <meta name="description" content="">
  <meta name="author" content="Provision Tracker">
  <meta name="keywords" content="">
  <meta name="robots" content="index, follow">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="stylesheet" href="{{ url('/css/main.css')}}">
  <script src="{{ url('/js/modernizr/modernize.js') }}"></script>

</head>
<body class="app">
    <div class="app-sidebar">
        <div class="branding-area">
            <div class="logo">
                <img src="img/product-logos/logo-transparent.png" alt="null" />
            </div>
        </div>
        <nav class="app-navigation">
            <ul>
                @include('components.main-nav.root-item', ['label'=>'Organisations', 'link'=>'/app/orgs', 'slug'=>'orgs',
                        'submenu'=>'components.main-nav.organisations', 'icon'=>'fa-graduation-cap'])
                @include('components.main-nav.root-item', ['label'=>'Manage', 'link'=>'/app/manage', 'slug'=>'manage',
                        'submenu'=>'components.main-nav.manage', 'icon'=>'fa-plus-circle'])
                @include('components.main-nav.root-item', ['label'=>'Schedule', 'link'=>'/app/schedule', 'slug'=>'schedule',
                        'icon'=>'fa-calendar'])
                @include('components.main-nav.root-item', ['label'=>'Reporting', 'link'=>'/app/reporting', 'slug'=>'reporting',
                        'icon'=>'fa-line-chart'])
                @include('components.main-nav.root-item', ['label'=>'Settings', 'link'=>'/app/settings', 'slug'=>'settings',
                        'submenu'=>'components.main-nav.settings', 'icon'=>'fa-cog'])
            </ul>
        </nav>
    </div>

    <div class="app-content">
        <div class="menu-bar">
            <div class="utility-area">
                @include('components.user.current')
                @include('components.orgs.switcher')
                @include('components.logout.button')
                @include('components.account.switcher')
            </div>

            <div class="title-area">
                @yield('title-area')
            </div>

            <div class="functions-area">
                <div class="filter-area">@yield('filter-area')</div>
                <div class="action-area">@yield('action-area')</div>
            </div>
        </div>

        <div class="content-area @yield('content-area-class')">
            @yield('content-area')
        </div>

    </div>

    <script src="{{ url('/js/angular/angular.js')}}"></script>
    <script src="{{ url('/js/angular/angular-animate.js')}}"></script>
    <script src="{{ url('/js/angular/angular-aria.js')}}"></script>
    <script src="{{ url('/js/angular/angular-message.js')}}"></script>
    <script src="{{ url('/js/angular/angular-material.js')}}"></script>

    <script src="{{ url('/js/provisiontracker/app.js')}}"></script>
    <script src="{{ url('/js/provisiontracker/components/select/directive.js')}}"></script>
    <script src="{{ url('/js/provisiontracker/components/button/directive.js')}}"></script>
    @yield('angular-area')
</body>
</html>
