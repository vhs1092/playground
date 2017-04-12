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
        <script type='text/javascript' src="<?php echo base_url();?>js/usuario/listar.js"></script>
    </head>
    <body>
        <div class="container">
            <a href="<?php echo site_url('Ctr_usuario/UsuarioCrear' ) ?> " title="New User"><span class="btn btn-info btn-lg" aria-hidden="true"><span class="glyphicon glyphicon-edit"></span> New user</span></a>
            <a href="../user_authentication/user_login_process" title="New user"><span class="btn btn-danger btn-lg" aria-hidden="true"><span class="glyphicon glyphicon-minus"></span> Back</span></a>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <table class="table table-hover">
                        <thead>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>
                                <center>Actions</center>
                            </th>
                        </thead>
                        <tbody>
                            <?php foreach ($arreglo_usuarios as $value) { ?>
                            <tr>
                                <td>
                                    <?php echo $value["name"]; ?>
                                </td>
                                <td>
                                    <?php echo $value["email"]; ?>
                                </td>
                                <td>
                                    <?php 
                                        if($value["roll_id"] == 1){
                                            $rol = "Super admin";
                                        }else{
                                            $rol = "admin";
                                        
                                        }
                                        
                                        echo $rol; ?>
                                </td>
                                <td>
                                    <center>
                                        <a href="<?php echo site_url('Ctr_usuario/UsuarioEditar/'.$value["admin_user_id"] ) ?>" title="Editar"><span class="btn btn-info btn-md" aria-hidden="true"><span class="glyphicon glyphicon-edit"></span> Edit</span></a>
                                    </center>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="myModal<?php echo $value["admin_user_id"] ?>" role="dialog">
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
                                            <a  href="UsuarioEliminar/<?php echo $value["admin_user_id"]; ?>" class="btn btn-default"  >Yes</a>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>