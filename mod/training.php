<div class="btn-group float-right">
    <a href="?mod=training" class="btn btn-outline-primary active">Upcoming Courses</a>
    <a href="?mod=training-my" class="btn btn-outline-primary">My Registration</a>
    <a href="?mod=training-register" class="btn btn-outline-primary">Registration Status</a>
    <a href="?mod=training-summary" class="btn btn-outline-primary">Summary Report</a>
</div>

<h3 class="mb-5">Upcoming Courses</h3>

<?php
while($row=mysqli_fetch_assoc($rs)){
echo '<div class="row mb-3">
    <div class="col-md-3"><img src="uploads/training/tn.png" class="img-fluid"></div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-9">
                <h4>'.$row['title'].'</h4>

                <i class="mr-1" data-feather="calendar"></i> อบรมวันที่ '.webdate($row['train_date_from']).' - '.webdate($row['train_date_to']).'<br>
            </div>
            <div class="d-none">
                จำนวนที่รับสมัคร: 2 คน
            </div>
        </div>
        '.$row['detail'].'<br>
        <a href="?mod=training-view&id='.$row['id'].'" class="btn w-sm mb-1 btn-rounded btn-outline-info mt-3">Read more</a>
    </div>
</div>';
}