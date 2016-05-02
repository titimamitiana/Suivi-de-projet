
         <form id="login-form" method="post" action="<?php echo(URL.'tache/add_tache'); ?>">

             <label>Tache:</label><br>
             <input type="text" disabled name="nom_tache" id="nom_tache" value="<?php echo($data_tache['nom_tache']); ?>"/>  <br><br>

             <label>Module:</label><br>
             <input type="text" disabled name="nom_tache" id="nom_tache" value="<?php echo($data_tache['nom_module']); ?>"/>  <br><br>
             <input type="hidden" name="id_tache" id="id_tache" value="<?php echo($data_tache['id']); ?>" />

             <label>Date:</label><br>
             <input type="date" name="date" id="date" min="0" placeholder="0" required/>  <br><br>

             <label>Temps pass&eacute;:</label><br>
             <input type="text" name="tp_initial" id="tp_initial"  value="<?php echo($data_tache['temps_passe']); ?>"/>
             <input type="number" name="tp" id="tp" min="0" max="12" placeholder="0" required/><br><br>

             <label>Reste &agrave; faire:</label><br>
             <input type="number" name="raf" id="raf" min="0" placeholder="0" required/>  <br><br>

             

             <button type="submit">Enregistrer</button>
         </form>
