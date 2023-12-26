<?
$title = "Купить страховку";
require_once('header-client.php');
?>
      <h1>Купить страховку</h1>
      <?
      foreach ($all_insurances as $value) {
        echo "
          <form action='/client_accept_purchase.php' method='post'>
            <div class='course'>
              <h2>{$value["name"]}</h2>
              <div>Компания: {$value["company_name"]}</div>
              <div>Описание: {$value["description"]}</div>
              <div>Длительность: {$value["capacity"]}</div>
              <div>Тип: {$value["type"]}</div>
              <div>Цена: {$value["price"]} руб.</div>
              <input type='hidden' name='user-id' value='{$user_id}'>
              <input type='hidden' name='insurance-id' value='{$value["id"]}'>
              <input class='custom-btn' type='submit' value='Принять'>
            </div>
          </form>
          ";
        }
        ?>
<? require_once('footer-client.php'); ?>
