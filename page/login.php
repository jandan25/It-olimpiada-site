<? 
ULogin(0); 
Head('Вход') ?>
<body>
<div class="wrapper">
<div class="header"></div>
<div class="content">
<?php Menu();
MessageShow() ?>
<div class="Page">
<form method="POST" action="/account/login">
<br><input type="text" name="login" placeholder="Логин" maxlength = "10" pattern="[A-Za-z-0-9]{3,10}" title="Не более 3 и менее 10 латинских символов или цифр." required>
<br><input type="password" name="password" placeholder="Пароль" maxlength = "15" pattern="[A-Za-z-0-9]{5,15}" title="Не менее 5 и более 15 латинских символов или цифр." required>
<div class ="capdiv">
	<input type="text" class ="capinp" name="captcha" placeholder="Код" maxlength = "10" pattern="[0-9]{1,5}" title="Только цифры." required>
	<img src ="/resource/captcha.php" class="capimg" alt="Капча">
</div>
<br><input type="checkbox" name="remember"> Запомнить меня
<br><br><input type="submit" name="enter" value="Вход">
<input type="reset" value="Очистить">
<br><br><a href ="/register" class="button">Регистрация</a> <a href ="/restore" class="button">Восстановить пароль</a>

</form>
</div>
</div>

<?php Footer() ?>
</div>
</body>
</html>