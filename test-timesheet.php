<?php
include 'global.php';
conndb();

$rs = mysqli_query($conn,"SELECT `code`, `name` FROM `db_project` WHERE `status` != 0 ORDER BY `db_project`.`code` DESC");
echo '<pre>';
while($row=mysqli_fetch_assoc($rs)){
    echo 'TIME-'.$row['code'].'	'.$row['name'].'
';
}
echo '</pre>';

closedb();
