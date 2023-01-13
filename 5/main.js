$(document).ready(function () {
    let form = $('#register_form');
    function remove_error_mess(){
        let error_message_element = $('#error_message')
        if ($(error_message_element).length) {
            $(error_message_element).remove();
        }
    }
    $('#register_form :input').on('change input', function() {
        remove_error_mess();
    });
    $(form).validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            email: {
                required: "Необходимо ввести email",
                email: "Email должен быть в формате: asd@asd.asd"
            },
            password: {
                required: "Необходимо ввести пароль",
            },
            confirm_password: {
                required: "Подтверждение пароля, обязательно",
                equalTo: "Пароли не совпадают"
            }
        }
    });
    $(form).submit(function(event) {
        remove_error_mess()
        if ($(this).valid()){
            $.ajax({
                type: "POST",
                url: "5.php",
                data: $(this).serialize(),
                success: function (response){
                    if (response === "1"){
                        $(form).hide()
                        alert('Вы успешно зарегистировались')
                    }
                    if (response === "0"){
                        $( "<h1 id='error_message'>Данных нет в базе</h1>" ).insertBefore($(form));
                    }
                    if (response === "-1"){
                        alert('Ошибка валидации формы')
                    }
                }
            });
        }
        event.preventDefault();
    });
});