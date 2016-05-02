
   <div class="container">
      <h4>Mes modules</h4>
      <br />
      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
         <thead>
            <tr>
               <th>Id</th>
               <th>Nom projet</th>
               <th>Module</th>
               <th>Avancement</th>
               <th>Date fin</th>
               <th>Responsable</th>
               <th style="width:50px;">Action</th>
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
      $(document).ready(function () {
        goToTache = function(id_module) {
          var href = "<?php echo(URL.'mes_modules/taches/'); ?>"+id_module;
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
               "url": "<?php echo(URL.'mes_modules/ajax_list_modules/'.$infos_user['id'])?>",
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
      
       function reload_table()
       {
         table.ajax.reload(null,false); //reload datatable ajax 
       }
      
   </script>
