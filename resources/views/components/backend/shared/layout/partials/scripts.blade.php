<script src="{{ asset('admin/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('admin/js/main.js') }}"></script>
<script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('assets/rtl/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('admin/sweetalert/sweetalert2.all.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/plugins/printThis.js') }}"></script>
<script src="{{ asset('assets/plugins/fontawesome/js/all.min.js') }}"></script>

<script src="{{asset('shamsi_calendars/js/persianDatepicker.min.js')}}"> </script>

{{-- <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script> --}}



<script>
    $(document).ready(function() {
        $("form").submit(function() {
            // $(this).find(":submit").attr("disabled", "disabled");
            // var txt = $(this).find(":submit").text();
            // $(this).find(":submit").html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            //     <span role="status">${txt}</span>`);
        });

        function toggleButtonState(isLoading) {
            console.log('hide is also called')

            if (isLoading) {
                $('.save-icon').hide();
                $('.spinner-icon').show();
            } else {
                console.log('hide is also called')
                $('.save-icon').show();
                $('.spinner-icon').hide();
            }
        }

        $(document).ajaxSend(function(event, xhr, settings) {
            const form = $('form[method="post"]');
            const submitButton = form.find('button[type="submit"]');

            if (submitButton.length) {
                toggleButtonState(true);
            }
        });

        $(document).ajaxComplete(function(event, xhr, settings) {
            const form = $('form[method="post"]');
            const submitButton = form.find('button[type="submit"]');

            if (submitButton.length) {
                toggleButtonState(false);
            }
        });
    });
    $(".pagination").attr('dir', 'ltr');
    @if (app()->getLocale() != 'en')
        $("th").addClass('text-end');
    @endif
    toastr.options = {
        "positionClass": "toast-bottom-right",
        "timeOut": "4000",
        "extendedTimeOut": "1000",
        "closeButton": true,
        "progressBar": true
    };
    @if (session()->has('msg'))
        toastr.success("{{ session()->get('msg') }}", "{{ __('lang.notice') }}")
    @endif
    @if (session()->has('success'))
        toastr.success("{{ session()->get('success') }}", "{{ __('lang.success') }}")
    @endif
    @if (session()->has('error'))
        toastr.error("{{ session()->get('error') }}", "{{ __('lang.error') }}")
    @endif
    $("#btnPrint").click(function() {
        $('.printDiv').printThis();
    })


    //global delete action
    $(document).on("click", ".btn-delete", function() {
        var deleteRoute = $(this).attr('route');
        Swal.fire({
            title: "{{ __('messages.confirm_delete') }}",
            text: "",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "{{ __('lang.delete') }}",
            cancelButtonText: "{{ __('lang.cancel') }}"
        }).then((result) => {
            if (result.isConfirmed) {
                $("#frm_delete").attr('action', deleteRoute);
                $("#frm_delete").submit();
            }
        });
    })
</script>
