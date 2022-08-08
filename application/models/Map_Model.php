<?php

class Map_Model extends CI_Model
{


    function construct()
    {
        parent::__construct();
    }

    function get_all_location()
    {
        $query = $this->db->query("SELECT * FROM location");

        $indeks = 0;
        $result = array();

        foreach ($query->result_array() as $row) {
            $result[$indeks++] = $row;
        }

        return $result;
    }

    function delete_location($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('location');
    }
}
