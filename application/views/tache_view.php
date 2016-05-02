
    <div class="container">

        <h4>Mes Taches</h4>
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Projet</th>
                    <th>Module</th>
                    <th>Tache</th>
                    <th>Estimation</th>
                    <th>Temps passé</th>
                    <th>Reste a faire</th>
                    <th>Avancement</th>
                    <th>Depassement</th>
                    <th>Date Fin</th>
                    <th style="width:110px;">Action</th>
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
                        <input type="hidden" name="id_tache" />
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Nom Projet</label>
                                <div class="col-md-9">
                                    <input name="nom_projet" class="form-control" disabled type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Nom Module</label>
                                <div class="col-md-9">
                                    <input name="nom_module" class="form-control" disabled type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Nom Tache</label>
                                <div class="col-md-9">
                                    <input name="nom_tache" class="form-control" disabled type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Date</label>
                                <div class="col-md-9">
                                    <input name="date_modification" class="form-control" value="<?php echo date('Y-m-d'); ?>" disabled type="date">
                                </div>
                            </div>
                            <input name="temps_passe_initial" class="form-control" type="hidden">
                            <div class="form-group">
                                <label class="control-label col-md-3">Temps passé</label>
                                <div class="col-md-9">
                                    <input name="temps_passe" class="form-control" type="number" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Reste à faire</label>
                                <div class="col-md-9">
                                    <input name="reste_a_faire" class="form-control" type="number" required>
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

        <script type="text/javascript">
            var save_method; //for save method string
            var table;
            $(document).ready(function() {
                table = $('#table').DataTable({

                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php echo(URL.'mes_taches/ajax_list_tache/'.$infos_user['id'])?>",
                        "type": "POST"
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [{
                        "targets": [-1], //last column
                        "orderable": false, //set not orderable
                    }, ],

                });
            });

            function edit_tache(id) {
                save_method = 'update';
                $('#form')[0].reset(); // reset form on modals

                //Ajax Load data from ajax
                $.ajax({
                    url: "<?php echo(URL.'mes_taches/ajax_edit_tache/')?>" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        $('[name="id_tache"]').val(data.id);
                        $('[name="nom_projet"]').val(data.nom_projet);
                        $('[name="nom_module"]').val(data.nom_module);
                        $('[name="nom_tache"]').val(data.nom_tache);
                        $('[name="temps_passe_initial"]').val(data.temps_passe);

                        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('Edit Tache'); // Set title to Bootstrap modal title

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error get data from ajax');
                    }
                });
            }

            function reload_table() {
                table.ajax.reload(null, false); //reload datatable ajax 
            }

            $("#form").submit(function(e) {
                e.preventDefault();
                var url;
                if (save_method == 'update') {
                    url = "<?php echo(URL.'mes_taches/ajax_update_avancement_tache')?>";
                }

                // ajax adding data to database

                $.ajax({
                    url: url,
                    type: "POST",
                    data: $('#form').serialize(),
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status == 1) {
                            //if success close modal and reload ajax table
                            $('#modal_form').modal('hide');
                            reload_table();
                        } else {
                            alert(data.error);
                        }

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error update data');
                    }
                });
            });
        </script>
