
   <div class="container">
   <h3>Listes Modules</h3>
   <div id="filtre" style="box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.2);border: 1px solid rgba(0, 0, 0, 0.2);height:auto; min-height:30px;overflow:hidden;">
      <h4 id="filtre-control" style="background-color: #f1f1f1;margin: 5px 5px;padding:5px;">
         <center>Filtre<span style="float: right;">x &nbsp;</span></center>
      </h4>
      <table cellpadding="3" cellspacing="0" border="0" style="width: 70%; margin: 0 auto 2em auto; padding : 10px 10px;">
         <thead>
            <tr>
               <th>Target</th>
               <th>Search text</th>
               <th>Treat as regex</th>
               <th>Use smart search</th>
            </tr>
         </thead>
         <tbody>
            <tr id="filter_global">
               <td>Global search</td>
               <td align="center"><input type="text" class="global_filter" id="global_filter"></td>
               <td align="center"><input type="checkbox" class="global_filter" id="global_regex"></td>
               <td align="center"><input type="checkbox" class="global_filter" id="global_smart" checked="checked"></td>
            </tr>
            <tr id="filter_col3" data-column="2">
               <td>Column - Nom Projet</td>
               <td align="center"><input type="text" class="column_filter" id="col2_filter"></td>
               <td align="center"><input type="checkbox" class="column_filter" id="col2_regex"></td>
               <td align="center"><input type="checkbox" class="column_filter" id="col2_smart" checked="checked"></td>
            </tr>
            <tr id="filter_col4" data-column="3">
               <td>Column - Nom Module</td>
               <td align="center"><input type="text" class="column_filter" id="col3_filter"></td>
               <td align="center"><input type="checkbox" class="column_filter" id="col3_regex"></td>
               <td align="center"><input type="checkbox" class="column_filter" id="col3_smart" checked="checked"></td>
            </tr>
            <tr id="filter_col5" data-column="4">
               <td>Column - Avancement</td>
               <td align="center"><input type="text" class="column_filter" id="col4_filter"></td>
               <td align="center"><input type="checkbox" class="column_filter" id="col4_regex"></td>
               <td align="center"><input type="checkbox" class="column_filter" id="col4_smart" checked="checked"></td>
            </tr>
            <tr id="filter_col6" data-column="5">
               <td>Column - Date fin</td>
               <td align="center"><input type="text" class="column_filter" id="col5_filter"></td>
               <td align="center"><input type="checkbox" class="column_filter" id="col5_regex"></td>
               <td align="center"><input type="checkbox" class="column_filter" id="col5_smart" checked="checked"></td>
            </tr>
            <tr id="filter_col7" data-column="6">
               <td>Column - Nom responsable</td>
               <td align="center"><input type="text" class="column_filter" id="col6_filter"></td>
               <td align="center"><input type="checkbox" class="column_filter" id="col6_regex"></td>
               <td align="center"><input type="checkbox" class="column_filter" id="col6_smart" checked="checked"></td>
            </tr>
         </tbody>
      </table>
   </div>
   <br>
   <form id="theForm">
      <button type="button" class="btn btn-primary" onclick="my_filter()"><i class="glyphicon glyphicon-check"></i> My Filter</button>
      <button type="button" class="btn btn-primary" onclick="reloadModule()"><i class="glyphicon glyphicon-list"></i> All Module</button>
      <button type="submit" class="btn btn-success" onclick=""><i class="glyphicon glyphicon-save"></i> Save Filter</button>
      <br>
      <br>
      </table>
      <table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
         <thead>
            <tr>
               <th><input type="checkbox" id="select-all"/></th>
               <th>Id</th>
               <th>Projet</th>
               <th>Module</th>
               <th>Avancement</th>
               <th>Date fin</th>
               <th>Responsable</th>
               <th style="width:250px;">Action</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
   </form>
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
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
   <!-- /.modal -->
   <!-- End Bootstrap modal -->

   <!-- Bootstrap modal -->
   <div class="modal fade" id="modal_form1" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title1">Projet Form</h3>
         </div>
         <div class="modal-body form">
            <form action="#" id="form1" class="form-horizontal">
              <input type="hidden" value="" name="id_module"/> 
               <input type="hidden" value="" name="id_tache"/> 
               <div class="form-body">
                  <div class="form-group">
                     <label class="control-label col-md-3">Nom Projet</label>
                     <div class="col-md-9">
                        <input name="nom_projet" placeholder="Nom Projet" class="form-control" type="text" disabled  required>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="control-label col-md-3">Nom Module</label>
                     <div class="col-md-9">
                        <input name="nom_module" placeholder="Nom Module" class="form-control" type="text" disabled required>
                     </div>
                  </div>
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
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
   <!-- /.modal -->
   <!-- End Bootstrap modal -->

    <script type="text/javascript">
    var save_method; //for save method string
    var table;

    function filterGlobal() {
        $('#example').DataTable().search(
            $('#global_filter').val(),
            $('#global_regex').prop('checked'),
            $('#global_smart').prop('checked')
        ).draw();
    }

    function filterColumn(i) {
        $('#example').DataTable().search(
            $('#col' + i + '_filter').val(),
            $('#col' + i + '_regex').prop('checked'),
            $('#col' + i + '_smart').prop('checked')
        ).draw();
    }

    $('#select-all').click(function(e){
          var table= $(e.target).closest('table');
          $('td input:checkbox',table).prop('checked',this.checked);
      });
    $(document).ready(function() {
        allModule();
        $("#filtre-control").click(function() {
            if ($("#filtre").height() > 42) {
                $("#filtre").css({
                    'height': '42px'
                });
            } else {
                $("#filtre").css({
                    'height': 'auto'
                });
            }
        });
    });

    function allModule() {
        table = $('#example').DataTable({
            "pagingType": "full_numbers",
            "jQueryUI": true,

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo(URL.'gestion_modules/ajax_projet_list_module');?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [0, -1],
                "orderable": false
            }, {
                "targets": '_all',
                "searchable": true
            }, ],

        });

        $('input.global_filter').on('keyup click', function() {
            filterGlobal();
        });

        $('input.column_filter').on('keyup click', function() {
            filterColumn($(this).parents('tr').attr('data-column'));
        });
    }


    function add_tache(id) {
      $.post("<?php echo(URL.'testDroit') ?>", {
                    id_user: "<?php echo $infos_user['id']; ?>",
                    table: 'module',
                    id: id
                },
                function(result) {
                    if (result == 1) {
                          save_method = 'add';
                          $('#form1')[0].reset(); // reset form on modals
                          //Ajax Load data from ajax
                          $.ajax({
                              url: "<?php echo(URL.'gestion_modules/ajax_edit_tache/')?>" + id,
                              type: "GET",
                              dataType: "JSON",
                              success: function(data) {
                                  $('[name="id_module"]').val(data.id);
                                  $('[name="nom_projet"]').val(data.nom_projet);
                                  $('[name="nom_tache"]').val(data.nom_tache);
                                  $('[name="nom_module"]').val(data.nom_module);

                                  $('#modal_form1').modal('show'); // show bootstrap modal
                                  $('.modal-title1').text('Add Tache'); // Set Title to Bootstrap modal title
                              },
                              error: function(jqXHR, textStatus, errorThrown) {
                                  alert('Error get data from ajax');
                              }
                          });
                     } else {
                        alert("Vous devez être responsable de projet pour pouvoir effectuer cette opération!");
                    }
                }
            );
    }

    function edit_mes_projets_module(id) {
          $.post("<?php echo(URL.'testDroitModule') ?>", {
                    id_user: "<?php echo $infos_user['id']; ?>",
                    table: 'module',
                    id: id
                },
                function(result) {
                    if (result == 1) {
                          save_method = 'update';
                          $('#form')[0].reset(); // reset form on modals

                          //Ajax Load data from ajax
                          $.ajax({
                              url: "<?php echo(URL.'gestion_modules/ajax_edit_module/')?>" + id,
                              type: "GET",
                              dataType: "JSON",
                              success: function(data) {
                                  $('[name="id_module"]').val(data.id);
                                  $('[name="id_projet"]').val(data.id_projet);
                                  $('[name="nom_module"]').val(data.nom_module);
                                  $('[name="id_user"]').val(data.id_responsable_module);
                                  $('[name="id_user_initial"]').val(data.id_responsable_module);

                                  $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                                  $('.modal-title').text('Edit Module'); // Set title to Bootstrap modal title

                              },
                              error: function(jqXHR, textStatus, errorThrown) {
                                  alert('Error get data from ajax');
                              }
                          });
                     } else {
                        alert("Vous devez être responsable de projet pour pouvoir effectuer cette opération!");
                    }
                }
            );
    }

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    function delete_mes_projets_module(id) {
          $.post("<?php echo(URL.'testDroitModule') ?>", {
                    id_user: "<?php echo $infos_user['id']; ?>",
                    table: 'module',
                    id: id
                },
                function(result) {
                    if (result == 1) {
                          if (confirm('Are you sure delete this data?')) {
                              // ajax delete data to database
                              $.ajax({
                                  url: "<?php echo(URL.'gestion_modules/ajax_delete_module')?>/" + id,
                                  type: "POST",
                                  dataType: "JSON",
                                  success: function(data) {
                                      //if success reload ajax table
                                      $('#modal_form').modal('hide');
                                      reload_table();
                                  },
                                  error: function(jqXHR, textStatus, errorThrown) {
                                      alert('Error adding / update data');
                                  }
                              });

                          }
                    } else {
                        alert("Vous devez être responsable de projet pour pouvoir effectuer cette opération!");
                    }
                }
            );
    }

    $("#form").submit(function(e) {
        e.preventDefault();
        var url;
        if (save_method == 'update') {
            url = "<?php echo(URL.'gestion_modules/ajax_update_module')?>";
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data) {
                //if success close modal and reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
            }
        });
    });

    function reloadModule() {
        table = $('#example').DataTable().ajax.url("<?php echo(URL.'gestion_modules/ajax_projet_list_module')?>").load();
    }

    $("#theForm").submit(function(e) {
        e.preventDefault();
        var url = "<?php echo(URL.'filtre/save_filter_module')?>";
        var data = $("#theForm").serialize();
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            dataType: "JSON",
            success: function(data) {}
        });

    });

    $("#form1").submit(function(e) {
        e.preventDefault();
        var url;
        if (save_method == 'add') {
            url = "<?php echo(URL.'gestion_modules/ajax_add_tache')?>";
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form1').serialize(),
            dataType: "JSON",
            success: function(data) {
                //if success close modal and reload ajax table
                $('#modal_form1').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
            }
        });
    });

    function my_filter() {
        var url = "<?php echo(URL.'filtre/read_filter_module')?>";
        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                if (data == 0) {
                    alert('filtre vide!');
                } else {
                    table = $('#example').DataTable().ajax.url("<?php echo(URL.'gestion_modules/ajax_list_module_my_filter')?>").load();
                }
            }
        });
    }
</script>
