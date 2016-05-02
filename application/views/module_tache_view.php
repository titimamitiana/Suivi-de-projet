
     <div class="container">
            <h4><a href="<?php echo(URL.'mes_modules'); ?>">Mes Modules </a> > <?php echo $module['nom_module'] ?>  </h4>
      
            <h3>Taches :</h3>
            
            <br />
                <button class="btn btn-success" onclick="add_mes_projets_tache()"><i class="glyphicon glyphicon-plus"></i> Add Tache</button>
                <br />
                <br />
                <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                            <tr>
                                    <th>id</th>
                                    <th>Tache</th>
                                    <th>Estimation</th>
                                    <th>Temps passé</th>
                                    <th>Reste a faire</th>
                                    <th>Avancement</th>
                                    <th>Depassement</th>
                                    <th>Date Fin</th>
                                    <th>Responsable</th>
                                     <th style="width:130px;">Action</th>
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
                    <input type="hidden" value="" name="id_tache"/> 
                    <div class="form-body">
                      <div class="form-group">
                        <label class="control-label col-md-3">Nom Tache</label>
                        <div class="col-md-9">
                          <input name="nom_tache" placeholder="Nom Tache" class="form-control" type="text" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Estimation</label>
                        <div class="col-md-9">
                          <input name="estimation" placeholder="Estimation" class="form-control" type="number" required>
                        </div>
                      </div>
                      <div class="form-body">
                      <div class="form-group">
                        <label class="control-label col-md-3">Date Fin</label>
                        <div class="col-md-9">
                          <input name="date_fin_tache" placeholder="Date Fin" class="form-control" type="date" required>
                        </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3">Responsable Tache</label>
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
                      <button type="submit" id="btnSave"  class="btn btn-primary">Save</button>
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
                $(document).ready(function() {
                  table = $('#table').DataTable({ 
                    
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    
                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php echo(URL.'mes_modules/ajax_list_tache/'.$module['id'])?>",
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

                function add_mes_projets_tache()
                {
                  save_method = 'add';
                  $('#form')[0].reset(); // reset form on modals
                  $('#modal_form').modal('show'); // show bootstrap modal
                  $('.modal-title').text('Add Tache'); // Set Title to Bootstrap modal title
                }

                function edit_mes_projets_tache(id)
                {
                  save_method = 'update';
                  $('#form')[0].reset(); // reset form on modals

                  //Ajax Load data from ajax
                  $.ajax({
                    url : "<?php echo(URL.'mes_modules/ajax_edit_tache/')?>" +id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {
                        $('[name="id_tache"]').val(data.id);
                        $('[name="nom_tache"]').val(data.nom_tache);
                        $('[name="estimation"]').val(data.estimation);
                        $('[name="date_fin_tache"]').val(data.date_fin_tache);
                        $('[name="id_user"]').val(data.id_responsable_tache);
                        $('[name="id_user_initial"]').val(data.id_responsable_tache);
                        
                        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('Edit Tache'); // Set title to Bootstrap modal title
                        
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

                

                function delete_mes_projets_tache(id)
                {
                  if(confirm('Are you sure delete this data?'))
                  {
                    // ajax delete data to database
                      $.ajax({
                        url : "<?php echo(URL.'mes_modules/ajax_delete_tache/')?>/"+id,
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
                      url = "<?php echo(URL.'mes_modules/ajax_add_tache/'.$module_id)?>";
                  }
                  else
                  {
                    url = "<?php echo(URL.'mes_modules/ajax_update_tache')?>";
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
