<?php
/*единая точка входа*/
include_once 'setting.php';
/*запускаем сессию на сайте*/
session_start();
/*соединение с бд*/
$CONNECT = mysqli_connect(HOST, USER, PASS, DB);

/**/
if ($_SESSION['USER_LOGIN_IN'] != 1 and $_COOKIE['user']){
	/*выбираем из бд значения залогиненного пользователя*/
	$Row  = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id`, `name`, `regdate`, `email`, `country`, `avatar`, `login`, `group` FROM `users` WHERE `password` = '$_COOKIE[user]'"));

/*записываем данные в глобальный массив сессии*/
	$_SESSION['USER_LOGIN'] = $Row['login'];
	$_SESSION['USER_ID'] = $Row['id'];
	$_SESSION['USER_NAME'] = $Row['name'];
	$_SESSION['USER_REGDATE'] = $Row['regdate'];
	$_SESSION['USER_EMAIL'] = $Row['email'];
	$_SESSION['USER_COUNTRY'] = UserCountry($Row['country']);
	$_SESSION['USER_AVATAR'] = $Row['avatar'];
	$_SESSION['USER_GROUP'] = $Row['group'];
	$_SESSION['USER_LOGIN_IN'] = 1;
}

/*сервер глобальная переменная информация о сервере */
if ($_SERVER['REQUEST_URI'] == '/') {
	$Page = 'index';
	$Module = 'index';
} else {

	/*експлоде делит сайт на части*/
	$URL_Path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$URL_Parts = explode('/', trim($URL_Path, ' /'));
	/*значение в url после / сайта*/
	$Page = array_shift($URL_Parts);
	/*значение после pageb /*/
	$Module = array_shift($URL_Parts);

/*разбор параметров после второй /*/
	if (!empty($Module)) {
		$Param = array();
		for ($i = 0; $i < count($URL_Parts); $i++) {
			$Param[$URL_Parts[$i]] = $URL_Parts[++$i];
		}
	}
}

/*определяет тип страницы и ее выводит*/
if ($Page == 'index') include ('page/index.php');
else if ($Page == 'login') include ('page/login.php');

/*данные беруться с страницы register.php*/
else if ($Page == 'register') include ('page/register.php');
else if ($Page == 'account') include ('form/account.php');
else if ($Page == 'profile') include ('page/profile.php');
else if ($Page == 'restore') include ('page/restore.php');
else if ($Page == 'speakers') include ('page/speakers.php');
else if ($Page == 'schedule') include ('page/schedule.php');


else if ($Page == 'news'){
	if (!$Module or $Page == 'news' and $Module == 'category' or $Page == 'news' and $Module == 'main') include ('module/news/main.php');
	else if ($Module == 'material') include ('module/news/material.php');
	else if ($Module == 'add') include ('module/news/add.php');
	else if ($Module == 'edit') include ('module/news/edit.php');
	else if ($Module =='control') include ('module/news/control.php');
}

else if ($Page == 'loads'){
	if (!$Module or $Page == 'loads' and $Module == 'category' or $Page == 'loads' and $Module == 'main') include ('module/loads/main.php');
	else if ($Module == 'material') include ('module/loads/material.php');
	else if ($Module == 'add') include ('module/loads/add.php');
	else if ($Module == 'edit') include ('module/loads/edit.php');
	else if ($Module =='control') include ('module/loads/control.php');
	else if ($Module =='download') include ('module/loads/download.php');
}

/*функция отправки ошибки*/
function MessageSend($p1, $p2, $p3 =''){
	if ($p1 == 1) $p1 = 'Ошибка';
	else if ($p1 == 2) $p1 = 'Подсказка';
	else if ($p1 == 3) $p1 = 'Информация';
	$_SESSION['message'] ='<div class="MessageBlock"><b>'.$p1.'</b>: '.$p2.'</div>';
	if ($p3) $_SERVER['HTTP_REFERER'] = $p3;
	exit(header('Location: '.$_SERVER['HTTP_REFERER']));
}

/*отображение ошибки*/
function MessageShow(){
	if ($_SESSION['message']) $Message = $_SESSION['message'];
	echo $Message;
	$_SESSION['message'] = array();
}

/*вывод текстом страны*/
function UserCountry($p1){
	if ($p1 == 0) return 'не указан';
	else if ($p1 == 1) return 'Украина';
	else if ($p1 == 2) return 'Россия';
	else if ($p1 == 3) return 'США';
	else if ($p1 == 4) return 'Канада';
}

/*вывод текстом статуса*/
function UserGroup($p1){
	if ($p1 == 0) return 'Пользователь';
	else if ($p1 == 1) return 'Модератор';
	else if ($p1 == 2) return 'Администратор';
	else if ($p1 == -1) return 'Заблокирован';
}


function UAccess($p1){
	if ($_SESSION['USER_GROUP'] < $p1) MessageSend(1, 'У вас нет прав доступа для просмотра данной страницы сайта.','/');
}

/*Функция генерации пароля*/
function RandomString($p1){
	$Char = '0123456789abcdefghijklmnopqrstuvwxyz';
	for ($i = 0; $i < $p1; $i++)
		$String .=$Char[rand(0, strlen($Char) - 1)];
	return $String;
}

/*функция скрытия части символов почты*/
function HideEmail($p1){
	$Explode = explode('@', $p1);
	return $Explode[0].'@*****';
}

/*Разрешение на просмотр страниц*/
function ULogin($p1){
	if ($p1 <= 0 and $_SESSION['USER_LOGIN_IN'] != $p1) MessageSend(1, 'Данная страница доступна только для гостей.', '/');
	else if ($_SESSION['USER_LOGIN_IN'] != $p1) MessageSend(1, 'Данная страница доступна только для пользователей.', '/');
}

/* Убираем отступы, заменяем теги на текст, trim обрезает пробелы справа и слева */
function FormChars ($p1) {
return nl2br(htmlspecialchars(trim($p1), ENT_QUOTES), false);
}

/*шифрование пароля п1 пароль п2 логин*/
function GenPass ($p1, $p2){
	return md5('MRSHIFT'.md5('321'.$p1.'123').md5('678'.$p2.'890'));
}

/*функция загрузки header*/
function Head($p1){
	echo '<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>'.$p1.'</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link href="/resource/style.css" rel="stylesheet">
	<script src="/resource/jquery-1.7.2.min.js"></script>
	<script src="/resource/jquery.timers.js"></script>
	<script src="/resource/script.js"></script>
	<link rel ="icon" href="/resource/img/favicon.ico" type="image/x-icon" >
</head>';
};

/*Функция перелистывания страниц*/
function PageSelector($p1, $p2, $p3, $p4 = 5){
/*
$p1 - url(например: /news/main/page)
$p2 - Текущая страница(из $Param['page'])
$p3 - Кол-во нвостей
$p4 - колво новостей на странице*/
	$Page = ceil($p3[0] / $p4); //делим колв новостей на колво записей на странице
	if ($Page > 1) { // а нужен ли переключатель?
		echo '<div class ="PageSelector">';
/*параметры +3 -3 за колическто до и после выделенной стр*/
		for ($i = ($p2 - 3); $i < ($Page + 1); $i++){
			if($i > 0 and $i <= ($p2 + 3)){
				if ($p2 == $i) $Swch = 'SwchItemCur';
				else $Swch = 'SwchItem';
				echo '<a class="'.$Swch.'" href="'.$p1.$i.'">'.$i.'</a>';
			}
		}
		echo '</div>';
	}
}



/*функция вывода миниатюр*/
function MiniIMG($p1, $p2, $p3, $p4, $p5 = 50){
/*
п1 - путь к изображению который надо уменьшить
п2 - директория, куда будет сохранена миникопия
п3 - Ширина мини копии
п4 - Высота мини копии
п5 - Качество мини копии
*/	
	$Scr = imagecreatefromjpeg($p1);
	$Size = getimagesize($p1);
	$Tmp = imagecreatetruecolor($p3, $p4);
	imagecopyresampled($Tmp, $Scr, 0, 0, 0, 0, $p3, $p4, $Size[0], $Size[1]);
	imagejpeg($Tmp, $p2, $p5);
	imagedestroy($Scr);
	imagedestroy($Tmp);
}

/*функция вывода меню*/
function Menu(){
	if ($_SESSION['USER_LOGIN_IN'] != 1) 
		$Menu = '<a href = "/login"><div class = "Menu">Вход</div></a>';
/*Чат убрать или изменить проверить еще раз*/		
		else $Menu = '<a href = "/loads"><div class = "Menu">Материалы конфереции</div></a>
			<a href = "/profile"><div class = "Menu">Профиль</div></a>
			';
	echo '<div class="MenuHead">
		<a href = "/"><div class = "Menu">Главная</div></a> 
		<a href = "/news"><div class = "Menu">Новости</div></a>
		<a href = "/speakers"><div class = "Menu">Докладчики</div></a>
		<a href = "/schedule"><div class = "Menu">Расписание</div></a>'.$Menu.'</div>';
}
/*Увеличение времени по 15 мин*/
function time_add_min( & $time, $min){
        list($h, $m) = explode(':', $time);
        $h = ($h + floor(($m + $min) / 60)) % 24;
        $m = ($m + $min) % 60;
        $time = $h . ':' . $m;
        return str_pad($h, 2, '0', STR_PAD_LEFT).':'.str_pad($m, 2, '0', STR_PAD_LEFT);
    }

/*Слайде*/
function Slider(){
	echo '
	<div class="slider-wrap slide-1">
	<div class="slider">
		<div class="slide"><img src="/resource/img/001.jpg" width="1000" height="500"></div>
		<div class="slide"><img src="/resource/img/002.jpg" width="1000" height="500"></div>
		<div class="slide"><img src="/resource/img/003.jpg" width="1000" height="500"></div>
		<div class="slide"><img src="/resource/img/004.jpg" width="1000" height="500"></div>
	</div>
</div>
';
}
/*Подвал*/
function Footer(){
	echo '<footer class="footer">
		©TGCDevCon Все права защищены. 2016г. Вы попали на сайт IT конфереции.
		<a href = "http://google.com" target="blank">Не нашел что искал попробуй тут</a>
	</footer>';
}

?>