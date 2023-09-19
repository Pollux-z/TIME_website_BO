<?php 
header('Content-Type: application/json');
    include 'global.php';
    conndb();

    if(isset($_GET['account_no'])){
        $account_no = $_GET['account_no'];

    }else{
        $account_no = '9001';

    }

    $projects = [];
    $rs = mysqli_query($conn,"SELECT b.id,a.id tid,a.uid,b.date2,b.project_no,b.description,b.location,b.remark,b.hour FROM `db_timesheet` a JOIN db_timesheet_detail b WHERE a.`month` = '2020-02' AND a.`status` = 2 and a.id = b.tid and b.account_no = '$account_no'");
    while($row=mysqli_fetch_assoc($rs)){
        $projects[$row['project_no']][$row['uid'].'-'.$row['tid']][] = [
            'detail' => [
                'id' => $row['id'],
                'date' => $row['date2'],
                'description' => $row['description'],
                'location' => $row['location'],
                'remark' => $row['remark'],
                'hour' => $row['hour']
            ]
        ];
    }

    echo json_encode($projects);
    // foreach($projects as $project_no => $uid){
    //     echo $project_no.'<br>';
    //     foreach($uid as $tid => $detail){
    //         echo $tid.'<br>';
    //         foreach($detail as $k){
    //             foreach($k as $k => $v){
    //                 foreach($v as $l => $w){
    //                     echo $l.' = '.$w.'<br>';
    //                 }
    //                 echo '<br>';
    //             }
    //         }
    //         // echo '<br><br>';
    //     }
    // }

    closedb();
?>