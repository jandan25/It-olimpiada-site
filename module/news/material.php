<?
$Param['id'] += 0;
if ($Param['id'] == 0) MessageSend(1, 'Url адрес указан не верно.','/news'); 
$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, 'SELECT `name`, `added`, `date`, `read`, `text`, `active` FROM `news` WHERE `id` = '.$Param['id']));
if (!$Row['name']) MessageSend(1, 'Такой новости не существует.','/news');

if (!$Row['active'] and $_SESSION['USER_GROUP']!= 2) MessageSend(1, 'Новость ожидает модерации.','/news');


mysqli_query($CONNECT, 'UPDATE `news` SET `read` = `read` + 1 WHERE `id` = '.$Param['id']);
Head($Row['name']); 
?>
<body>
<div class="wrapper">
	<div class="header"></div>
	<div class="content">
		<?php Menu();
		MessageShow() ?>
		<div class="Page">
			<?php
			if (!$Row['active']) $Active = ' | <a href="/news/control/id/'.$Param['id'].'/command/active" class="Edit">Активировать новость</a>';
			if ($_SESSION['USER_GROUP'] == 2) 
				$EDIT ='
			| <a href="/news/edit/id/'.$Param['id'].'" class="Edit">Редактировать новость</a> | <a href="/news/control/id/'.$Param['id'].'/command/delete" class="Edit">Удалить новость</a>'.$Active;
			echo 'Просмотров: '.($Row['read'] + 1).' | Добавил '.$Row['added'].' | Дата '.$Row['date'].' '.$EDIT.'<br><br><b>'.$Row['name'].'</b><br>'.$Row['text'];
			?>
		</div>
	</div>

	<?php Footer() ?>
</div>
</body>
</html>