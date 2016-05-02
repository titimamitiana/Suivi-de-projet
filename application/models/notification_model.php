<?php
class Notification_model extends CI_Model {

    public function setNotification($array){
        $array = array_merge($array,
            array('statut_notification' => 1,
            'date' => date('Y-m-d')));
        $query = $this->db->insert('notification', $array);
        if($query)
        {
            return TRUE;
        }
        else
        {
            return $this->db->_error_message();
        }
    }

    public function setNotificationVu($id_user){
        $data = array(
                'statut_notification' => 0,
                );
        $this->db->where('id_user',$id_user);
        $this->db->update('notification' ,$data);
        return $this->db->affected_rows();
    }
}