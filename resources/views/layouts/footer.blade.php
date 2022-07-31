<script src="{{ asset('/assets/js/core/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('/assets/js/core/bootstrap.min.js') }}"></script>
{{-- <script src="{{ asset('/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/chartjs.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/choices.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/quill.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/flatpickr.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/dropzone.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/dragula/dragula.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/perfect-scrollbar.min.js') }}"></script> --}}

<script>
    if (document.querySelector(".datetimepicker")) {
        flatpickr(".datetimepicker", {
            allowInput: true
        , }); // flatpickr
    };
    Dropzone.autoDiscover = false;
    var drop = document.getElementById("dropzone");
    var myDropzone = new Dropzone(drop, {
        url: "/file/post"
        , addRemoveLinks: true
    , });

    if (document.getElementById("editor")) {
        var quill = new Quill("#editor", {
            theme: "snow", // Specify theme in configuration
        });
    }

</script>
<script>
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
        var options = {
            damping: "0.5"
        , };
        Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }

</script>

<script async defer src="https://buttons.github.io/buttons.js"></script>

<script src="{{ asset('/assets/js/material-dashboard.min.js?v=3.0.5') }}"></script>
