<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = 'user/login';
$route['login'] = 'user/login';
$route['user/check_user'] = 'user/check_user';
$route['home'] = 'pages/home';
$route['logout'] = 'user/logout';

$route['mes_projets'] = 'projet/view_projets';
$route['mes_projets/ajax_list_projet/(:num)'] = 'projet/ajax_list_projet/$1';
$route['mes_projets/ajax_add_projet'] = 'projet/ajax_add_projet';
$route['mes_projets/ajax_edit_projet/(:num)'] = 'projet/ajax_edit_projet/$1';
$route['mes_projets/ajax_update_projet'] = 'projet/ajax_update_projet';
$route['mes_projets/ajax_delete_projet/(:num)'] = 'projet/ajax_delete_projet/$1';

$route['mes_projets/modules/(:num)'] = 'projet/view_modules/$1';
$route['mes_projets/ajax_list_module/(:num)'] = 'projet/ajax_list_module/$1';
$route['mes_projets/ajax_add_module/(:num)'] = 'module/ajax_add_module/$1';
$route['mes_projets/ajax_edit_module/(:num)'] = 'module/ajax_edit_module/$1';
$route['mes_projets/ajax_update_module'] = 'module/ajax_update_module';
$route['mes_projets/ajax_delete_module/(:num)'] = 'module/ajax_delete_module/$1';

$route['mes_projets/modules/taches/(:num)'] = 'projet/view_taches/$1';
$route['mes_projets/ajax_list_tache/(:num)'] = 'projet/ajax_list_tache/$1';
$route['mes_projets/ajax_add_tache/(:num)'] = 'tache/ajax_add_tache/$1';
$route['mes_projets/ajax_edit_tache/(:num)'] = 'tache/ajax_edit_tache/$1';
$route['mes_projets/ajax_update_tache'] = 'tache/ajax_update_tache';
$route['mes_projets/ajax_delete_tache/(:num)'] = 'tache/ajax_delete_tache/$1';

$route['gestion_user'] = 'user/view_users';
$route['users/ajax_list_users'] = 'user/ajax_list_users';
$route['users/ajax_add_user'] = 'user/ajax_add_user';
$route['users/ajax_update_user'] = 'user/ajax_update_user';
$route['users/ajax_edit_user/(:num)'] = 'user/ajax_edit_user/$1';
$route['users/ajax_delete_user/(:num)'] = 'user/ajax_delete_user/$1';

$route['gestion_projets'] = 'gestion_projet/view_projets';
$route['gestion_projet/ajax_list_projet'] = 'gestion_projet/ajax_list_projet';
$route['gestion_projet/ajax_edit_projet/(:num)'] = 'projet/ajax_edit_projet/$1';
$route['gestion_projet/ajax_add_projet'] = 'projet/ajax_add_projet';
$route['gestion_projet/ajax_update_projet'] = 'projet/ajax_update_projet';
$route['gestion_projet/ajax_delete_projet/(:num)'] = 'projet/ajax_delete_projet/$1';
$route['filtre/save_filter_project'] = 'filtre/save_filter_project';
$route['filtre/read_filter_project'] = 'filtre/read_filter_project';
$route['gestion_projet/ajax_list_projet_my_filter'] = 'gestion_projet/ajax_list_projet_my_filter';
$route['gprojet/ajax_add_module'] = 'gestion_projet/ajax_add_module';

$route['gestion_modules'] = 'gestion_module/view_modules';
$route['gestion_modules/ajax_projet_list_module'] = 'gestion_module/ajax_projet_list_module';
$route['gestion_modules/ajax_edit_module/(:num)'] = 'module/ajax_edit_module/$1';
$route['gestion_modules/ajax_delete_module/(:num)'] = 'module/ajax_delete_module/$1';
$route['gestion_modules/ajax_update_module'] = 'module/ajax_update_module';
$route['gestion_modules/ajax_edit_tache/(:num)'] = 'module/ajax_edit_module/$1';
$route['gestion_modules/ajax_add_tache'] = 'gestion_module/ajax_add_tache';
$route['filtre/save_filter_module'] = 'filtre/save_filter_module';
$route['filtre/read_filter_module'] = 'filtre/read_filter_module';
$route['gestion_modules/ajax_list_module_my_filter'] = 'gestion_module/ajax_list_module_my_filter';

$route['gestion_taches'] = 'gestion_tache/view_taches';
$route['gestion_taches/ajax_list_tache'] = 'gestion_tache/ajax_list_tache';
$route['gestion_taches/ajax_edit_tache/(:num)'] = 'tache/ajax_edit_tache/$1';
$route['gestion_taches/ajax_delete_tache/(:num)'] = 'tache/ajax_delete_tache/$1';
$route['gestion_taches/ajax_update_tache'] = 'tache/ajax_update_tache';
$route['gestion_taches/ajax_list_tache_my_filter'] = 'gestion_tache/ajax_list_tache_my_filter';
$route['filtre/save_filter_tache'] = 'filtre/save_filter_tache';
$route['filtre/read_filter_tache'] = 'filtre/read_filter_tache';
$route['gestion_taches/ajax_edit_avancement/(:num)'] = 'tache/ajax_edit_tache/$1';
$route['gestion_taches/ajax_update_avancement_tache'] = 'tache/ajax_update_avancement_tache';

$route['404_override'] = '';

$route['mes_taches'] = 'tache/view_taches';
$route['mes_taches/ajax_list_tache/(:num)'] = 'tache/ajax_list_tache/$1';
$route['mes_taches/ajax_edit_tache/(:num)'] = 'tache/ajax_edit_tache/$1';
$route['mes_taches/ajax_update_avancement_tache'] = 'tache/ajax_update_avancement_tache';
$route['mes_taches/info_tache/(:num)'] = 'tache/info_tache/$1';
$route['mes_taches/ajax_list_tache_info/(:num)'] = 'tache/ajax_list_tache_info/$1';

$route['notifications'] = 'notifications/viewNotification';
$route['notificationVu/(:num)'] = 'notifications/NotificationVu/$1';
$route['notification/list'] = 'notifications/ajax_list';

$route['testDroit'] = 'profil/testDroit';
$route['testDroitTache'] = 'profil/testDroitTache';
$route['testDroitModule'] = 'profil/testDroitModule';
$route['isSuperManager'] = 'profil/isSuperManager';

$route['mes_modules'] = 'module/view_modules';
$route['mes_modules/ajax_list_modules/(:num)'] = 'module/ajax_list_modules/$1';

$route['mes_modules/taches/(:num)'] = 'module/view_taches/$1';
$route['mes_modules/ajax_list_tache/(:num)'] = 'module/ajax_list_tache/$1';
$route['mes_modules/ajax_add_tache/(:num)'] = 'tache/ajax_add_tache/$1';
$route['mes_modules/ajax_edit_tache/(:num)'] = 'tache/ajax_edit_tache/$1';
$route['mes_modules/ajax_update_tache'] = 'tache/ajax_update_tache';
$route['mes_modules/ajax_delete_tache/(:num)'] = 'tache/ajax_delete_tache/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */