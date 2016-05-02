
   <div class="container">
      <h4>Mes Taches Info</h4>
      <br>
      <h4>Projet : <?php echo $tache['nom_projet'].' <br> Module '.$tache['nom_module'].' <br> Tache : '.$tache['nom_tache']?></h4>
      <br>
      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="50%" style="margin:auto">
         <thead>
            <tr>
               <th>Date</th>
               <th>Duree</th>
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
   <script type="text/javascript">
      var save_method; //for save method string
      var table;
      $(document).ready(function() {
              table = $('#table').DataTable({ 
                
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo(URL.'mes_taches/ajax_list_tache_info/'.$tache['id'])?>",
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
   </script>
