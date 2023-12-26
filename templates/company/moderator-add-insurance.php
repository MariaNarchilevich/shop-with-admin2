<? require_once('header-moderator.php'); ?>
<h1>Создание товара</h1>
<? if ($ok_new_value) : ?>
  <div>Товар успешно создан</div>
  <a href="/moderator-add-insurance.php">Добавить еще один товар</a>
<? else : ?>
  <form class="custom-form" method="post">
    <div>
      <label for="name">Название страховки</label>
      <input class="custom-input" type="text" id="name" name="name" required>
    </div>

    <div>
      <label for="company-id">Компания</label>
      <select name="company-id" id="company-id">
        <?php
        foreach ($insurance_companys as $value) {
          if (is_null($user_company_id) || $user_company_id==-1) {
              echo "
            <option value='{$value["id"]}'>
              {$value["name"]}
            </option>
          ";
          } else {
            if ($user_company_id == $value["id"]) {
              echo "
            <option value='{$value["id"]}'>
              {$value["name"]}
            </option>
          ";
              break;
            }
          }
        }
        ?>
      </select>
    </div>

    <div>
      <label for="price">Цена</label>
      <input class="custom-input" type="number" min="0" pattern="\d+" name="price" id="price" required>
    </div>

    <div>
      <label for="capacity">Длительность</label>
      <input class="custom-input" type="text" name="capacity" id="capacity" required>
    </div>
    <div>
      <label for="type">Тип страховки</label>
      <input class="custom-input" type="text" name="type" id="type" required>
    </div>
    <div>
      <label for="description">Описание</label>
      <textarea class="custom-input" type="text" id="description" name="description" rows="7" required></textarea>
    </div>

    <input class="custom-btn" type="submit" value="Сохранить">
  </form>
<? endif; ?>
<? require_once('footer-moderator.php'); ?>