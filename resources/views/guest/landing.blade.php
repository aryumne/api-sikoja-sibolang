@extends('layouts.app')
@section('content')
<div class="col-12 mx-auto">
    <div class="row mt-lg-n8 mt-md-n8 mt-xs-n9 mt-n9 ">
        <div class="col-12 col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-warning shadow-warning border-radius-lg py-3 pe-1 text-center py-4">
                        <h4 class="font-weight-bolder text-white mt-1">Sampaikan Pengaduan Anda</h4>
                        <p class="mb-1 text-white text-sm">Laporan kerusakan jalan!</p>
                    </div>
                </div>
                <div class="card-body pb-3">
                    <form role="form">
                        <div class="input-group input-group-static">
                            <label>Nama Lengkap <strong class="text-danger">*</strong></label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="input-group input-group-static mt-3">
                            <label>Nomor HP <strong class="text-danger">*</strong></label>
                            <input type="text" class="form-control" placeholder="0800 0000 0000">
                        </div>
                        <div class="input-group input-group-static mt-3">
                            <label>Judul Pengaduan <strong class="text-danger">*</strong></label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="input-group input-group-static mt-3">
                            <label>Keterangan Pengaduan <strong class="text-danger">*</strong></label>
                            <textarea type="text" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="input-group input-group-static mt-3">
                            <label>Kampung <strong class="text-danger">*</strong></label>
                            <select class="form-control" name="choices-button" id="choices-button" placeholder="Departure">
                                <option value="Choice 1" selected="">Manokwari Barat</option>
                                <option value="Choice 2">Sanggeng</option>
                                <option value="Choice 3">Amban</option>
                                <option value="Choice 4">Wosi</option>
                                <option value="Choice 5">Arfai</option>
                                <option value="Choice 6">Andai</option>
                                <option value="Choice 7">Reremi</option>
                                <option value="Choice 8">Borasi</option>
                            </select>
                        </div>
                        <div class="input-group input-group-static mt-3">
                            <label>Jalan <strong class="text-danger">*</strong></label>
                            <select class="form-control" name="choices-button" id="choices-button" placeholder="Departure">
                                <option value="Choice 1" selected="">JL Manokwari Barat</option>
                                <option value="Choice 2">JL Sanggeng</option>
                                <option value="Choice 3">JL Amban</option>
                                <option value="Choice 4">JL Wosi</option>
                                <option value="Choice 5">JL Arfai</option>
                                <option value="Choice 6">JL Andai</option>
                                <option value="Choice 7">JL Reremi</option>
                                <option value="Choice 8">JL Borasi</option>
                            </select>
                        </div>
                        <div class="input-group input-group-static mt-4">
                            <label for="exampleFormControlSelect1" class="ms-0">Kategori </label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>Kategori 1</option>
                                <option>Kategori 2</option>
                                <option>Kategori 3</option>
                                <option>Kategori 4</option>
                                <option>Kategori 5</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-dark w-100 my-4">Lapor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row bg-gradient-dark mt-5 text-center border-radius-2">
        <div class="col-12 mx-auto py-5">
            <h4 class="text-white">JUMLAH PENGADUAN SEKARANG</h4>
            <h1 class="font-weight-bolder text-warning" id="state1" countTo="23980"></h1>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-lg-6 mx-auto">
            <div class="card mt-4">
                <!-- Card image -->
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <img class="border-radius-lg w-100" src="https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" alt="Image placeholder">
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <h4 class="font-weight-normal mt-3">Judul Pengaduan </h4>
                    <span class="badge badge-warning">waiting</span>
                    <small>Oleh: Aryum Nining Erliandi, <i>Tanggal: 30 Juli 2022. </i></small>
                    <p class="card-text mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis non dolore est fuga nobis ipsum illum eligendi nemo iure repellat, soluta, optio minus ut reiciendis voluptates enim impedit veritatis officiis.</p>
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Progress Pengaduan
                    </button>
                </div>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                    </div>
                </div>
            </div>
            <div class="card mt-5">
                <!-- Card image -->
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <img class="border-radius-lg w-100" src="https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" alt="Image placeholder">
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <h4 class="font-weight-normal mt-3">Judul Pengaduan </h4>
                    <span class="badge badge-warning">waiting</span>
                    <small>Oleh: Aryum Nining Erliandi, <i>Tanggal: 30 Juli 2022. </i></small>
                    <p class="card-text mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis non dolore est fuga nobis ipsum illum eligendi nemo iure repellat, soluta, optio minus ut reiciendis voluptates enim impedit veritatis officiis.</p>
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Progress Pengaduan
                    </button>
                </div>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection

@section('customjs')
<script src=" {{ asset('/assets/js/plugins/choices.min.js') }}">
</script>
<script src="{{ asset('/assets/js/plugins/countup.min.js') }}"></script>
<script>
    if (document.getElementById('choices-button')) {
        var element = document.getElementById('choices-button');
        const example = new Choices(element, {});
    }

</script>
<script>
    if (document.getElementById('state1')) {
        const countUp = new CountUp('state1', document.getElementById("state1").getAttribute("countTo"));
        if (!countUp.error) {
            countUp.start();
        } else {
            console.error(countUp.error);
        }
    }
    if (document.getElementById('state2')) {
        const countUp = new CountUp('state2', document.getElementById("state2").getAttribute("countTo"));
        if (!countUp.error) {
            countUp.start();
        } else {
            console.error(countUp.error);
        }
    }
    if (document.getElementById('state3')) {
        const countUp = new CountUp('state3', document.getElementById("state3").getAttribute("countTo"));
        if (!countUp.error) {
            countUp.start();
        } else {
            console.error(countUp.error);
        }
    }
    if (document.getElementById('state4')) {
        const countUp = new CountUp('state4', document.getElementById("state4").getAttribute("countTo"));
        if (!countUp.error) {
            countUp.start();
        } else {
            console.error(countUp.error);
        }
    }

</script>
@endsection
