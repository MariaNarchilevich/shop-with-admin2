<? require_once('header-moderator.php'); ?>

<h1>Обработка товаров</h1>

<div id="management-btns">
  <div>
    <a href="/moderator_add_insurance.php">Добавить</a>
  </div>
  <? if (!$is_user_moderator) : ?>
    <div>
      <a href="/moderator_delete_all_insurances.php">Удалить все</a>
    </div>
  <? endif; ?>
</div>

<ul>
  <?
  $count = 1;
  foreach ($insurance_data as $value) :
    if ($user_company_id == $value["company_id"] || $user_company_id == -1) :
      echo "
            <li>
              {$count}) {$value["name"]} 
              <a href='/moderator_edit_insurance.php?insurance_id={$value["id"]}'>Изменить</a>
              <a href='/moderator_delete_insurance.php?insurance_id={$value["id"]}'>Удалить</a>
            </li>
          ";
      $count++;
    endif;
  endforeach;
  ?>
</ul>
<? require_once('footer-moderator.php'); ?>