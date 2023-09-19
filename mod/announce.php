<!-- <div class="text-right mb-3"><a href="uploads/cover/TIME Cover Letter Design 2020 V2.docx" target="_blank"><i class="mx-2" data-feather="download"></i>Download Template</a></div> -->

<?php
    $rss = mysqli_query($conn,"SELECT `id`, `nick` FROM `db_employee`");
    while($roww=mysqli_fetch_assoc($rss)){
        $time1[$roww['id']] = $roww['nick'];
    }

    $rss = mysqli_query($conn,"SELECT id,code,name FROM `db_project`");
    while($roww=mysqli_fetch_assoc($rss)){
        $project[$roww['id']] = 'TIME-'.$roww['code'].' '.$roww['name'];
    }
?>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
                                    <thead>
                                        <tr>
                                            <th><span class="text-muted">ID</span></th>
                                            <th><span class="text-muted">Date</span></th>
                                            <th><span class="text-muted">Subject / Project</span></th>
                                            <th><span class="text-muted">PDF</span></th>
                                            <th><span class="text-muted">By</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                        
                                            // $rs = mysqli_query($conn,"SELECT * FROM `db_cover` ORDER BY code DESC");
                                            
                                            // '.explode('-',$row['date'])[2].'/'.explode('-',$row['date'])[1].'
                                            
                                            while($row=mysqli_fetch_assoc($rs)){
                                                echo '<tr class=" " data-id="'.$row['id'].'">
                                                        <td style="text-align:center">
                                                            <small class="text-muted">TIME'.substr($row['date'],0,4).'/BO/'.str_pad($row['code'], 4, 0, STR_PAD_LEFT).'</small>
                                                        </td>
                                                        <td>'.$row['date'].'
                                                        </td>
                                                        <td class="flex">
                                                            <a href="?mod='.$md.'-edit&id='.$row['id'].'" class="item-title text-color ">'.$row['title'].'</a>
                                                            <div class="item-except text-muted text-sm h-1x">
                                                            '.$project[$row['project_id']].'
                                                            </div>
                                                        </td>
                                                        <td>';

                                                        if($row['attach']!=''){
                                                            $attach = $row['attach'];
                                                            echo '<a href="/uploads/'.$md.'/'.$attach.'" class="btn btn-icon btn-rounded btn-white" title="PDF" target="_blank">
                                                            <i data-feather="file-text"></i>
                                                        </a>';
                                                        }
                                                        
                                                        echo '</td><td>'.$time1[$row['uid']].'</td>
                                                    </tr>';
                                            }
                                        ?>                                        
                                        


                                        
                                    </tbody>
                                </table>
                            </div>