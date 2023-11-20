<script>
    $(document).ready(function() {
        $(".select2").select();

        $(".select-all-permission-menu").change(function() {
            const is_checked = $(this).is(':checked');
            const menu_name = $(this).data('menu_name');

            $(`.permission-checkbox[data-menu_name="${menu_name}"]`).prop("checked", is_checked);
        })
        $(".permission-checkbox").change(function() {
            const menu_name = $(this).data('menu_name');
            const all_selection_length = $(
                    `.permission-checkbox[data-menu_name="${menu_name}"]`)
                .length;
            const all_selected_length = $(
                    `.permission-checkbox[data-menu_name="${menu_name}"]:checked`)
                .length;
            $(`.select-all-permission-menu[data-menu_name="${menu_name}"]`).prop("checked",
                all_selection_length === all_selected_length);
        });

        $(".permission-menus").each(function() {
            $(this).find("input.permission-checkbox:first").trigger("change")
        })

        $("#form-manipulation").submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                url: "{{ route('update-role-permission', ['id' => $role->id]) }}",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    showLoading();
                },
                success: function(response) {
                    $("#alert-message-success").find(".alert-body").html(response
                        .message);
                    $("#alert-message-success").fadeIn(200);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    const responseJson = xhr.responseJSON;
                    $("#alert-message-error").find(".alert-body").html(responseJson
                        .message);
                    $("#alert-message-error").fadeIn(200)

                    switch (xhr.status) {
                        case 422:
                            const errors = Object.entries(responseJson.errors);
                            errors.forEach(([field, message]) => {
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
            });
        });

        $(document).on('keyup change',
            '#form-manipulation input, #form-manipulation textarea, #form-manipulation select',
            function() {
                $(this).removeClass('is-invalid');
            });
    });
</script>
