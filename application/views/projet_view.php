
        <div class="container">
                <h4>Mes projets</h4>
                <br />
                    <button class="btn btn-success" onclick="add_mes_projets()"><i class="glyphicon glyphicon-plus"></i> Add Projet</button>
                    <br />
                    <br />
                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Projet</th>
                          <th>Avancement (%)</th>
                          <th>Date Debut</th>
                          <th>date Fin</th>
                          <th style="width:190px;">Action</th>
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
                  <h3 class="modal-title">Projet Form</h3>
                </div>
                <div class="modal-body form">
                  <form action="" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <input type="hidden" value="<?php echo $infos_user['id'] ?>" name="id_user"/> 
                    <div class="form-body">
                      <div class="form-group">
                        <label class="control-label col-md-3">Nom Projet</label>
                        <div class="col-md-9">
                          <input name="nom_projet" placeholder="Nom Projet" class="form-control" type="text" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Date debut</label>
                        <div class="col-md-9">
                          <input name="date_debut" placeholder="Date debut" class="form-control" type="date" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Date fin</label>
                        <div class="col-md-9">
                          <input name="date_fin" placeholder="Date fin" class="form-control" type="date" required>
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
                goToModule = function(id_projet) {
                  var href = "<?php echo(URL.'mes_projets/modules/'); ?>"+id_projet;
                            $(location).attr('href',href);
                }


                table = $('#table').DataTable({ 
                  
                  "processing": true, //Feature control the processing indicator.
                  "serverSide": true, //Feature control DataTables' server-side processing mode.
                  
                  // Load data for the table's content from an Ajax source
                  "ajax": {
                      "url": "<?php echo(URL.'mes_projets/ajax_list_projet/'.$infos_user['id'])?>",
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

            function add_mes_projets()
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
                                        $('.modal-title').text('Add Projet'); // Set Title to Bootstrap modal title
                                }
                                else
                                {
                                        alert("Vous devez être super manager pour pouvoir effectuer cette opération!"); 
                                }   
                            }
               );
                
            }

            function edit_mes_projets(id)
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
                                              url : "<?php echo(URL.'mes_projets/ajax_edit_projet/')?>" +id,
                                              type: "GET",
                                              dataType: "JSON",
                                              success: function(data)
                                              {
                                                  $('[name="id"]').val(data.id);
                                                  $('[name="nom_projet"]').val(data.nom);
                                                  $('[name="date_debut"]').val(data.date_debut);
                                                  $('[name="date_fin"]').val(data.date_fin);
                                                  
                                                  $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                                                  $('.modal-title').text('Edit Projet'); // Set title to Bootstrap modal title
                                                  
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

            function delete_mes_projets(id)
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
                                                  url : "<?php echo(URL.'mes_projets/ajax_delete_projet')?>/"+id,
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
                    url = "<?php echo(URL.'mes_projets/ajax_add_projet')?>";
                }
                else
                {
                  url = "<?php echo(URL.'mes_projets/ajax_update_projet')?>";
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
