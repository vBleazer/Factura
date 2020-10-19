<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    
    @include('layouts.head')
    @yield('head')
    
</head>
<body>
    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>
    @include('layouts.scripts')
    @yield('scripts')
</body>
</html>

