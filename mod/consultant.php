                            <div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
                                    <thead>
                                        <tr>
                                            <th><span class="text-muted">ID</span></th>
                                            <th><span class="text-muted">Name</span></th>
                                            <th><span class="text-muted">Position</span></th>
                                            <th><span class="text-muted">Organization</span></th>
                                            <th><span class="text-muted d-none d-sm-block">Tel</span></th>
                                            <!-- <th></th> -->
                                        </tr>
                                    </thead>
                                    <tbody><?php
    // $rs = mysqli_query($conn,"SELECT * FROM `db_projects` WHERE status =2");
    // $cnt = mysqli_num_rows($rs);

    // echo 'โครงการที่มีตอนนี้ทั้งหมด '.$cnt;  
    while($row=mysqli_fetch_assoc($rs)){
        // $owner = $row['owner'];
        // if($owner==''){
        //     $owner = 'TIME';
        // }

        // <a href="?mod='.$md.'-edit&id='.$row['id'].'" class="item-title text-color ">
                                                echo '<tr class=" " data-id="'.$row['id'].'">
                                                        <td style="text-align:center">
                                                            <small class="text-muted">'.$row['id'].'</small>
                                                        </td>
                                                        <td class="flex">
                                                            '.$row['name'].'
                                                        </td>
                                                        <td>
                                                        '.$row['position'].'</td>
                                                        <td>
                                                        '.$row['org'].'
                                                        </td>
                                                        <td>
                                                            <span class="item-amount d-none d-sm-block text-sm [object Object]">
                                                            '.$row['tel'].'
                                </span>
                                                        </td>';
                                                        // <td>
                                                        //     <div class="item-action dropdown">
                                                        //         <a href="#" data-toggle="dropdown" class="text-muted">
                                                        //             <i data-feather="more-vertical"></i>
                                                        //         </a>
                                                        //         <div class="dropdown-menu dropdown-menu-right bg-black" role="menu">
                                                        //             <a class="dropdown-item" href="#">
                                                        //                 See detail
                                                        //             </a>';

                                                                    


                                                        //             echo '<a class="dropdown-item edit" href="?mod='.$md.'-edit&id='.$row['id'].'">
                                                        //                 Edit
                                                        //             </a>
                                                        //             <div class="dropdown-divider"></div>
                                                        //             <a class="dropdown-item trash">
                                                        //                 Delete item
                                                        //             </a>
                                                        //         </div>
                                                        //     </div>
                                                        // </td>

                                                    echo '</tr>';
                                            }
                                        ?>                                        
                                        


                                        
                                    </tbody>
                                </table>
                            </div>