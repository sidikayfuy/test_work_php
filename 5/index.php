<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>5 Задание</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
        <script src="main.js"></script>
    </head>
    <body>
        <form id="register_form">
            <label for="firstname"> Имя
                <input type="text" name="firstname" placeholder="Введите имя...">
            </label><br><br>
            <label for="lastname"> Фамилия
                <input type="text" name="lastname" placeholder="Введите фамилию...">
            </label><br><br>
            <label for="email"> Email
                <input type="email" name="email" placeholder="Введите email...">
            </label><br><br>
            <label for="password"> Пароль
                <input type="password" name="password" id="password" placeholder="Введите пароль...">
            </label><br><br>
            <label for="confirm_password"> Подтверждение пароля
                <input type="password" name="confirm_password" placeholder="Повторите пароль...">
            </label><br><br>
            <input type="submit" value="Регистрация">
        </form>
    </body>
</html>

