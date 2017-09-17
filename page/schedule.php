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

      <table class="schedule">  
        <tbody><br>
          <H3>Время начала работы конференции 09:00. Среднее время выступления каждого участника 15-30 мин.</H3><br>
          <tr>
            <td class="table_time">Порядок выступления</td>
            <td class="table_active" colspan="7">Активности</td>
          </tr>
          <?php
		  $time = array();
          $Query = mysqli_query($CONNECT, 'SELECT `id`, `name`, `added`, `time_present` FROM `load` ORDER BY `time_present`'); 
		  //`date` DESC LIMIT 8'
          while ($Row = mysqli_fetch_assoc($Query)){
		  echo '
          <tr>  
            <td >'.$Row['time_present'].' - '.time_add_min($Row['time_present'], 30).'</td>
            <td><a href ="/loads/material/id/'.$Row['id'].'">'.$Row['name'].' Автор: '.$Row['added'].'</a></td>
          </tr>';
		  $j++;
        }
          ?>
        </tbody>
      </table>
      </div>
  <?php Footer('Главная страница');?>
</body>
</html>