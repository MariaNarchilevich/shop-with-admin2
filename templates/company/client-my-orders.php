<?
$title = "Мои заказы";
require_once('header-client.php');
?>
<h1>Мои заказы</h1>

<?
if (count($orders_for_output_data) == 0) :
  echo '<div>У вас еще нет заказов</div>';
else :
  foreach ($orders_for_output_data as $value) {
    echo "
          <div class='course'>
            <h2>{$value["name"]}</h2>
            <div>Компания: {$value["company_name"]}</div>
              <div>Описание: {$value["description"]}</div>
              <div>Длительность: {$value["capacity"]}</div>
              <div>Тип: {$value["type"]}</div>
              <div>Цена: {$value["price"]} руб.</div>
              <div>Статус заказа: {$value["insurance_status"]}</div>
          </div>
        ";
  }
endif;
?>
<? require_once('footer-client.php'); ?>