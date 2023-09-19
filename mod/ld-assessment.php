<?php 

$rs = mysqli_query($conn,"SELECT * FROM `db_ld_assessment` WHERE `uid` = ".$_SESSION['ses_uid']." AND `sid` = ".$_GET['sid']);

if(mysqli_num_rows($rs)>0){
    echo '<div class="text-center"><h2>ได้รับข้อมูลแล้ว ขอบคุณค่ะ</h2>
    
    <a href="?mod=ld" class="btn btn-primary">กลับหน้าแรก</a></div>';

}else{?>แบบประเมินความพึงพอใจต่อการเข้าร่วม FTE L&D Training Program 2022
แบบประเมินมีทั้งหมด 1 ตอน ขอให้ผู้ตอบแบบประเมินตอบให้ครบทุกข้อ เพื่อให้ทราบว่า
ผู้เข้ารับการ Training มีความเข้าใจและได้รับประโยชน์เกี่ยวกับการอบรมครั้งนี้มากน้อยเพียงใด<br><br>

<?php
    $questions = [
        // 1 => 'ชื่อ-นามสกุล',
        // 2 => 'ชื่อเล่น',
        // 3 => 'อายุ',
        // 4 => 'เพศ',
        // 5 => 'ตำแหน่ง',
        // 1 => 'ความพึงพอใจด้านวิทยากร ให้คะแนนโดยเรียงลำดับความพึงพอใจมากที่สุดจาก 1-5 (1 คือพึงพอใจน้อยที่สุด และ 5 คือ พึงพอใจมากที่สุด)',
        1 => 'ความพึงพอใจด้านผู้เข้าอบรมรับฟัง ให้คะแนนโดยเรียงลำดับความพึงพอใจมากที่สุดจาก 1-5 (1 คือพึงพอใจน้อยที่สุด และ 5 คือ พึงพอใจมากที่สุด)',
    ];
    // $choices = [
    //     4 => ['ชาย','หญิง'],
    //     5 => [
    //         'Business Analyst/ Senior Business Analyst',
    //         'Technology Analyst/ Senior Technology Analyst',
    //         'Consultant/ Senior Consultant',
    //         'Business Development/ Senior Business Development',
    //         'Corporate Development',
    //         'Marketing and Technology',
    //         'Business Operation',
    //         'Case Team Assistant'
    //     ],
    // ];
    $rates = [
        // 1 => [
        //     1 => 'ความชัดเจนในการอธิบายเนื้อหา',
        //     2 => 'การใช้เวลาในการอธิบายเนื้อหาได้เหมาะสม',
        //     3 => 'ความน่าสนใจของการนำเสนอ',
        //     4 => 'การอธิบายเนื้อหาได้เข้าใจง่าย',
        //     5 => 'การให้ความช่วยเหลือของวิทยากร',
        // ],
        1 => [
            1 => 'มีความเข้าใจในเนื้อหาที่วิทยากรอธิบาย',
            2 => 'ได้รับความรู้เพิ่มเติมมากขึ้น',
            3 => 'สามารถนำไปปรับใช้งานได้จริง',
            4 => 'สามารถให้คำปรึกษาแก่เพื่อนร่วมงานได้',
            5 => 'ได้รับคำแนะนำที่เป็นประโยชน์เมื่อต้องการความช่วยเหลือ',
        ],
    ];
?>

<form action="action.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="mod" value="ld">
    <input type="hidden" name="sid" value="<?php echo $_GET['sid'];?>">
    <?php
    
    foreach($questions as $k => $v){
        echo $k.'. '.$v.'<br>';

        if(isset($choices[$k])){
            foreach($choices[$k] as $vv){
                echo '<input type="radio" value="'.$vv.'"> '.$vv.'<br>';
            }

        }elseif(isset($rates[$k])){
            echo '<table class="table"><tr><td></td><td width="50">1</td><td width="50">2</td><td width="50">3</td><td width="50">4</td><td width="50">5</td></tr>';
            foreach($rates[$k] as $kk => $vv){
                echo '<tr><td>'.$kk.'. '.$vv.'</td>
                <td><input type="radio" name="rates['.$k.']['.$kk.']" value="1" required></td>
                <td><input type="radio" name="rates['.$k.']['.$kk.']" value="2" required></td>
                <td><input type="radio" name="rates['.$k.']['.$kk.']" value="3" required></td>
                <td><input type="radio" name="rates['.$k.']['.$kk.']" value="4" required></td>
                <td><input type="radio" name="rates['.$k.']['.$kk.']" value="5" required></td></tr>';
            }
            echo '</table>';
        }else{
            echo '<input>';
        }

        echo '<br><br>';
    }
    
    ?>
    <input type="submit" class="btn btn-primary" value="Submit">
</form>
<?php }?>