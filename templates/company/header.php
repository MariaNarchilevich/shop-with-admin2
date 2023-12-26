<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?=$title ? $title : "РеСтрах - страховая компания";?></title>
	<link rel="stylesheet" href="/static/styles/index.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
	<header class="p-3 bg-dark text-white">
		<div class="container">
			<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
				<a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
					РеСтрах
				</a>

				<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
					<!-- <li><a href="#" class="nav-link px-2 text-secondary">Главная</a></li>
					<li><a href="#" class="nav-link px-2 text-white">Функции</a></li>
					<li><a href="#" class="nav-link px-2 text-white">Ценообразование</a></li>
					<li><a href="#" class="nav-link px-2 text-white">FAQ</a></li>
					<li><a href="#" class="nav-link px-2 text-white">О нас</a></li> -->
				</ul>

				<div class="text-end">
					<?php
					if ($is_user_authorized) {
						if ($is_user_client) {
							echo '
                  <a href="/client_my_orders.php">
                    Меню
                  </a>
                ';
						} else {
							echo '
                  <a href="/moderator_application_panel.php">
                    Меню
                  </a>
                ';
						}
					} else {
						echo '
                <a class="btn btn-outline-light me-2" href="/login.php">
						 Войти
                </a>
					<a class="btn btn-warning" href="/signup.php">
						Зарегистрироваться
					</a>
              ';
					}
					?>
				</div>
			</div>
		</div>
	</header>
	<main>
		