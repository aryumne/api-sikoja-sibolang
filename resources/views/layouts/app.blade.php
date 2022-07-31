<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
</head>
<body class="bg-gray-200">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0" style="display: none; visibility: hidden"></iframe></noscript>

    {{-- NavBar --}}
    @include('layouts.navbar')

    <main class="main-content mt-0">
        <div class="page-header align-items-start min-height-500 m-3 border-radius-xl" style="
          background-image: url('{{ asset('assets/img/bg-landing.jpg') }}');
        ">
            <span class="mask bg-gradient-dark opacity-6"></span>
        </div>
        <div class="container-fluid mb-4">
            {{-- Main Content --}}
            <div class="row mt-lg-n15 mt-md-n20 mt-xs-n20 mt-n12 justify-content-center">
                @yield('content')
            </div>
        </div>

        {{-- Footer --}}
        <footer class="footer position-bottom py-2 w-100">
            <div class="container-fluid">
                <div class="row  align-items-end justify-content-center">
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear())

                    </script>, SIKOJA, All rights reserved.
                </div>
            </div>
        </footer>
    </main>

    @include('layouts.footer')
    @yield('customjs')
</body>
</html>
