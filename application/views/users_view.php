
        <div class="container">
                <h4>All users</h4>
                <br />
                    <button class="btn btn-success" onclick="add_user()"><i class="glyphicon glyphicon-plus"></i> Add user</button>
                    <br />
                    <br />
                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Nom</th>
                          <th>Prenom</th>
                          <th>Statut</th>
                          <th>Login</th>
                          <th style="width:120px;">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>

                      <tfoot>
                        <tr>
                        </tr>
                      </tfoot>
                    </table>
        </div>

          <!-- Bootstrap modal -->
            <div class="modal fade" id="modal_form" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title">User Form</h3>
                </div>
                <div class="modal-body form">
                  <form action="" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                      <div class="form-group">
                        <label class="control-label col-md-3">Nom user</label>
                        <div class="col-md-9">
                          <input name="nom" placeholder="Nom" class="form-control" type="text" required>
                        </div>
                      </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Prenom user</label>
                            <div class="col-md-9">
                                <input name="prenom" placeholder="Prenom" class="form-control" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Fonction</label>
                            <div class="col-md-9">
                                <input name="fonction" placeholder="Fonction" class="form-control" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3">Statut</label>
                          <div class="col-md-9">
                          <input type="hidden" value="" name="id_user_initial"/> 
                            <select name="statut" class="form-control" required>
                                  <option value="1">Administrateur</option>
                                  <option value="2">Utilisateur</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Login</label>
                            <div class="col-md-9">
                                <input name="login" placeholder="Login" class="form-control" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Password</label>
                            <div class="col-md-9">
                                <input name="password" placeholder="Password" class="form-control" type="password" required>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" id="btnSave" class="btn btn-primary">Save</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>

                  </form>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->
            <!-- End Bootstrap modal -->

            <script type="text/javascript">

            var save_method; //for save method string
            var table;
            $(document).ready(function () {
                table = $('#table').DataTable({ 
                  
                  "processing": true, //Feature control the processing indicator.
                  "serverSide": true, //Feature control DataTables' server-side processing mode.
                  
                  // Load data for the table's content from an Ajax source
                  "ajax": {
                      "url": "<?php echo(URL.'users/ajax_list_users')?>",
                      "type": "POST"
                  },

                  //Set column definition initialisation properties.
                  "columnDefs": [
                  { 
                    "targets": [ -1 ], //last column
                    "orderable": false //set not orderable
                  },
                  ]

                });

                
            });

            function add_user()
            {
              var id_user = "<?php echo $infos_user['id']?>";
              $.post("<?php echo(URL.'isSuperManager') ?>", 
                            {
                                id_user : id_user
                            }, 
                            function(result){
                                if(result == 1)
                                {
                                       save_method = 'add';
                                        $('#form')[0].reset(); // reset form on modals
                                        $('#modal_form').modal('show'); // show bootstrap modal
                                        $('.modal-title').text('Add User'); // Set Title to Bootstrap modal title
                                }
                                else
                                {
                                        alert("Vous devez être super manager pour pouvoir effectuer cette opération!"); 
                                }
                            }
               );
                
            }

            function edit_user(id)
            {
                var id_user = "<?php echo $infos_user['id']?>";
                $.post("<?php echo(URL.'isSuperManager') ?>", 
                              {
                                  id_user : id_user
                              }, 
                              function(result){
                                  if(result == 1)
                                  {
                                         save_method = 'update';
                                          $('#form')[0].reset(); // reset form on modals

                                          //Ajax Load data from ajax
                                          $.ajax({
                                              url : "<?php echo(URL.'users/ajax_edit_user/')?>" +id,
                                              type: "GET",
                                              dataType: "JSON",
                                              success: function(data)
                                              {
                                                  $('[name="id"]').val(data.id);
                                                  $('[name="nom"]').val(data.nom);
                                                  $('[name="prenom"]').val(data.prenom);
                                                  $('[name="fonction"]').val(data.fonction);
                                                  $('[name="statut"]').val(data.statut);
                                                  $('[name="login"]').val(data.login);
                                                  $('[name="password"]').val(data.password);
                                                  $('[name="login"]').val(data.login);
                                                  
                                                  $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                                                  $('.modal-title').text('Edit User'); // Set title to Bootstrap modal title
                                                  
                                              },
                                              error: function (jqXHR, textStatus, errorThrown)
                                              {
                                                  alert('Error get data from ajax');
                                              }
                                          });
                                  }
                                  else
                                  {
                                          alert("Vous devez être super manager pour pouvoir effectuer cette opération!"); 
                                  }   
                              }
                 );
                
            }

            function reload_table()
            {
                table.ajax.reload(null,false); //reload datatable ajax 
            }

            function delete_user(id)
            {
                  var id_user = "<?php echo $infos_user['id']?>";
                  $.post("<?php echo(URL.'isSuperManager') ?>", 
                                {
                                    id_user : id_user
                                }, 
                                function(result){
                                    if(result == 1)
                                    {
                                           if(confirm('Are you sure delete this data?'))
                                            {
                                              // ajax delete data to database
                                                $.ajax({
                                                  url : "<?php echo(URL.'users/ajax_delete_user')?>/"+id,
                                                  type: "POST",
                                                  dataType: "JSON",
                                                  success: function(data)
                                                  {
                                                     //if success reload ajax table
                                                     $('#modal_form').modal('hide');
                                                     reload_table();
                                                  },
                                                  error: function (jqXHR, textStatus, errorThrown)
                                                  {
                                                      alert('Error adding / update data');
                                                  }
                                              });
                                               
                                            }
                                    }
                                    else
                                    {
                                            alert("Vous devez être super manager pour pouvoir effectuer cette opération!"); 
                                    }   
                                }
                   );
                
            }
            $( "#form" ).submit(function(e) {
              e.preventDefault();
                var url;
                if(save_method == 'add') 
                {
                    url = "<?php echo(URL.'users/ajax_add_user')?>";
                }
                else
                {
                  url = "<?php echo(URL.'users/ajax_update_user')?>";
                }

                 // ajax adding data to database
                    $.ajax({
                      url : url,
                      type: "POST",
                      data: $('#form').serialize(),
                      dataType: "JSON",
                      success: function(data)
                      {
                         //if success close modal and reload ajax table
                         $('#modal_form').modal('hide');
                         reload_table();
                      },
                      error: function (jqXHR, textStatus, errorThrown)
                      {
                          alert('Error adding / update data');
                      }
                  });
            });
          </script>
