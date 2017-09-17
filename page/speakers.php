<?php Head('Главная страница');?>
<body>

<div class="wrapper">

	<div class="header">
	
	</div>
	
	<div class="content">
		<?php
		Menu();
		MessageShow() ?>
		<div class="Page">
			<?php

			$Query = mysqli_query($CONNECT, 'SELECT `id`, `dimg`, `name`, `added` FROM `load` ORDER BY `date` DESC LIMIT 8'); //`date` DESC LIMIT 8'
			while ($Row = mysqli_fetch_assoc($Query)){
				echo'
				<div class="speakers">
					<a href="/loads/material/id/'.$Row['id'].'">
						<div class="photo">
							<img src="/catalog/mini/0.png" class="top">
							<img src="/catalog/mini/'.$Row['dimg'].'/'.$Row['id'].'.jpg" class ="lm" alt="'.$Row['name'].'" title="'.$Row['name'].'">
						</div>
						<div class="name"> '.$Row['added'].' </div>
							
						<div class="artname">
						'.$Row['name'].'
						</div>
					</a>
				</div>
				';
			}
			?>
		</div>
	</div>
	<?php Footer('Главная страница');?>
</div>

</body>
</html>

