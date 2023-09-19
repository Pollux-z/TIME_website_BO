<div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
                                    <thead>
                                        <tr>
                                            <th><span class="text-muted">ID</span></th>
                                            <th><span class="text-muted">Name</span></th>
                                            <th><span class="text-muted">Organization</span></th>
                                            <th><span class="text-muted d-none d-sm-block">Tel</span></th>
                                            <th><span class="text-muted d-none d-sm-block">E-mail</span></th>
                                            <th><span class="text-muted">Position</span></th>
                                            <th><span class="text-muted">Event</span></th>
                                            <!-- <th></th> -->
                                        </tr>
                                    </thead>
                                    <tbody><?php
    while($row=mysqli_fetch_assoc($rs)){
                                                echo '<tr class=" " data-id="'.$row['id'].'">
                                                        <td style="text-align:center">
                                                            <small class="text-muted">'.$row['id'].'</small>
                                                        </td>
                                                        <td class="flex">
                                                            '.$row['name'].'
                                                        </td>
                                                        <td>
                                                        '.$row['org'].'</td>
                                                        <td>
                                                            <span class="item-amount d-none d-sm-block text-sm [object Object]">
                                                            '.$row['tel'].'
                                </span>
                                                        </td>
                                                        <td>
                                                        '.$row['email'].'
                                                        </td>
                                                        <td>
                                                        '.$row['position'].'
                                                        </td>
                                                        <td>
                                                        '.$row['event'].'
                                                        </td>';
                                                    echo '</tr>';
                                            }
                                        ?>                                        
                                        


                                        
                                    </tbody>
                                </table>
                            </div>