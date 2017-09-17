<?php
UAccess(1);
if ($Module == 'category' and $Param['id']!= 1 and $Param['id']!= 2 and $Param['id']!= 3)MessageSend(1, 'Такой категории не существует', '/loads');
$Param['page'] +=0; 
Head('Каталог файлов'); 
?>
<body>
<div class="wrapper">
	<div class="header"></div>
	<div class="content">
		<?php Menu();?>
		<div class="CatHead">
			<?php
			if ($_SESSION['USER_LOGIN_IN']) 
				echo '
				<a href="/loads/add">
				<div class="Cat">
					Добавить материал
				</div>
			</a>
				';
			?>
			<a href="/loads">
				<div class="Cat">
					Все категории
				</div>
			</a>
			<a href="/loads/category/id/1">
				<div class="Cat">
					Железо
				</div>
			</a>
			<a href="/loads/category/id/2">
				<div class="Cat">
					Интернет
				</div>
			</a>
			<a href="/loads/category/id/3">
				<div class="Cat">
					Программное обеспечение
				</div>
			</a>
		</div>
		<?php MessageShow() ?>
		<div class="Page">
			<?php
			if (!$Module or $Module == 'main'){

/*Выборки в зависимости от тог где находиться пользователь*/
				if ($_SESSION['USER_GROUP'] != 2) $Active = 'WHERE `active` = 1'; 
				$Param1 = 'SELECT `id`, `name`, `added`, `date`, `active` FROM `load` '.$Active.' ORDER BY `id` DESC LIMIT 0, 5';
				$Param2 = 'SELECT `id`, `name`, `added`, `date`, `active` FROM `load` '.$Active.' ORDER BY `id` DESC LIMIT START, 5';
				$Param3 = 'SELECT COUNT(`id`) FROM `load`';
				$Param4 = '/loads/main/page/';
			}
			else if ($Module =='category'){

/*AND потомучто разные запросы*/
/*Active для пользователей и администраторов разные выборки*/
				if ($_SESSION['USER_GROUP'] != 2) $Active = 'AND `active` = 1';
				$Param1 = 'SELECT `id`, `name`, `added`, `date`, `active` FROM `load` WHERE `cat` = '.$Param['id'].' '.$Active.' ORDER BY `id` DESC LIMIT 0, 5';
				$Param2 = 'SELECT `id`, `name`, `added`, `date`, `active` FROM `load` WHERE `cat` = '.$Param['id'].' '.$Active.' ORDER BY `id` DESC LIMIT START, 5';
				$Param3 = 'SELECT COUNT(`id`) FROM `load` WHERE `cat` = '.$Param['id'];
				$Param4 = '/loads/category/id/'.$Param['id'].'/page/';
			}

			$Count = mysqli_fetch_row(mysqli_query($CONNECT, $Param3));

			if(!$Param['page']){
				$Param['page'] = 1;
				$Result = mysqli_query($CONNECT, $Param1);
			} else{
				$Start = ($Param['page'] - 1) * 5;
				$Result = mysqli_query($CONNECT, str_replace('START', $Start, $Param2));
			}
			
			while ($Row = mysqli_fetch_assoc($Result)){
				if(!$Row['active']) $Row['name'] .= ' (Ожидает модерации)';
				echo '
				<a href ="/loads/material/id/'.$Row['id'].'">
				<div class="ChatBlock">
				<span>
				Добавил: '.$Row['added'].' | '.$Row['date'].'
				</span>
				'.$Row['name'].'
				</div></a>';
			}
			PageSelector($Param4, $Param['page'], $Count);
			?>
		</div>
	</div>

	<?php Footer() ?>
</div>
</body>
</html>