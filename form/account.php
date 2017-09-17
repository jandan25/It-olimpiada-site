<?php
/*при нажатии на кнопку выход удаляем все сессии и куки*/
if ($Module == 'logout' and $_SESSION['USER_LOGIN_IN'] == 1){
	if ($_COOKIE['user']) {
		setcookie('user', '', strtotime('-30 days'), '/');
		unset($_COOKIE['user']);
	}
	session_unset();
	/*редирект на страницу логин*/
	exit(header('Location: /login'));
}
/*Проверка на редактирование*/
if ($Module == 'edit' and $_POST['enter']){
	/*Проверка на возможность просмотра страницы*/
	ULogin(1); 
	$_POST['opassword'] = FormChars($_POST['opassword']);
	$_POST['npassword'] = FormChars($_POST['npassword']);
	$_POST['name'] = FormChars($_POST['name']);
	$_POST['country'] = FormChars($_POST['country']);

/*Проверки на указание нового и старого паролей*/
	if ($_POST['opassword'] or $_POST['npassword']){
		if (!$_POST['opassword']) MessageSend(2, 'Нe указан старый пароль.');
		if (!$_POST['npassword']) MessageSend(2, 'Нe указан новый пароль.');
		$Password = GenPass($_POST['npassword'],$_SESSION['USER_LOGIN']);
		if ($_SESSION['USER_PASSWORD'] != GenPass($_POST['opassword'],$_SESSION['USER_LOGIN'])) MessageSend(2, 'Старый пароль указан не верно.');
/*генерируем новый пароль*/
		$Password = GenPass($_POST['npassword'],$_SESSION['USER_LOGIN']);

/*Подключаемся к бд и обновляем по id пароль*/
		mysqli_query($CONNECT, "UPDATE `users` SET `password` = '$Password' WHERE `id` = $_SESSION[USER_ID]");
		$_SESSION['USER_PASSWORD'] = $Password;
	}

/*Подключаемся к бд и обновляем по id имя*/
	if($_POST['name'] != $_SESSION['USER_NAME']){
		mysqli_query($CONNECT, "UPDATE `users` SET `name` = '$_POST[name]' WHERE `id` = $_SESSION[USER_ID]");
		$_SESSION['USER_NAME'] = $_POST['name'];
	}

/*Подключаемся к бд и обновляем по id имя*/	
	if(UserCountry($_POST['country']) != $_SESSION['USER_COUNTRY']){
		mysqli_query($CONNECT, "UPDATE `users` SET `country` = '$_POST[country]' WHERE `id` = $_SESSION[USER_ID]");
		$_SESSION['USER_COUNTRY'] = UserCountry($_POST['country']);		
	}

/*проверка загрузки аватара*/
	if ($_FILES['avatar']['tmp_name']){

/* проверка на тип изображения*/
		if ($_FILES['avatar']['type'] != 'image/jpeg') MessageSend(2, 'Неверный тип изображения.');

/*Проверка на размер файла : примерно 20 кбайт*/
		if ($_FILES['avatar']['size'] > 20000) MessageSend(2, 'Размер изображеня слишком большой.');

/*Пройденная проверка, создаем изображение аватарки*/
		$Image = imagecreatefromjpeg($_FILES['avatar']['tmp_name']);
		$Size = getimagesize($_FILES['avatar']['tmp_name']);

/*с разрешением 120 на 120*/
		$Tmp = imagecreatetruecolor(120, 120);

/*перекопируем наше изображение*/
		imagecopyresampled($Tmp, $Image, 0, 0, 0, 0, 120, 120, $Size[0], $Size[1]);
/*Если у пользователя аватар не выбран вообще*/
		if($_SESSION['USER_AVATAR'] == 0){

/*подсчитываем количество директорий с любым именем в этом каталоге*/
			$Files = glob('resource/avatar/*',GLOB_ONLYDIR);

/*проходим по каждой папке в каталоге dir*/
			foreach ($Files as $num => $Dir) {
				$Num++;

/*Проверяем количество файлов в директории*/
				$Count = sizeof(glob($Dir.'/*.*'));
				if ($Count < 250){

/*Если меньше то сохраняем в текущий каталог*/
					$Download = $Dir.'/'.$_SESSION['USER_ID'];
					$_SESSION['USER_AVATAR'] = $Num;
					mysqli_query($CONNECT, "UPDATE `users` SET `avatar` = $Num WHERE `id` = $_SESSION[USER_ID]");
					break;
				}
			}
		}
/*Если есть аватар то загружаем*/
		else $Download = 'resource/avatar'.$_SESSION['USER_AVATAR'].'/'.$_SESSION['USER_ID'];
/*создаем изображение с форматом и уничтожаем которые использовали*/
		imagejpeg($Tmp, $Download.'.jpg');
		imagedestroy($Image);
		imagedestroy($Tmp);
	}
	MessageSend(3, 'Данные изменены.');
}




