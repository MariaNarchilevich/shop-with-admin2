<? 
$title = "Список пользователей";
require_once('header-moderator.php'); 
?>

<h1>Список пользователей</h1>

<div>
  <? foreach ($all_users_data as $this_user_data) : ?>
    <div style="border: 1px solid black; margin-bottom: 5px;">
      Пользователь:
      <div>Id - <?= $this_user_data["id"] ?></div>
      <div>Имя - <?= $this_user_data["username"] ?></div>
      <div>Электронная почта - <?= $this_user_data["email"] ?></div>
      <div>Роль - <?= $this_user_data["role_id"] ?></div>
    </div>
  <? endforeach; ?>
</div>
<div>
  Роли
  <p>Админ - 1</p>
  <p>Менеджер - 2</p>
  <p>Покупатель - 3</p>
</div>

<?require_once('footer-moderator.php');?>