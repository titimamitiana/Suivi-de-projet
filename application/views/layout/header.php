<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="<?php echo(URL_PATH.'bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo(URL_PATH.'bootstrap/css/bootstrap-theme.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo(URL_PATH.'datatables/css/dataTables.bootstrap.css'); ?>" rel="stylesheet">
        <script src="<?php echo(JS.'jquery.min.js'); ?>"></script>
        <script src="<?php echo(JS.'jquery-2.1.4.min.js'); ?>"></script>
        <script src="<?php echo(URL_PATH.'datatables/js/jquery.dataTables.min.js'); ?>"></script>
        <script src="<?php echo(URL_PATH.'bootstrap/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo(URL_PATH.'datatables/js/dataTables.bootstrap.js'); ?>"></script>

        <title> <?php echo $title ?></title>
    </head>
    <body>

    <style>

        /****Lists****/


        ul {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .list {
        }

        #accueil p{
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        }

        .list li {
            overflow: hidden;
        }

        .list_count {
            float: left;
            text-align: center;
            color: #fff;
            width: 12px;
            height: 12px;
            margin-top: 8px;
            margin-right: 13px;
            background-color: rgba(255,140,0,1);
            box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.6);
            font: 36px/44px  "Comic Sans MS", cursive;
        }

        .list li .text1 {
            margin-bottom: 3px;
        }

        .list li+li {
            margin-top: 19px;
        }

        .text1 {
            margin-bottom: 23px;
            font-size: 20px;
            line-height: 20px;
        }
        .color2 {
            color: #4a4a4a;
        }
        .extra_wrapper a{
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            font-size:19px;
            font-weight: bold;
            text-shadow: 5px 2px 2px rgba(255,255,255,0.99);

        }

        #intro::before {
            content: '';
            background: url(../assets/images/fond.jpg)  no-repeat left center fixed;
            background-size: cover;
            position: absolute;
            top: 0;
            bottom:0;
            left: 0;
            right: 0;    
            z-index: -1;
            min-height:670px;
        }
    </style>

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Suivi de projets</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="<?php echo(URL)?>">Accueil</a></li>

                <li><a onclick="gestion_user()" > Gestion User</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Liste <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo(URL.'gestion_projets'); ?>" > Liste Projet</a></li>
                        <li><a href="<?php echo(URL.'gestion_modules'); ?>" > Liste Module</a></li>
                        <li><a href="<?php echo(URL.'gestion_taches'); ?>" > Liste Tache</a></li>
                    </ul>
                </li>
                <li><a href="<?php echo(URL.'mes_projets/'); ?>" > Mes Projets</a></li>
                <li><a href="<?php echo(URL.'mes_modules'); ?>" > Mes Modules</a></li>
                <li><a href="<?php echo(URL.'mes_taches/'); ?>" > Mes Taches</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo(URL.'notifications/');?>">Notifications</a></li>
                <li><a href="<?php echo(URL.'logout'); ?>" class="gn-icon gn-icon-logout">Logout</a></li>
            </ul>
        </div>
    </nav>

        <div id="page-content-wrapper">

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