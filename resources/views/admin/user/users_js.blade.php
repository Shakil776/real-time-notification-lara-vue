<script>
$(function() {
    "use strict";

    // datatable init
    if ($('#usersTable').length) {
        $('#usersTable').DataTable({
            responsive: true,
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        });
    }

    // user create form validation
    var jqForm = $('#user-create-form');
    if (jqForm.length) {
        jqForm.validate({
            rules: {
                'name': {
                    required: true
                },
                'email': {
                    required: true,
                    email: true
                },
                'mobile': {
                    required: true
                },
                'password': {
                    required: true
                },
                'password_confirmation': {
                    required: true,
                    equalTo: '#password'
                },
                'roles[]': {
                    required: true
                },
            }
        });
    }

    // user update form validation
    var jqForm = $('#user-update-form');
    if (jqForm.length) {
        jqForm.validate({
            rules: {
                'name': {
                    required: true
                },
                'mobile': {
                    required: true
                },
                'roles[]': {
                    required: true
                },
            }
        });
    }

    // delete user
    $(document).on("click", ".deleteUser", function(e) {
        e.preventDefault();
        var id = $(this).attr("id");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then(result => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "post",
                    url: "{{ route('user.delete') }}",
                    data: { id: id },
                    success: function(resp) {
                        if (resp.success === true) {
                            window.location.reload(true);
                        } else {
                            // show error message
                            iziToast.show({
                                title: "Opppps!",
                                position: "topRight",
                                timeout: 2000,
                                color: "red",
                                message: "Something Wrong. Please try again.",
                                messageColor: "black"
                            });
                        }
                    },
                    error: function() {
                        console.log("Error");
                    }
                });
            }
        });
    });


    // password form validation
    var form = $(".validate-password-form");
    if (form.length) {
        form.validate({
            rules: {
                current_password: {
                    required: true
                },
                new_password: {
                    required: true
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#account-new-password"
                },
            }
        });
    }

    // change password form
    $(".validate-password-form").on("submit", function(e) {
        e.preventDefault();

        if ($(this).valid()) {
            var oldPassword = $("#account-old-password").val();
            var newPassword = $("#account-new-password").val();
            var confirmPassword = $("#account-retype-new-password").val();

            $.ajax({
                type: "POST",
                url: "/change-password",
                data: {
                    current_password: oldPassword,
                    new_password: newPassword,
                    password_confirmation: confirmPassword
                },
                success: function(resp) {
                    if (resp.error === false) {
                        // clear form input field data
                        $("#account-old-password").val("");
                        $("#account-new-password").val("");
                        $("#account-retype-new-password").val("");
                        // show toast message
                        iziToast.show({
                            title: "Success!",
                            position: "topRight",
                            timeout: 5000,
                            color: "green",
                            message: resp.message,
                            messageColor: "black"
                        });
                    } else if (resp.errors) {
                        iziToast.show({
                            title: "Oopps!",
                            position: "topRight",
                            timeout: 5000,
                            color: "red",
                            message: resp.errors[0],
                            messageColor: "black"
                        });
                    } else {
                        iziToast.show({
                            title: "Oopps!",
                            position: "topRight",
                            timeout: 5000,
                            color: "red",
                            message: resp.message,
                            messageColor: "black"
                        });
                    }
                },
                error: function() {
                    console.log("Error");
                }
            });
        }
    });

    // profile image preview
    $("#account-upload").on("change", function(e) {
        var reader = new FileReader();
        var file = e.target.files[0];

        reader.onload = function(e) {
            $("#account-upload-img").attr("src", e.target.result);

            $.ajax({
                type: "POST",
                url: "/change-profile-image",
                data: {
                    image: e.target.result
                },
                success: function(resp) {
                    if (resp.success === true) {
                        // refresh header image div
                        $("#headerProfilePohotoID").load(
                            location.href + " #headerProfilePohotoID"
                        );
                        // show toast message
                        iziToast.show({
                            title: "Success!",
                            position: "topRight",
                            timeout: 5000,
                            color: "green",
                            message: resp.message,
                            messageColor: "black"
                        });
                    } else if (resp.errors) {
                        iziToast.show({
                            title: "Oopps!",
                            position: "topRight",
                            timeout: 5000,
                            color: "red",
                            message: resp.errors[0],
                            messageColor: "black"
                        });
                    } else {
                        iziToast.show({
                            title: "Oopps!",
                            position: "topRight",
                            timeout: 5000,
                            color: "red",
                            message: "Something Wrong! Please try again.",
                            messageColor: "black"
                        });
                    }
                },
                error: function() {
                    console.log("Error");
                }
            });
        };
        reader.readAsDataURL(file);
    });

    // change user status
    $(document).on("click", ".changeUserStatus", function(){
        var status = $(this).children("i").attr("status");
        var user_id = $(this).attr("user_id");
        
        $.ajax({
            type: 'POST',
            url: '/user-status',
            data: {status:status, user_id:user_id},
            success: function(resp){
                if(resp['status'] == 0){
                    $("#user-"+user_id).html("<i class='fas fa-toggle-off' status='Inactive'></i>");
                } else if(resp['status'] == 1){
                    $("#user-"+user_id).html("<i class='fas fa-toggle-on' status='Active'></i>");
                }
            },
            error: function(){
                console.log("Error");
            }
        });
    });
});
</script>