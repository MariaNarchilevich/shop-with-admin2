<? require_once('header-moderator.php'); ?>

<h1>Заявка от <?= $user_name ?></h1>

<div class="course-description">
  <p>
    <span class="property-name">Название страховки:</span>
    <?= $insurance_name ?>
  </p>

  <p>
    <span class="property-name">Компания:</span>
    <?= $company_name ?>
  </p>

  <p>
    <span class="property-name">Тип:</span>
    <?= $insurance_type ?>
  </p>

  <p>
    <span class="property-name">Длительность:</span>
    <?= $insurance_capacity ?>
  </p>

  <p>
    <span class="property-name">Описание:</span>
    <?= $insurance_description ?>
  </p>

  <p>
    <span class="property-name">Цена:</span>
    <?= $insurance_price ?>
  </p>

  <p>
    <span class="property-name">Номер телефона пользователя:</span>
    <?= $phone_number ?>
  </p>
</div>

<form action="/moderator_checked_application.php" method="get">
  <div id="checked-status">
    <p>Статус заявки</p>

    <div>
      <input type="radio" name="checking-status" value="accept-btn" id="accept-btn" required>
      <label for="accept-btn">Принять</label>
    </div>

    <div>
      <input type="radio" name="checking-status" value="decline-btn" id="decline-btn">
      <label for="decline-btn">Отклонить</label>
    </div>
  </div>

  <div id="application-comment">
    <label for="application-comment">Комментарий модератора к заявке</label>
    <textarea type="text" rows="10" name="application-comment" id="application-comment" required></textarea>
  </div>

  <?php
  echo "
          <input type='hidden' name='user-id' value='{$user_id}'>
          <input type='hidden' name='insurance_id' value='{$insurance_id}'>
          <input type='hidden' name='order_id' value='{$order_id}'>
        ";
  ?>

  <input class="custom-btn" type="submit" value="Отправить">
</form>
<? require_once('footer-moderator.php'); ?>