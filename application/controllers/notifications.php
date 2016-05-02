<?php
class Notifications extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('notification_model','',TRUE);
       $this->load->model('datatable_model','',TRUE);
	   
	}
	

    public function viewNotification()
    {
        $page = 'notification_view';
        if ($this->session->userdata('session_user'))//si la session existe
        {
            if ( ! file_exists(APPPATH.'/views/'.$page.'.php'))
            {
                // Whoops, we don't have a page for that!
                show_404();
            }
            $data['title'] = 'Notifications';
            $data['infos_user'] = $this->session->userdata('session_user');
            $this->load->view('layout/header', $data);
            $this->load->view(''.$page, $data);
            $this->load->view('layout/footer');
        }
         else
         {
            //If no session, redirect to login page
             redirect(URL.'login', 'refresh');//si la session n'existe pas
        }
    }

    public function ajax_list()
    {
        $data['infos_user'] = $this->session->userdata('session_user');
        $id_user = $data['infos_user']['id'];

        $table = 'notification';
        $column = array('texte','statut_notification');
        $order = array('id' => 'desc');
        $where = array('id_user' => $id_user);

        $list = $this->datatable_model->get_datatables($table,$column,$order,$where);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $notification) {
            $no++;
            $row = array();
            $row[] = $notification->date;
            $row[] = $notification->texte;
            $row[] = ($notification->statut_notification == 0)? "" : "Nouveau" ;
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->datatable_model->count_all($table,$where),
                        "recordsFiltered" => $this->datatable_model->count_filtered($table,$column,$order,$where),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function NotificationVu($id_user)
    {
        $this->notification_model->setNotificationVu($id_user);
        echo TRUE;
    }
	

}
?>