<? require_once('header-moderator.php'); ?>

<h1>Изменить товар</h1>

<form class="custom-form" method="post">
  <div>
    <label for="insurance-name">Название страховки</label>
    <input class="custom-input" type="text" id="insurance-name" name="insurance-name" value="<?= $insurance_data['name'] ?>" required>
  </div>

  <div>
    <label for="company-id">Компания</label>
    <select name="company-id" id="company-id">
      <?php
      foreach ($insurance_companys as $value) {
              if ($insurance_data["company_id"] == $value["id"]) {
                echo "
                  <option value='{$value["id"]}' selected>
                    {$value["name"]}
                  </option>
                ";
              } else if(!$is_moderator) {
                echo "
                  <option value='{$value["id"]}'>
                    {$value["name"]}
                  </option>
                ";
              }
      }
      ?>
    </select>
  </div>

  <div>
    <label for="price">Цена</label>
    <input class="custom-input" type="number" min="0" pattern="\d+" name="price" id="price" value="<?= $insurance_data['price'] ?>" required>
  </div>

  <div>
    <label for="capacity">Длительность</label>
    <input class="custom-input" type="text" name="capacity" id="capacity" value="<?= $insurance_data['capacity'] ?>" required>
  </div>

  <div>
    <label for="type">Тип страховки</label>
    <input class="custom-input" type="text" name="type" id="type" value="<?= $insurance_data['type'] ?>" required>
  </div>

  <div>
    <label for="description">Описание</label>
    <input class="custom-input" type="text" id="description" name="description" value="<?= $insurance_data['description'] ?>" required>

  </div>

  <input class="custom-btn" type="submit" value="Сохранить">
</form>
<?require_once('footer-moderator.php');?>
