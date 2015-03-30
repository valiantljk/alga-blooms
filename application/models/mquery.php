<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Mquery extends CI_Model {

    function _construct() {
        parent::__construct();
    }

    function select($quer) {

        return $this->db->query($quer);
    }

    function limitselect($quer, $limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->query($quer);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

}
?>
