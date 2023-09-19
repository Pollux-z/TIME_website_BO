<pre><?php
$rs = mysqli_query($conn,"SELECT code,name FROM `db_project` WHERE `status` = 2 OR status = 3 ORDER BY `db_project`.`code` DESC");

while($row=mysqli_fetch_assoc($rs)){
    echo 'TIME-'.$row['code']."\t".$row['name'].'<br>';
}
?>
</pre>