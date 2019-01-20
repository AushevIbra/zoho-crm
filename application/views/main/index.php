<?php
$data = require "application/config/zoho_crm.php";
if($_POST){

}

?>



<div class="container text-center">
  <?php if(!isset($_COOKIE['token'])): ?>
      <a href="https://accounts.zoho.com/oauth/v2/auth?scope=ZohoCRM.modules.all&response_type=code&client_id=<?=$data['client_id']?>&redirect_uri=<?=$data['redirect_uri']?>" class="btn btn-primary">Авторизоваться</a>
  <?php else : ?>
    <h3 class="text-center">Тестовое задание: </h3>
    <form class="form" method="post" action="/">
      <?php if(!empty($status)): ?>
        <div class="alert alert-success">
          <?= $status?>
        </div>
      <?php endif;?>

        <div class="form-group">
          <label for="email">Почта</label>
          <input type="email" name="email" class="form-control email" id="email" aria-describedby="emailHelp" placeholder="Введите почту">
        </div>

        <div class="form-group">
          <label for="phone">Телефон</label>
          <input type="phone" name="phone" class="form-control phone" id="phone" placeholder="Введите телефон">
        </div>

        <div class="form-group">
          <label for="email">Имя</label>
          <input type="text" name="name" class="form-control name" id="name" placeholder="Введите имя">
        </div>

        <div class="form-group">
          <label for="sum">Сумма сделки</label>
          <input type="sum" name="sum" class="form-control sum" id="sum" placeholder="Введите сумму">
        </div>

        <div class="form-group">
          <label for="other">Источник</label>
          <input type="other" name="other" class="form-control other" id="other" placeholder="Укажите источник">
        </div>
        <button type="submit" class="btn btn-primary send">Отправить</button>
    </form>
  <?php endif; ?>

</div>
