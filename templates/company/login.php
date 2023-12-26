<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Авторизация</title>
    <link rel="stylesheet" href="/static/styles/auth.css">
  </head>

  <body>
    <main>
      <div id="auth-container">
        <form method="post">
          <h1>Вход</h1>

          <div class="auth-input">
            <label for="email">Электронная почта</label>
            <input type="text" name="email" id="email" required>
          </div>
  
          <div class="auth-input">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" required>
          </div>

          <input id="submit-btn" type="submit" value="Принять">
        </form>

        <?php
        if (isset($error_msg)) {
          echo "<p class='error-msg'>{$error_msg}</p>";
        }
        ?>

        <div>
          <a href="/signup.php">
            Еще не имеете аккаунт? Зарегистрироваться
          </a>
        </div>

        <div>
          <a href="/index.php">
            На главную
          </a>
        </div>
      </div>
    </main>
  </body>
</html>
