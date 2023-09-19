<?php
        $rss = mysqli_query($conn,"SELECT id,nick,level,mods,edits FROM `db_employee` WHERE `end_date` IS NULL AND (level > 8 OR edits LIKE '%\"ld\"%') ORDER BY `code` ASC");
        while($roww=mysqli_fetch_assoc($rss)){
                $ams[$roww['id']] = '<a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$roww['nick'].'">
                <img src="uploads/employee/'.$roww['id'].'.jpg" alt=".">
            </a>';
        }

        if(isset($ams[$_SESSION['ses_uid']])){
?>
<div class="row" style="height:50px;">
    <div class="col-6 avatar-group">
        <?php echo implode(' ',$ams);?>
    </div>
    <div class="col-6">
        <div class="btn-group float-right">
            <a href="?mod=ld" class="btn btn-outline-primary">Frontend</a>
            <a href="?mod=ld-comment" class="btn btn-outline-primary">Comment</a>
            <a href="?mod=ld-mat" class="btn btn-outline-primary active">Material</a>
            <a href="?mod=ld-feedback" class="btn btn-outline-primary">Feedback</a>
        </div>
    </div>
</div>
<?php }


    $rs = mysqli_query($conn,"SELECT * FROM `db_ld` WHERE `status` > 0 ORDER BY `session` ASC");

?>
<div class="table-responsive">
    <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
        <thead>
            <tr>
                <th><span class="text-muted">Session</span></th>
                <th><span class="text-muted">Workshop</span></th>
            </tr>
        </thead>
        <tbody><?php
// <td><a href="?mod=ld-comment&id='.$row['id'].'">Comment</a></td>
    while($row=mysqli_fetch_assoc($rs)){
                    echo '<tr class=" " data-id="'.$row['id'].'">
                            <td>'.$row['session'].'</td>
                            <td class="flex"><a href="/uploads/ld/'.$row['material'].'" target="_blank">'.$row['material'].'</a></td>
                            </tr>';
                }
            ?>                                        
            


            
        </tbody>
    </table>

    <form action="action.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="mod" value="ld">
        <select name="sid" required>
            <option value="">Session</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
        </select>
        <input type="file" name="mat" required>
        <input type="submit" value="Submit">
    </form>
</div>