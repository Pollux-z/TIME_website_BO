<?php
    if($_GET['page']=='summary'&&$_SESSION['ses_ulevel']>7){
        if(isset($_GET['q'])){
            $q = $_GET['q'];
        }else{
            // $q = '20Q3';
            if(date(n)>6){
                $h = 2;
            }else{
                $h = 1;
            }
            $q = date('y').'H'.$h;
        }
        // echo '<!--'.$q.'55-->';

        $rss = mysqli_query($conn,"SELECT * FROM `db_culture_answer` WHERE q like '$q'");
        while($roww=mysqli_fetch_assoc($rss)){
            $answers[$roww['uid']][$roww['qid']] = $roww['answer'];
        }

        $rss = mysqli_query($conn,"SELECT `id`, `code`, `name`, `nick` FROM `db_employee` WHERE id >2 AND `end_date` IS NULL");
        while($roww=mysqli_fetch_assoc($rss)){
            $time1[$roww['id']] = [
                'code' => $roww['code'],
                'name' => $roww['name'],
                'nick' => $roww['nick'],
            ];
        }

        $rss = mysqli_query($conn,"SELECT `no` FROM `db_culture_quiz`");
        while($roww=mysqli_fetch_assoc($rss)){
            $quizs[] = $roww['no'];
        }

        echo '<div class="mb-2 text-right">';

        $rss = mysqli_query($conn,"SELECT DISTINCT `q` FROM `db_culture_answer` ORDER BY `db_culture_answer`.`q` DESC");
        while($roww=mysqli_fetch_assoc($rss)){
            echo ' | <a href="?mod=culture&page=summary&q='.$roww['q'].'">'.$roww['q'].'</a>';
        }
        
        echo '</div>
        
        <div class="text-right my-3"><a href="exportData.php?page=culture&q='.$q.'" target="_blank"><i class="mx-2" data-feather="download"></i>Download CSV</a></div>
        
        <div class="table-responsive">
        <table id="datatable" class="table v-middle table-bordered" data-plugin="dataTable">
        <thead>
          <tr class="text-center">
            <th scope="col" class="text-left">Code</th>
            <th scope="col" class="text-left">Name</th>';

            foreach($quizs as $v){
                echo '<th>'.$v.'</th>';
            }
            
          echo '</tr>
        </thead>
        <tbody>';

        foreach($time1 as $k => $v){
            echo '<tr class="text-center" data-id="'.$k.'">
            <td>TIME'.str_pad($v['code'], 3, '0', STR_PAD_LEFT).'</td>
            <td><a href="?mod=culture&id='.$k.'">'.$v['name'].' ('.$v['nick'].')</a></td>';

            foreach($quizs as $w){
                echo '<td>'.$answers[$k][$w].'</td>';
            }

            echo '</tr>';
        }

        echo '</tbody></table></div>';

    }else{

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }else{
        $id = $_SESSION['ses_uid'];
    }

    if(date(n)>6){
        $h = 2;
    }else{
        $h = 1;
    }
    $q = date('y').'H'.$h;
    
    $sql = "SELECT * FROM `db_culture_answer` WHERE q like '$q' AND `uid` = ".$id;
    $rss = mysqli_query($conn,$sql);
    $cntt = mysqli_num_rows($rss);

    echo "<!--$sql-->";

    if($cntt!=0){
        $row = mysqli_fetch_assoc($rs);
        $cats = json_decode($row['cats']);
        
        $rs = mysqli_query($conn,"SELECT * FROM `db_culture_answer` WHERE `uid` = ".$id);
        while($row=mysqli_fetch_assoc($rs)){
            $dt[$row['q']][$row['qid']] = $row['answer'];
        }
?>
<table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead>
    <tr class="text-center">
      <th scope="col" class="text-left">Question</th>
      <th scope="col">Result Q2</th>
      <th scope="col">Result Q3</th>
    </tr>
  </thead>
  <tbody>
  <?php 
//   foreach($cats as $k => $v){
    $rs = mysqli_query($conn,"SELECT * FROM `db_culture_quiz`");
    while($row=mysqli_fetch_assoc($rs)){
?>
    <tr class="text-center">
      <th scope="row" class="text-left"><?php echo $row['no'].' '.$row['title'];?></th>
      <td><?php 
        if(isset($dt['20Q2'][$row['no']])){
          echo $dt['20Q2'][$row['no']];
        }?></td>
      <td><?php 
        if(isset($dt['20Q3'][$row['no']])){
          echo $dt['20Q3'][$row['no']];
        }?></td>
    </tr>
    <?php }?>
  </tbody>
</table>

<?php }else{
    // $sql = "SELECT * FROM db_culture";
    // $rs = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($rs);
    $cats = json_decode($row['cats']);

    echo '<h1>'.$row['title'].'</h1>';
    echo '<b>Instruction:</b> '.$row['detail'].'<br><br>';

    $rs = mysqli_query($conn,"SELECT * FROM `db_culture_quiz`");
    while($row=mysqli_fetch_assoc($rs)){
        $quizes[$row['cat']][$row['no']] = [
            'title' => $row['title'],
            'detail' => $row['detail'],
        ];
    }

    ?><form action="action.php" method="post"><?php
    foreach($cats as $k => $v){
        echo '<h5>'.$k.'.) '.$v.'</h5>';
        foreach($quizes[$k] as $no => $b){
            echo '<div class="form-group row">
        <label class="col-12 col-form-label">'.$no.' '.$b['title'].' '.$b['detail'].'</label>
        <div class="col-12">
            <div class="mt-2 mb-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ans['.$no.']" id="ans'.$no.'1" value="1" required>
                    <label class="form-check-label" for="ans'.$no.'1">น้อยที่สุด</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ans['.$no.']" id="ans'.$no.'2" value="2" required>
                    <label class="form-check-label" for="ans'.$no.'2">น้อย</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ans['.$no.']" id="ans'.$no.'3" value="3" required>
                    <label class="form-check-label" for="ans'.$no.'3">ปานกลาง</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ans['.$no.']" id="ans'.$no.'4" value="4" required>
                    <label class="form-check-label" for="ans'.$no.'4">มาก</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ans['.$no.']" id="ans'.$no.'5" value="5" required>
                    <label class="form-check-label" for="ans'.$no.'5">มากที่สุด</label>
                </div>
            </div>
        </div>
    </div>';
    }
    }?>
    <input type="hidden" name="mod" value="culture">
    <input type="hidden" name="q" value="<?php echo $q;?>">
    <input type="submit" class="btn btn-primary">
    </form>
<?php }}?>