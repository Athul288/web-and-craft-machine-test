$(function () {

    $(document).on("submit", "form", function (e) {
        e.preventDefault();
        $('.loading').show();
        var path = 'add-employee';
        var form_data = new FormData(this);
        if ($(".box-footer button").attr('data-type') == 'edit') {
            path = 'edit-employee';
            form_data.append('user_id', temp);
        }
        $.ajax({
            url: location.origin + "/" + path,
            type: 'post',
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            xhr: function () {
                var jqXHR = null;
                if (window.ActiveXObject) {
                    jqXHR = new window.ActiveXObject("Microsoft.XMLHTTP");
                } else {
                    jqXHR = new window.XMLHttpRequest();
                }
                jqXHR.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded * 100) / evt.total);
                        $(".progress-bar").text(percentComplete + "%").css("width", percentComplete + "%");
                    }
                }, false);
                jqXHR.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded * 100) / evt.total);
                    }
                }, false);
                return jqXHR;
            },
            success: function (response) {
                $('.loading').hide();
                $(".progress-bar").text("0%").css("width", "0%");
                if (response.status) {
                    swal('Success', 'Employee list updated successfully', 'success')
                        .then(() => {
                            location.reload();
                        });
                } else {
                    var messages = '';
                    if (response.errors) {
                        $.each(response.errors, function (prefix, value) {
                            messages += '\n- ' + value[0];
                        });
                    }
                    swal('Sorry', 'Invalid inputs occured.' + messages, 'warning');
                }
            },
            error: function () {
                swal('Sorry', 'Something went wrong', 'error')
                    .then(() => {
                        location.reload();
                    });
            }
        });
    });

    $(document).on("click", ".edit", function (e) {
        e.preventDefault();
        $('.loading').show();
        temp = $(this).parent().parent().attr('data-id');
        $.post(location.origin + "/get-employee", { user_id: temp }, function (response) {
            if (response.status) {
                $("#full_name").val(response.message.name);
                $("#email_address").val(response.message.email);
                $("#designation").val(response.message.designation_id);
                var preview = (response.message.photo == null) ? '' : '<img class="profile-thump" src="' + location.origin + "/img/photo/" + response.message.photo + '"><br><a href="#" class="text-danger delete-photo">Remove</a>';
                $(".preview").html(preview);
                $(".modal-title").text("Edit Employee");
                $(".box-footer button").attr('data-type', 'edit');
                $('.loading').hide();
                $("#modal-default").modal("show");
            }
        });
    });

    $(document).on("click", ".delete", function (e) {
        e.preventDefault();
        temp = $(this).parent().parent().attr('data-id');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this profile !",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.post(location.origin + "/remove-employee", { user_id: temp }, function () {
                    location.reload();
                });
            }
        });
    });

    $(document).on("click", ".delete-photo", function (e) {
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this picture !",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.post(location.origin + "/remove-employee-photo", { user_id: temp }, function () {
                    $(".preview").html('');
                });
            }
        });
    });

    $(document).on("hidden.bs.modal", "#modal-default", function () {
        temp = null;
        $(".preview").html('');
        $(".form-control").val('');
        $(".modal-title").text("Add Employee");
        $(".box-footer button").attr('data-type', 'add');
    });

    var temp;
    $("table").DataTable();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

});