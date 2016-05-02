
    <div id="intro">
         <h2>Welcome <?php echo $infos_user['nom'].' '.$infos_user['prenom']; ?></h2><br>
         
         <ul class="list li">
            <li class="list_count"></li>
               <li class="extra_wrapper">
                    <a href="<?php echo(URL.'notifications/'); ?>">Notification</a>
               </li>
         </ul>
         <ul class="list li">
            <li class="list_count"></li>
               <li class="extra_wrapper">
                    <a onclick="gestion_user()"> Gestion User</a>
               </li>
         </ul>
         <ul class="list li">
            <li class="list_count"></li>
               <li class="extra_wrapper">
                    <a href="<?php echo(URL.'gestion_projets'); ?>" > Liste Projet</a>
               </li>
         </ul>
         <ul class="list li">
            <li class="list_count"></li>
               <li class="extra_wrapper">
                    <a href="<?php echo(URL.'gestion_modules'); ?>" > Liste Module</a>
               </li>
         </ul>
         <ul class="list li">
            <li class="list_count"></li>
               <li class="extra_wrapper">
                    <a href="<?php echo(URL.'gestion_taches'); ?>" > Liste Tache</a>
               </li>
         </ul>
         <ul class="list li">
            <li class="list_count"></li>
               <li class="extra_wrapper">
                    <a href="<?php echo(URL.'mes_projets/'); ?>" > Mes Projets</a>
               </li>
         </ul>
         <ul class="list li">
            <li class="list_count"></li>
               <li class="extra_wrapper">
                    <a href="<?php echo(URL.'mes_modules/'); ?>" > Mes Modules</a>
               </li>
         </ul>
         <ul class="list li">
            <li class="list_count"></li>
               <li class="extra_wrapper">
                    <a href="<?php echo(URL.'mes_taches/'); ?>" > Mes Taches</a>
               </li>
         </ul>
    </div>
        <script src="<?php echo(JS.'jquery.min.js'); ?>"></script>
        <script>
                        function gestion_user() {
                          var id_user = "<?php echo $infos_user['id']?>";
                          $.post("<?php echo(URL.'isSuperManager') ?>", {
                                  id_user: id_user,
                              },
                              function(result) {
                                  if (result == 1) {
                                      window.location.href ="<?php echo(URL.'gestion_user'); ?>";
                                  } else {
                                      alert("Vous devez être super manager pour pouvoir effectuer cette opération!");
                                  }
                              }
                          );
                      
                      }
           
        </script>
 