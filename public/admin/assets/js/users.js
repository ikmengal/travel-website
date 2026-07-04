$(function () {
    // ------------------------------------- Select2 -------------------------------------//
    if ($('.select2').length) {
        $('.select2').select2({
            width: '100%'
        });
    }

    // ------------------------------------- Avatar Preview ------------------------------------- //
    $('#avatar').on('change', function (e) {
        let reader = new FileReader();
        reader.onload = function (event) {
            $('#avatar-preview').attr('src', event.target.result);
        };
        if (e.target.files.length) {
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // ------------------------------------- Password Generator ------------------------------------- //
    function generatePassword(length = 12) {
        let chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*";
        let password = "";

        for (let i = 0; i < length; i++) {
            password += chars.charAt(
                Math.floor(Math.random() * chars.length)
            );
        }
        return password;
    }

    function setPassword() {
        let password = generatePassword();
        $('#password').val(password);
        $('#password_confirmation').val(password);
    }
    setPassword();

    // ------------------------------------- Generate Button ------------------------------------- //
    $('#generatePassword').click(function () {
        setPassword();
    });

    // ------------------------------------- Copy Password ------------------------------------- //
    $('#copyPassword').click(function () {
        let input = document.getElementById('password');
        input.select();
        input.setSelectionRange(0, 99999);

        navigator.clipboard.writeText(input.value);
        Swal.fire({
            icon: 'success',
            title: 'Copied',
            text: 'Password copied successfully.',
            timer: 1200,
            showConfirmButton: false
        });
    });

    // ------------------------------------- Auto Password ------------------------------------- //
    $('#autoPassword').change(function () {
        if ($(this).is(':checked')) {
            $('#password').prop('readonly', true);
            $('#password_confirmation').prop('readonly', true);
            $('#generatePassword').prop('disabled', false);
            setPassword();
        } else {
            $('#password').prop('readonly', false);
            $('#password_confirmation').prop('readonly', false);
            $('#generatePassword').prop('disabled', true);
            $('#password').val('');
            $('#password_confirmation').val('');
        }
    });

    // ------------------------------------- Country -> State ------------------------------------ //
    $('#country_id').change(function () {
        let id = $(this).val();

        $('#state_id').html(
            '<option value="">Loading...</option>'
        );

        $('#city_id').html(
            '<option value="">Select City</option>'
        );

        if (!id) {
            $('#state_id').html(
                '<option value="">Select State</option>'
            );
            return;
        }

        $.ajax({
            url: "/states/" + id,
            type: "GET",
            success: function (response) {
                let html =
                    '<option value="">Select State</option>';
                $.each(response, function (key, value) {
                    html +=
                        '<option value="' + value.id + '">' +
                        value.name +
                        '</option>';
                });
                $('#state_id').html(html);
            }
        });
    });

    // ------------------------------------- State -> City ------------------------------------- //
    $('#state_id').change(function () {
        let id = $(this).val();

        $('#city_id').html(
            '<option value="">Loading...</option>'
        );

        if (!id) {
            $('#city_id').html(
                '<option value="">Select City</option>'
            );
            return;
        }

        $.ajax({
            url: "/cities/" + id,
            type: "GET",
            success: function (response) {
                let html =
                    '<option value="">Select City</option>';
                $.each(response, function (key, value) {
                    html +=
                        '<option value="' + value.id + '">' +
                        value.name +
                        '</option>';
                });
                $('#city_id').html(html);
            }
        });
    });
});
