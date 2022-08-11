<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
@if (session()->has('message'))
    @if(session()->get('result') == "success")
        <script>
            toastr.success("{{ session()->get('message') }}")
        </script>
    @else
        <script>
            toastr.error("{{ session()->get('message') }}")
        </script>
    @endif
@endif