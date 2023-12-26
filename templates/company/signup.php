<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Регистрация</title>
    <link rel="stylesheet" href="/static/styles/auth.css">
  </head>

  <body>
    <main>
      <div id="auth-container">
        <form method="post">
          <h1>Зарегистрироваться</h1>
  
          <?php
          if (isset($is_signup_successful)) {
            if (!$is_signup_successful) {
              echo ' 
                <div class="auth-msg">
                  Ошибка при регистрации. 
                </div>
              ';
            }
          }elseif (isset($error_msg)) {
            echo "<p class='error-msg'>{$error_msg}</p>";
          }
          ?>

          <div class="auth-input">
            <label for="username">Имя пользователя</label>
            <input type="text" name="username" id="username" required>
          </div>

          <div class="auth-input">
            <label for="email">Электронная почта</label>
            <input type="email" name="email" id="email" required>
          </div>

          <div class="auth-input">
            <label for="phone-number">Номер телефона</label>
            <input type="text" name="phone-number" id="phone-number" required>
          </div>
  
          <div class="auth-input">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" required>
          </div>

          <input id="submit-btn" type="submit" value="Отправить" >
        </form>
        
        <div>
          <a href="/login.php">
            Уже имеете аккаунт? Войти
          </a>
        </div>

        <div>
          <a href="/">
            На главную
          </a>
        </div>
      </div>
    </main>
  </body>
</html>
