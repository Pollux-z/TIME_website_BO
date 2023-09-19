
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>
                                        <strong>Frequently asked</strong>
                                    </p>
                                    <div class="mb-4">
<?php 
$i = 0;
while($row=mysqli_fetch_assoc($rs)){
    $i++;?>                                        
                                        <div class="card mb-2">
                                            <div class="card-header no-border">
                                                <a data-toggle="collapse" data-target="#c_<?php echo $i;?>">
                                                    <strong>Q:</strong> <?php echo $row['q'];?>
                                                </a>
                                            </div>
                                            <div id="c_<?php echo $i;?>" class="collapse in b-t">
                                                <div class="card-body">
                                                    <div class="float-left mr-2"><span class="text-md w-32 avatar circle bg-success">A</span></div>
                                                    <p class="text-muted"><?php echo nl2br($row['a']);?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
<?php }?>
                                    </div>
                                </div>
                            </div>