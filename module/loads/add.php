<?php 
ULogin(1);
if($_SESSION['USER_GROUP'] == 2) $Active = 1;
else $Active = 0;

if($_POST['enter'] and $_POST['text'] and $_POST['cat'] and $_POST['name']){
	if ($_FILES['img']['type'] != 'image/jpeg') MessageSend(2, 'Неверный тип изображения.');
	$_POST['name'] = FormChars($_POST['name']);
	$_POST['text'] = FormChars($_POST['text']);
	$_POST['time_present'] = FormChars($_POST['time_present']);
	$_POST['cat'] += 0;
	if ($_FILES['file']['tmp_name']){
		if ($_FILES['file']['type'] != 'application/octet-stream') MessageSend(2, 'Неверный тип файла.');
		$_POST['link'] = 0;
	}
	else $num_file = 0;

/*ID для добавляемого материала*/
	$MaxId = mysqli_fetch_row(mysqli_query($CONNECT, 'SELECT max(`id`) FROM `load`'));
	if ($MaxId[0] == 0) mysqli_query($CONNECT, 'ALTER TABLE `load` AUTO_INCREMENT = 1');
	$MaxId[0] += 1;

/*проходим по каждой папке в каталоге dir для картинки */
	foreach (glob('catalog/img/*',GLOB_ONLYDIR) as $num => $Dir) {
	$num_img++;
/*Проверяем количество файлов в директории*/
		$Count = sizeof(glob($Dir.'/*.*'));
		if ($Count < 250){
			move_uploaded_file($_FILES['img']['tmp_name'], $Dir.'/'.$MaxId[0].'.jpg');
			break;
		}
	}

	MiniIMG('catalog/img/'.$num_img.'/'.$MaxId[0].'.jpg','catalog/mini/'.$num_img.'/'.$MaxId[0].'.jpg', 220, 220);

	if ($_FILES['file']['tmp_name']){
/*проходим по каждой папке в каталоге dir для файлов*/
		foreach (glob('catalog/file/*',GLOB_ONLYDIR) as $num => $Dir) {
			$num_file++;
	/*Проверяем количество файлов в директории*/
			$Count = sizeof(glob($Dir.'/*.*'));
			if ($Count < 250){
				move_uploaded_file($_FILES['file']['tmp_name'], $Dir.'/'.$MaxId[0].'.zip');
				break;
			}
		}
	}

	mysqli_query($CONNECT, "INSERT INTO `load` VALUES ('', '$_POST[name]',$_POST[cat],0, 0, '$_SESSION[USER_NAME]', '$_POST[text]', NOW(), $Active, $num_img, $num_file, '$_POST[time_present]')");
	MessageSend(2, 'Файл добавлен.', '/loads');
} 
Head('Добавить файл') ?>
<body>
<div class="wrapper">
<div class="header"></div>
<div class="content">
<?php Menu();
MessageShow() ?>
<div class="Page">
<form method="POST" action="/loads/add" enctype = "multipart/form-data">
<input type="text" name="name" placeholder="Название материала" required>
<br><select size="1" name="cat"><option value="1">Интернет</option><option value="2">Железо</option><option value="3">Программное обеспечение</option></select>
<br><br><input type="file" name="file" required> (Файл)
<br><br><input type="file" name="img" required> (Изображение)
<?php

$Row1 = mysqli_fetch_assoc(mysqli_query($CONNECT, 'SELECT `time_present` FROM `load` ORDER BY `id` DESC LIMIT 1'));
echo '
<input type="hidden" name="time_present" value="'.time_add_min($Row1['time_present'], 30).'"> ';
?>
<br><br><textarea class ="Add_L"name="text" required></textarea>
<br><input type="submit" name="enter" value="Добавить"> <input type="reset" value="Очистить">
</form>
</div>
</div>

<?php
Footer()
?>
</div>
</body>
</html>