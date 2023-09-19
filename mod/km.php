
                        <div class="padding" data-plugin="search" id="search-list">
                            <form action="#" class="mb-3">
                                <div class="input-group">
                                    <input type="text" name="q" class="form-control form-control-theme search" placeholder="Type keyword" value="<?php
                                    
                                    if(isset($_GET['q'])){
                                        $q = $_GET['q'];
                                        $sq = " and `hashtags` LIKE '%\"$q\"%' or `description` LIKE '%$q%'";
                                    }
                                    
                                    $rs = mysqli_query($conn,"SELECT * FROM `db_km` WHERE `status` = 2$sq");
                                    
                                    echo $q;?>">
                                    <span class="input-group-append">
        <button class="btn btn-white no-border" type="button">Search</button>
      </span>
                                </div>
                                <input type="hidden" name="mod" value="km">
                            </form>
                            <p class="mb-3">
                                <strong><?php echo mysqli_num_rows($rs);?></strong> Results found for:
                                <strong><?php echo $q;?></strong>
                            </p>
                            <div class="row">
                                <?php while($row = mysqli_fetch_assoc($rs)){?>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="media media-2x1 gd-primary">
                                            <a class="media-content" href="?mod=km-edit&id=<?php echo $row['id'];?>" style="background-image:url(uploads/km/<?php echo $row['id'];?>.png)">
                                                <strong class="text-fade"></strong>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $row['title'];?></h5>
                                            <p class="card-text"><?php echo substr($row['description'],0,290);?>..</p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><?php 
                                            
                                            foreach(json_decode($row['hashtags']) as $v){
                                                $hashtags[] = '<a href="?mod=km&q='.$v.'">'.$v.'</a>';
                                            }
                                            
                                            echo implode(', ',$hashtags);
                                            
                                            unset($hashtags);

                                            ?></li>
                                            <!-- <li class="list-group-item"><?php echo json_decode($row['comments'])[0][0];?></li> -->
                                        </ul>
                                        <div class="card-body">
                                            <a href="?mod=km-edit&id=<?php echo $row['id'];?>" class="card-link">View Info</a>
                                            <a href="<?php echo $row['location'];?>" class="card-link" target="_blank">Download</a>
                                        </div>
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                        </div>