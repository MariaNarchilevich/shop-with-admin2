<? 
$title = "Обработка заявок";
require_once('header-moderator.php'); 
?>

<h1>Обработка заявок</h1>

<? if (count($reserved_data_for_output) == 0) : ?>
  Новых заявок нет
<? else : ?>
  <ul>
    <?php
    foreach ($reserved_data_for_output as $insurance) {
      echo "
          <li>
            <a href='/moderator_application_handler.php?user_id={$insurance["user_id"]}&insurance_id={$insurance["insurance_id"]}&order_id={$insurance["order_id"]}'>
              Номер заказа: {$insurance["order_number"]}<br> Дата: {$insurance["order_date"]}<br>
              Наименование: {$insurance["insurance_name"]}<br> Имя пользователя: {$insurance["user_name"]} 
            </a>
          </li>
        ";
    }
    ?>
  </ul>
<? endif; ?>

<?require_once('footer-moderator.php');?>