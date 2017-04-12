<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title> </title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/table.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.css">
        <script type='text/javascript' src="<?php echo base_url();?>js/jquery.min.js"></script>
        <script type='text/javascript' src="<?php echo base_url();?>js/bootstrap.js"></script>
        <script type='text/javascript' src="<?php echo base_url();?>js/evento/index.js"></script>

    </head>
    <body>
        <div class="container">
            <div class="col-lg-6">
                <a href="createEvent" title="New event type"><span class="btn btn-info btn-lg" aria-hidden="true"><span class="glyphicon glyphicon-edit"></span> New event</span></a>
                <a href="../welcome/index" title="New event type"><span class="btn btn-danger btn-lg" aria-hidden="true"><span class="glyphicon glyphicon-minus"></span> Back</span></a>
            </div>
            <div class="col-lg-6">
                Upload csv:  
                <form action="uploadCsv" method="post" enctype="multipart/form-data" name="form1" id="form1">
                    <div class="col-lg-6">
                        <input name="csv" type="file" id="csv" class="btn btn-info btn-sm"/> 
                    </div>
                    <input type="submit" name="Submit" value="Submit" class="btn btn-success btn-sm"/> 
                </form>
            </div>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <table class="table table-hover">
                        <thead>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>
                                <center>Actions</center>
                            </th>
                        </thead>
                        <tbody>
                            <?php foreach ($listEventos as $value) { 
                                if($value["status"] != 2){
                                    ?>
                            <tr>
                                <td>
                                    <?php echo $value['name']; ?>
                                </td>
                                <td>
                                    <?php echo $value['description']; ?>
                                </td>
                                <td>
                                    <?php 
                                        if($value['status'] == 3){ ?>
                                    <span class="btn btn-danger" aria-hidden="true">Incompleted</span>
                                    <?php }else{?>
                                    <span class="btn btn-success" aria-hidden="true">Completed</span>
                                    <?php }?>
                                </td>
                                <td>
                                    <center>
            
                                        <a href="editEvent/<?php echo $value['event_id']; ?>" title="Editar"><span class="btn btn-success" aria-hidden="true">Edit</span></a>
                                        <a href=""  class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo $value['event_id']; ?>">Delete</a>
                                    </center>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="myModal<?php echo $value['event_id']; ?>" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Delete</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure want to delete? </p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="deleteEvent/<?php echo $value['event_id']; ?>" class="btn btn-default"  >Yes</a>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } 
                                } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>