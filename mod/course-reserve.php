<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong>Reserve <?php 

                $rs = mysqli_query($conn,"SELECT * FROM `db_course` WHERE `id` = $id");
                $row = mysqli_fetch_assoc($rs);

                echo $row['name'].' on '.$row['owner'];
                
                // echo ucfirst($_GET['code']);
    
                ?></strong>
            </div>
            <div class="card-body">
            <form action="action.php" method="POST">
                <div class="form-group row row-sm">
                    <label class="col-sm-3 col-form-label">Date</label>
                    <div class="col-sm-9">
                        <div class='input-group input-daterange' data-plugin="datepicker" data-option="{todayBtn: 'linked'}">
                            <input type='text' class="form-control" name="from_date" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text">to</span>
                            </div>
                            <input type='text' class="form-control" name="to_date" required>
                        </div>                        
                    </div>
                </div>
                <div class="form-group row row-sm">
                    <label class="col-sm-3 col-form-label">Time</label>
                    <div class="col-sm-9">


                    <div class='input-group input-daterange'>
                        <select name="from_time" id="" class="form-control" required>
                            <option value="">From</option>
                            <option>07:00</option>
                            <option>07:30</option>
                            <option>08:00</option>
                            <option>08:30</option>
                            <option>09:00</option>
                            <option>09:30</option>
                            <option>10:00</option>
                            <option>10:30</option>
                            <option>11:00</option>
                            <option>11:30</option>
                            <option>12:00</option>
                            <option>12:30</option>
                            <option>13:00</option>
                            <option>13:30</option>
                            <option>14:00</option>
                            <option>14:30</option>
                            <option>15:00</option>
                            <option>15:30</option>
                            <option>16:00</option>
                            <option>16:30</option>
                            <option>17:00</option>
                            <option>17:30</option>
                            <option>18:00</option>
                            <option>18:30</option>
                            <option>19:00</option>
                            <option>19:30</option>
                            <option>20:00</option>
                            <option>20:30</option>
                            <option>21:00</option>
                            <option>21:30</option>
                            <option>22:00</option>
                            <option>22:30</option>
                            <option>23:00</option>
                            <option>23:30</option>
                            <option>00:00</option>
                            <option>00:30</option>
                            <option>01:00</option>
                            <option>01:30</option>
                            <option>02:00</option>
                            <option>02:30</option>
                            <option>03:00</option>
                            <option>03:30</option>
                            <option>04:00</option>
                            <option>04:30</option>
                            <option>05:00</option>
                            <option>05:30</option>
                            <option>06:00</option>
                            <option>06:30</option>
                        </select>
                        <div class="input-group-prepend">
                            <span class="input-group-text">to</span>
                        </div>
                        <select name="to_time" id="" class="form-control" required>
                            <option value="">To</option>
                            <option>07:00</option>
                            <option>07:30</option>
                            <option>08:00</option>
                            <option>08:30</option>
                            <option>09:00</option>
                            <option>09:30</option>
                            <option>10:00</option>
                            <option>10:30</option>
                            <option>11:00</option>
                            <option>11:30</option>
                            <option>12:00</option>
                            <option>12:30</option>
                            <option>13:00</option>
                            <option>13:30</option>
                            <option>14:00</option>
                            <option>14:30</option>
                            <option>15:00</option>
                            <option>15:30</option>
                            <option>16:00</option>
                            <option>16:30</option>
                            <option>17:00</option>
                            <option>17:30</option>
                            <option>18:00</option>
                            <option>18:30</option>
                            <option>19:00</option>
                            <option>19:30</option>
                            <option>20:00</option>
                            <option>20:30</option>
                            <option>21:00</option>
                            <option>21:30</option>
                            <option>22:00</option>
                            <option>22:30</option>
                            <option>23:00</option>
                            <option>23:30</option>
                            <option>00:00</option>
                            <option>00:30</option>
                            <option>01:00</option>
                            <option>01:30</option>
                            <option>02:00</option>
                            <option>02:30</option>
                            <option>03:00</option>
                            <option>03:30</option>
                            <option>04:00</option>
                            <option>04:30</option>
                            <option>05:00</option>
                            <option>05:30</option>
                            <option>06:00</option>
                            <option>06:30</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3"></label>
                    <div class="col-sm-9">
                        <input type="hidden" name="mod" value="<?php echo explode('-',$mod)[0];?>">
                        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                        <button type="submit" id="btn-save" class="btn gd-primary text-white btn-rounded">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>