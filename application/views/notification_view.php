
   <div class="container">
      <h4>Notification</h4>
      <br />
      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
         <thead>
            <tr>
               <th>Date</th>
               <th>Notification</th>
               <th></th>
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
                  "url": "<?php echo(URL.'notification/list/')?>",
                  "type": "POST"
              },
      
              //Set column definition initialisation properties.
              "columnDefs": [{
                      "targets": [-1], //last column
                      "orderable": false, //set not orderable
                  },
      
              ],
              "createdRow": function(row, data, index) {
                  if (data[2] == "Nouveau") {
                      $('td', row).eq(2).parent("tr").css({
                          "color": "rgb(255,100,100)"
                      });
                  } else {
                      $('td', row).eq(2).parent("tr").css({
                          "color": "#463F32"
                      });
                  }
              }
          });
      
          var id_user = "<?php echo $infos_user['id']?>";
          $.ajax({
              url: "<?php echo(URL.'notificationVu/'.$infos_user['id']); ?>",
              type: "POST",
              data: id_user,
              dataType: "JSON",
              success: function(data) {
      
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert('Error adding / update data');
              }
          });
      
      });
   </script>