/*Проверка на возможность просмотра страницы*/
ULogin(0); 

if ($Module == 'restore' and !$Param['code'] and substr($_SESSION['RESTORE'], 0, 4) == 'wait') MessageSend(2, 'Вы уже отправили заявку на восстановление пароля. Проверьте ваш E-Mail адрес <b>'.HideEmail(substr($_SESSION['RESTORE'], 5)).'</b>');
if ($Module == 'restore' and $$_SESSION['RESTORE'] and substr($_SESSION['RESTORE'], 0, 4) != 'wait') MessageSend(2, 'Ваш пароль уже ранее был изменен. Для входа используйте новый пароль <b>'.$_SESSION['RESTORE'].'</b>', 'login');

if ($Module == 'restore' and $Param['code']){
/* соединение с БД для выбора пользователя !md5 для имейла отдельного*/
	$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, 'SELECT `login` FROM `users` WHERE `id` = '.str_replace(md5(substr($_SESSION['RESTORE'], 5)), '', $Param['code'])));
	if (!$Row['login']) MessageSend(1, 'Невозможно восстановить пароль.', '/login');
	$Random = RandomString(15);
	$_SESSION['RESTORE'] = $Random;
	mysqli_query($CONNECT, "UPDATE `users` SET `password` = '".GenPass($Random, $Row['login'])."' WHERE `login` = '$Row[login]'");	
	MessageSend(2, 'Пароль успешно изменен, для входа используйте новый пароль: <b>'.$Random.'</b>', '/login');
}


