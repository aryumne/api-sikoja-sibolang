<nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3 navbar-transparent mt-4">
    <div class="container">
        <a class="navbar-brand font-weight-bolder text-white ms-lg-0 ms-3" href="{{ route('admin') }}">
            SIKOJA
        </a>
        <div class="row">
            <div class="col-12 d-md-none d-block">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center ms-lg-4">
                    <div class="input-group input-group-outline">
                        <input type="text" class="form-control text-warning" placeholder="search">
                    </div>
                </div>
            </div>
        </div>

        <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0" id="navigation">
            <ul class="navbar-nav navbar-nav-hover mx-auto">
                <li class="nav-item dropdown dropdown-hover mx-2">
                    <a class="nav-link ps-2 d-flex justify-content-between cursor-pointer align-items-center  text-lg-white" style="font-weight:500" href="#">
                        TENTANG SIKOJA
                    </a>
                </li>
                <li class="nav-item dropdown dropdown-hover mx-2 ">
                    <a class="nav-link ps-2 d-flex justify-content-between cursor-pointer align-items-center  text-lg-white" style="font-weight:500" href="#">
                        DATA PENGADUAN
                    </a>
                </li>
                <li class="nav-item dropdown dropdown-hover mx-2 d-md-none d-block">
                    <a class="btn btn-sm mb-0 btn-outline-warning" style="font-weight:500" href="{{ route('login') }}">
                        Masuk
                    </a>
                    <a class="btn btn-sm mb-0 btn-warning" style="font-weight:500" href="#">
                        Daftar
                    </a>
                </li>
            </ul>
            <div class="ms-md-auto pe-md-3 d-flex align-items-center ms-lg-4">
                <div class="input-group input-group-outline">
                    <input type="text" class="form-control text-warning" placeholder="search">
                </div>
            </div>
            <ul class="navbar-nav d-lg-block d-none">
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="btn btn-sm mb-0 btn-outline-white me-2">Masuk</a>

                </li>
            </ul>
            <ul class="navbar-nav d-lg-block d-none">
                <li class="nav-item">
                    <a href="#" class="btn btn-sm mb-0 btn-white">Daftar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
