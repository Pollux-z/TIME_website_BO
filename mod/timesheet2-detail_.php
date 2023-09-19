<?php

$rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `id` = ".$_SESSION['ses_uid']);
$row = mysqli_fetch_assoc($rs);

$id = $row['id'];
$name = $row['name'];
$position = $row['position'];
$code = $row['code'];

?><div class="text-right mb-4">
    <a href="?mod=timesheet2-summary">Project Summary</a> | 
    <a href="?mod=timesheet2-overall">Overall & Team Summary</a>
</div>

<div class="row">
    <div class="col-lg-9">
    <div class="card" data-sr-id="1" style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
        <div class="card-body">
        <div class="row">
            <div class="col-6">
                <h1>October</h1>
            </div>
            <div class="col-5"></div>
            <div class="col-1"></div>
        </div>
        <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <td>วันที่</td>
                            <td>Project Number</td>
                            <td>Account Number</td>
                            <td>Hrs.</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        for($i=0;$i<5;$i++){
                            echo '<tr class="text-center">
                            <td>01 Oct 2021</td>
                            <td>TIME-202170</td>
                            <td>9001</td>
                            <td>8</td>
                            <td>
                                                    <div class="item-action dropdown">
                                                        <a href="#" data-toggle="dropdown" class="text-muted">
                                                            <i data-feather="more-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right bg-black" role="menu">
                                                            <a class="dropdown-item trash">
                                                                Delete item
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                        </tr>';
                        }
                        
                        ?>
                        
                    </tbody>
                </table>
</div></div>

    </div>
    <div class="col-lg-3 text-center">
    <div class="card" data-sr-id="2" style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
        <div class="card-body">
        <?php
        
        echo '<a href="#">
                    <div class="avatar w-64 mx-auto">
        <img src="/uploads/employee/'.$id.'.jpg" alt=".">
        <i class="on"></i>
        </div>
                </a>
        
                <h5 class="mt-3 text-center text-primary">
                    '.$name.'
                </h5>'.$position.'<br>
                ID: TIME'.$code.'
                
                <h5 class="my-4 text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg><br>
                December
                </h5>
                
                Total Work Hours
                <h3 class="mb-3 text-primary">120</h3>
                
                Total Man Day
                <h3 class="mb-5 text-primary">15</h3>';
        
        ?>
        <a href="?mod=timesheet2-full">See Full Report ></a><br>
        </div>
</div>
    </div>
</div>