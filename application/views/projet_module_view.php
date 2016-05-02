
          <div class="container">
                  <h4><a href="<?php echo(URL.'mes_projets/'); ?>" > Mes Projets</a> > <?php echo $projet['nom'] ?></h4>
      			
                  <h3>Modules :</h3>
                      <br />
                      <button class="btn btn-success" onclick="add_mes_projets_module()"><i class="glyphicon glyphicon-plus"></i> Add Module</button>
                      <br />
                      <br />
                      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                             <th>Id</th>
                             <th>Module</th>
                             <th>Avancement</th>
                             <th>Date fin</th>
                             <th>Responsable</th>
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
                  <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id_module"/> 
                    <div class="form-body">
                      <div class="form-group">
                        <label class="control-label col-md-3">Nom Module</label>
                        <div class="col-md-9">
                          <input name="nom_module" placeholder="Nom Module" class="form-control" type="text" required>
                        </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3">Responsable Module</label>
                          <div class="col-md-9">
                          <input type="hidden" value="" name="id_user_initial"/> 
                            <select name="id_user" class="form-control" required>
                                <?php foreach ($list_user as $user_item): ?>
                                  <option value="<?php echo $user_item['id'] ?>"><?php echo $user_item['nom'].' '.$user_item['prenom'].' / '.$user_item['fonction'] ?></option>
                                <?php endforeach ?>
                            </select>
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
        			$(document).ready(function () {
        				goToTache = function(id_module) {
        					var href = "<?php echo(URL.'mes_projets/modules/taches/'); ?>"+id_module;
                            $(location).attr('href',href);
        				}
        			});

            var save_method; //for save method string
            var table;
            $(document).ready(function() {
              table = $('#table').DataTable({ 
                
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo(URL.'mes_projets/ajax_list_module/'.$projet['id'])?>",
                    "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                { 
                  "targets": [ -1 ], //last column
                  "orderable": false, //set not orderable
                },
                ],

              });
            });

            function add_mes_projets_module()
            {
              save_method = 'add';
              $('#form')[0].reset(); // reset form on modals
              $('#modal_form').modal('show'); // show bootstrap modal
              $('.modal-title').text('Add Module'); // Set Title to Bootstrap modal title
            }

            function edit_mes_projets_module(id)
            {
              save_method = 'update';
              $('#form')[0].reset(); // reset form on modals

              //Ajax Load data from ajax
              $.ajax({
                url : "<?php echo(URL.'mes_projets/ajax_edit_module/')?>" +id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('[name="id_module"]').val(data.id);
                    $('[name="id_projet"]').val(data.id_projet);
                    $('[name="nom_module"]').val(data.nom_projet);
                    $('[name="id_user"]').val(data.id_responsable_module);
                    $('[name="id_user_initial"]').val(data.id_responsable_module);
                    
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Module'); // Set title to Bootstrap modal title
                    
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
            }

            function reload_table()
            {
              table.ajax.reload(null,false); //reload datatable ajax 
            }

            function delete_mes_projets_module(id)
            {
              if(confirm('Are you sure delete this data?'))
              {
                // ajax delete data to database
                  $.ajax({
                    url : "<?php echo(URL.'mes_projets/ajax_delete_module')?>/"+id,
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

            $( "#form" ).submit(function(e) {
              e.preventDefault();
              var url;
              if(save_method == 'add') 
              {
                  url = "<?php echo(URL.'mes_projets/ajax_add_module/'.$projet_id)?>";
              }
              else
              {
                url = "<?php echo(URL.'mes_projets/ajax_update_module')?>";
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