if ($Module == 'restore' and $_POST['enter']){
	$_POST['login'] = FormChars($_POST['login']);
	$_POST['captcha'] = FormChars($_POST['captcha']);
/*проверки на неправильность ввода*/
	if (!$_POST['login'] or !$_POST['captcha']) MessageSend(1, 'Невозможно обработать форму.');
	if ($_SESSION['captcha'] != md5($_POST['captcha'])) MessageSend(1, 'Капча введена не верно.');
/* соединение с БД для выбора пользователя*/
	$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id`, `email` FROM `users` WHERE `login` = '$_POST[login]'"));	
	if (!$Row['email']) MessageSend(1, 'Пользователь не найден.');
/*отправляем нашу ссылку на почту !md5*/
	mail($Row['email'], 'Восстановление пароля', 'Ссылка для восстановления: http://olimpiada.ru/account/restore/code/'.md5($Row['email']).$Row['id'], 'From: olimpiada.ru');
	$_SESSION['RESTORE'] = 'wait_'.$Row['email'];
	MessageSend(1, 'На ваш E-Mail адрес <b>'.HideEmail($Row['email']).'</b> отправлено сообщение подтверждения смены пароля<b>');
}


if ($Module == 'register' and $_POST['enter']){

	/*проверка функцией на ввод пакостей*/
	$_POST['login'] = FormChars($_POST['login']);
	$_POST['email'] = FormChars($_POST['email']);

/*шифрование пароля с помощью функции шифрования*/
	$_POST['password'] = GenPass(FormChars($_POST['password']), $_POST['login']);
	$_POST['name'] = FormChars($_POST['name']);
	$_POST['country'] = FormChars($_POST['country']);
	$_POST['captcha'] = FormChars($_POST['captcha']);


/* проверка на не пустые поля*/
	if (!$_POST['login'] or !$_POST['email'] or !$_POST['password'] or !$_POST['name'] or !$_POST['country'] > 4 or !$_POST['captcha']) MessageSend(1, 'Невозможно обработать форму.');

	if ($_SESSION['captcha'] != md5($_POST['captcha'])) MessageSend(1, 'Капча введена не верно.');

/* соединение с БД для выбора пользователя*/
	$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `login` FROM `users` WHERE `login` = '$_POST[login]'"));

/*если такой логин существует то выводим сообщение*/
	if ($Row['login']) exit('Логин <b>'.$_POST['login'].'</b> уже используется.');

/* соединение с БД для выбора email*/
	$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `email` FROM `users` WHERE `email` = '$_POST[email]'"));

/*если такой email существует то выводим сообщение*/
	if ($Row['email']) exit('E-Mail <b>'.$_POST['email'].'</b> уже используется.');

/*Добавляем нового пользователя*/
	mysqli_query($CONNECT, "INSERT INTO `users` VALUES ('','$_POST[login]','$_POST[password]','$_POST[name]', NOW(),'$_POST[email]','$_POST[country]', 0 , 0, 0)");
/*кодируем ссылку для активации*/
	$Code = str_replace('=', '', base64_encode($_POST['email']));
/*отправляем нашу ссылку на почту*/
	mail($_POST['email'], 'Регистрация на блоге', 'Ссылка для активации: http://olimpiada.ru/account/activate/code/'.substr($Code, -5).substr($Code, 0, -5), 'From: olimpiada.ru');
/*выводим сообщение о отправке писмьма на почту*/
	MessageSend(3, 'Регистрация аккаунта успешно завершена. На указанный E-Mail адрес <b>'.$_POST['email'].'</b> отправлено письмо о подтверждении регистрации.');
}

/*проверка на модуль и наличие кода*/
else if ($Module == 'activate' and $Param['code']) {
	if (!$_SESSION['USER_ACTIVE_EMAIL']) {

/*раскодируем имейл*/
		$Email = base64_decode(substr($Param['code'], 5).substr($Param['code'], 0, 5));

/*если есть собака то записываем в бд*/
		if (strpos($Email, '@') !== false){
			mysqli_query($CONNECT, "UPDATE `users` SET `active` = 1 WHERE `email` = '$Email'");
			$_SESSION['USER_ACTIVE_EMAIL'] = $Email;
			MessageSend(3, 'E-Mail <b>'.$Email.' подтвержден.</b>', '/login');
		}

/*при 1 переходе емейл подтверждается при 2 выдается сообщение уже подтвержден*/
		else MessageSend(1, 'E-Mail адрес не подтвержден.', '/login');
	}
	else MessageSend(1, 'E-Mail адрес <b>'.$_SESSION['USER_ACTIVE_EMAIL'].'</b> уже подтвержден.', '/login');
}

/*проверка на модуль логина и нажатие кнопки логин*/
else if ($Module == 'login' and $_POST['enter']) {
	$_POST['login'] = FormChars($_POST['login']);
	$_POST['password'] = GenPass(FormChars($_POST['password']), $_POST['login']);
	$_POST['captcha'] = FormChars($_POST['captcha']);
/*проверки на неправильность ввода*/
	if (!$_POST['login'] or !$_POST['password'] or !$_POST['captcha']) MessageSend(1, 'Невозможно обработать форму.');
	if ($_SESSION['captcha'] != md5($_POST['captcha'])) MessageSend(1, 'Капча введена не верно.');
	$Row  = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `password`, `active` FROM `users` WHERE `login` 
		= '$_POST[login]'"));
	if ($Row['password'] != $_POST['password']) MessageSend(1, 'Не верный логин или пароль.');
	if ($Row['active'] == 0) MessageSend(1, 'Аккаунт пользователя <b>'.$_POST['login'].'</b> не подтвержден.');

/*выбираем из бд значения залогиненного пользователя*/
	$Row  = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id`, `name`, `regdate`, `email`, `country`, `avatar`, `password`, `login`, `group` FROM `users` WHERE `login` = '$_POST[login]'"));

/*записываем данные в глобальный массив сессии*/
	$_SESSION['USER_LOGIN'] = $Row['login'];
	$_SESSION['USER_PASSWORD'] = $Row['password'];
	$_SESSION['USER_ID'] = $Row['id'];
	$_SESSION['USER_NAME'] = $Row['name'];
	$_SESSION['USER_REGDATE'] = $Row['regdate'];
	$_SESSION['USER_EMAIL'] = $Row['email'];
	$_SESSION['USER_COUNTRY'] = UserCountry($Row['country']);
	$_SESSION['USER_AVATAR'] = $Row['avatar'];
	$_SESSION['USER_LOGIN_IN'] = 1;
	$_SESSION['USER_GROUP'] = $Row['group'];

/*создаем куки при выборе запомнить меня*/
	if ($_REQUEST['remember']){
/*имя с1 значение хеш пароль время 30 дней место сохранения*/
		setcookie('user', $_POST['password'], strtotime('+30 days'), '/');
	}

/*редирект на страницу профиль*/
	exit(header('Location: /profile'));
}
?>