<?php
include 'global.php';
conndb();

// $rs = mysqli_query($conn,"SELECT * FROM `db_employee`");
// while($row=mysqli_fetch_assoc($rs)){
//     $uid = $row['id'];
//     $day = $row['vacation_day'];
//     $notes = $row['vacation_notes'];
    
//     $rss = mysqli_query($conn,"INSERT INTO `db_timeoff_vacation` (`year`, `uid`, `day`, `notes`) VALUES ('2020', '$uid', '$day', '$notes');");

//     echo $row['nick'].' done<br>';
// }


// $rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `end_date` IS NULL");
// while($row=mysqli_fetch_assoc($rs)){
//     $uid = $row['id'];
//     $day = $row['vacation_day'];

//         $days = [
//             'v' => 0,
//             'p' => 0,
//             's' => 0,
//         ];

//         $rss = mysqli_query($conn,"SELECT a.date,a.tid,ttype,half FROM `db_timeoff_date` a join db_timeoff b where a.tid = b.id and b.status = 2 and b.uid = $uid and a.date like '2020-%'");
                
//         while($roww=mysqli_fetch_assoc($rss)){
//             $days[$roww['ttype']] = $roww['half']+$days[$roww['ttype']];
//             $dates[] = $roww['date'].'/'.$roww['tid'];
//         }

//         $left = $day-$days['v'];  

//         // $rs = mysqli_query($conn,"SELECT vacation_day FROM `db_employee` WHERE `id` = $uid");
//         // $row = mysqli_fetch_assoc($rs);

//     $rss = mysqli_query($conn,"INSERT INTO `db_timeoff_vacation` (`year`, `uid`, `day`) VALUES ('2021', '$uid', '$left');");

//     echo $row['nick'].' done<br>';
// }


$rs = mysqli_query($conn,"SELECT * FROM `db_timeoff_vacation` WHERE `year` = '2021'");
while($row=mysqli_fetch_assoc($rs)){
    $id = $row['id'];
    $days = $row['day']+12;
    
    $rss = mysqli_query($conn,"UPDATE `db_timeoff_vacation` SET `day` = '$days' WHERE `db_timeoff_vacation`.`id` = $id;");    
}

closedb();