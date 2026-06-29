<!DOCTYPE html>
<html lang="en">
    <head>
        @include('partials.head')
    </head>

    <body class="bg-slate-50 font-sans text-slate-900 antialiased overflow-x-hidden">
        @include('partials.navbar')
        <main>
            @yield('content')
        </main>
        @include('partials.footer')
        @include('partials.scripts')
    </body>
</html>
