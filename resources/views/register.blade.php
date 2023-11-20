<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login {{ env('APP_NAME', 'Laravel Otorisasi') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/bootstrap-social/bootstrap-social.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('') }}assets/css/style.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/css/components.css">
</head>

<body>
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-12 col-md-8 col-lg-6">
                        {{-- <div class="login-brand">
                            <img src="{{ asset('laundry') }}/assets/img/logo/logo.png" alt="logo" width="100"
                                class="shadow-light">
                        </div> --}}
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Register</h4>
                            </div>
                            <div class="card-body">
                                <div id="alert-message-error" style="display: none;"
                                    class="alert alert-danger alert-dismissible">
                                    <div class="alert-body">
                                    </div>
                                </div>
                                <div id="alert-message-success" style="display: none;"
                                    class="alert alert-success alert-dismissible">
                                    <div class="alert-body">
                                    </div>
                                </div>
                                <form method="POST" action="#" id="form-register">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name">
                                        <div class="invalid-feedback" for="name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" id="email">
                                        <div class="invalid-feedback" for="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" name="phone" id="phone">
                                        <div class="invalid-feedback" for="phone">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sim_number">SIM Number</label>
                                        <input type="text" class="form-control" name="sim_number" id="sim_number">
                                        <div class="invalid-feedback" for="sim_number">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea class="form-control" name="address" id="address"></textarea>
                                        <div class="invalid-feedback" for="address">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="password" class="d-block">Password</label>
                                            <input id="password" type="password" class="form-control pwstrength"
                                                data-indicator="pwindicator" name="password">
                                            <div id="pwindicator" class="pwindicator">
                                                <div class="bar"></div>
                                                <div class="label"></div>
                                            </div>
                                            <div class="invalid-feedback" for="password">
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="password-confirm" class="d-block">Password Confirmation</label>
                                            <input type="password" class="form-control" name="password-confirm"
                                                id="password-confirm">
                                            <div class="invalid-feedback" for="password-confirm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="agree" class="custom-control-input"
                                                id="agree">
                                            <label class="custom-control-label" for="agree">I agree with the<a
                                                    id="show-tnc" href="#"> terms
                                                    and conditions</a> </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            Register
                                        </button>
                                    </div>
                                    <div class="mt-2 text-muted text-center">
                                        Sudah punya akun? <a href="{{ route('login') }}">Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="term-and-condition-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Term and Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- {!! $terms_and_condition->term_and_conditions !!} --}}
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('') }}assets/modules/jquery.min.js"></script>
    <script src="{{ asset('') }}assets/modules/popper.js"></script>
    <script src="{{ asset('') }}assets/modules/tooltip.js"></script>
    <script src="{{ asset('') }}assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ asset('') }}assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="{{ asset('') }}assets/modules/moment.min.js"></script>
    <script src="{{ asset('') }}assets/js/stisla.js"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ asset('') }}assets/js/scripts.js"></script>
    <script src="{{ asset('') }}assets/js/custom.js"></script>

    <script>
        function showLoading() {
            $(".loader").show();
            $("#preloder").delay(50).fadeIn("fast");
        }

        function hideLoading() {
            $(".loader").fadeOut();
            $("#preloder").delay(50).fadeOut("fast");
        }
        $(document).ready(function() {
            $("a#show-tnc").click(function(e) {
                e.preventDefault();
                $("#term-and-condition-modal").modal('show');
            });

            $("#form-register").submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    url: '{{ route('register-in') }}',
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        showLoading();
                        $("#alert-message-error").fadeOut(300);
                        $("#alert-message-success").fadeOut(200);
                    },
                    success: function(response) {
                        $("#alert-message-success").find(".alert-body").html(response
                            .message);
                        $("#alert-message-success").fadeIn(200);
                        $("#form-register")[0].reset();
                    },
                    error: function(xhr, status, error) {
                        const responseJson = xhr.responseJSON;
                        $("#alert-message-error").find(".alert-body").html(responseJson
                            .message);
                        $("#alert-message-error").fadeIn(200)
                        switch (xhr.status) {
                            case 422:
                                const errors = Object.entries(responseJson.errors);
                                errors.forEach(([field, message]) => {
                                    field = field.replace('.', '_');
                                    $(`div.invalid-feedback[for="${field}"]`).html(
                                        message);
                                    $(`#${field}`).addClass('is-invalid');
                                });
                                setTimeout(
                                    function() {
                                        $("#alert-message-error").fadeOut(300)
                                    }, 2000);
                                break;
                        }

                    },
                    complete: function() {
                        hideLoading();
                        document.body.scrollTop = 0;
                        document.documentElement.scrollTop = 0;
                    }
                })
            })
        });

        $(document).on('keyup change',
            '#form-register input, #form-register textarea, #form-register select',
            function() {
                $(this).removeClass('is-invalid');
            });
    </script>
</body>

</html>
