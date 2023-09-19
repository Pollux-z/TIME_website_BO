<?php
    if($_GET['alert']=='success'){
        echo '
        <div class="alert alert-info" role="alert">
            <i data-feather="info"></i>
            <span class="mx-2">Success!</span>
        </div>';
    }
?>
<?php
    echo '<form data-plugin="parsley" data-option="{}" action="action.php" method="POST" enctype="multipart/form-data">';
    
    ?>

                                                
                                                
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Paste from Excel</label>
                                                    <div class="col-sm-9">
                                                    <textarea name="excel" class="form-control" rows="7" placeholder="Cat	NO	Title	Detail
Cat	NO	Title	Detail
.." required>
</textarea>

<small class="form-text text-muted"></small>
                                                    </div>
                                                </div>
                                                <div class="text-right pt-2">
                                                    <input type="hidden" name="mod" value="culture">
                                                    <!-- <input type="hidden" name="id" value="<?php echo $id;?>"> -->
                                                    <button type="submit" class="btn btn-primary">Import</button>

                                                </div>

                                            </form>
                                            </div>
                                        </div>
                                </div>
                            </div>