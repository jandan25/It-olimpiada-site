<?php Head('Главная страница');?>
<body>

<div class="wrapper">

	<div class="header">
	
	</div>
	
	<div class="content">
		<?php
		Slider();
		Menu();
		MessageShow() ?>
		<div class="Page">
			<div class="row">
			<h2 class="h2">О конференции</h2>
      <br>
      <div class="main_text">TGCDevCon — крупнейшая конференция TGC для разработчиков в России. Мы проводим ее  в первый раз и  стараемся собрать неравнодушных к платформе Microsoft за чертой города, в отдалении от городской суеты, чтобы вместе обсудить актуальные технологии и попробовать свежие версии продуктов на практике.<br>
      В 2016 году TGCDevCon предстанет в уникальном формате. У участников мероприятия будет больше возможностей для практического погружения в технологии и получения новых знаний. При этом DevCon — это по-прежнему больше, чем просто конференция, с насыщенной программой и общением с экспертами и коллегами вне программы.<br>Форматы активностей:
      <ul>
      <li>Технологический доклад</li> 
      </ul>
      Лекция от эксперта Microsoft или индустрии с QA-блоком
      <ul>
      <li>Мастер-класс</li> 
      </ul>
      Двухчасовое погружение в тему, сочетающее теорию и практику
       <ul>
      <li>Интенсив</li> 
      </ul>
      Разработанный в секретных лабораториях коктейль из теории, практики и общения с экспертами Microsoft. Каждый интенсив — это ограниченная по количеству участников активность (до 50 человек), рассчитанная на 6 часов, в течение которых вы будете думать, работать с кодом и создавать свои собственные проекты. <br>
      <h2 class="h2">Интерактивная выставка</h2>
      Технологическая выставка DevCon соберет под открытым небом интереснейшие инновации от Microsoft и партнеров. Вы также сможете пообщаться с экспертами в неформальной обстановке и поучаствовать в дискуссиях в формате Chalk-Talk. Для участия в Chalk-Talk отправляйте свои заявки на адрес devconTalks@microsoft.com в формате: «Тема + Краткое содержание выступления».
      </div>

		</div><br><br>
    <div class="main_news">Последние новости:</div>
<?php

      $Query = mysqli_query($CONNECT, 'SELECT `id`, `text`, `name`, `added`, `date` FROM `news` WHERE `active` = 1 ORDER BY `date` DESC LIMIT 3'); 
      while ($Row = mysqli_fetch_assoc($Query)){
        echo '
        <a href ="/news/material/id/'.$Row['id'].'">
        <div class="ChatBlock">
        <span>
        Добавил: '.$Row['added'].' | '.$Row['date'].'
        </span>
        '.$Row['name'].'
        </div></a>';
      }
      ?>
	</div>
	<?php Footer('Главная страница');?>
</div>

</body>
</html>
