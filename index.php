<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
  <script type="text/javascript" src="assets/js/jquery.filedrop.js"></script>
  <script type="text/javascript" src="assets/js/script.js"></script>
  <link rel="stylesheet" href="assets/css/styles.css">
  <title>Document</title>
</head>
<body>
<?php
$upLine = 10000;
$prevPrevVal = 0;
$prevVal = 1;
$currVal = 0;

while( $currVal < $upLine ) : 
  $n++;
  if ( $currVal % 2 == 0 ) : 
    echo( $n . ") <strong>" . $currVal . "</strong> <br>");
    $sum += $currVal;
  else : 
    echo( $n . ") " . $currVal . " <br>");
  endif;
  $currVal = $prevVal + $prevPrevVal;
  $prevPrevVal = $prevVal;
  $prevVal = $currVal;
endwhile;
echo("<p>Cумма четных членов последовательности = " . $sum . "<p><br>" );
?>


<?php
$birthday;
$connection = new mysqli("localhost","root","",'alef');
$query = "select name, birthday from users where DATE_FORMAT(birthday,'%m-%d') >= DATE_FORMAT(CURDATE(),'%m-%d') and DATE_FORMAT(birthday,'%m-%d') <= DATE_FORMAT(CURDATE() + INTERVAL 1 MONTH,'%m-%d')";
$result = $connection->query($query);
while($row = mysqli_fetch_array($result)) 
{
echo '<p>';
echo $row['name']."<br>";
$birthday = date("Y-m-d", strtotime($row['birthday']))."<br>";
$diff=date('d', strtotime($row['birthday'])) - date('d', strtotime(date('Y-m-d')));
echo ("День рождения = " . $birthday . "До его начала = " . $diff . " дней(я)<br>");
echo '</p>';
}
?>

<div id="dropbox">
            <span class="message">Перенесите сюда изображения для загрузки</span>
            <div class="color">
            <span></span>
        </div>
        </div>        
</body>
</html>