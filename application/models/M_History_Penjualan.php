<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_History_Penjualan extends CI_Model
{
    private $table = "tbl_jual";
    private $primary = "jual_nofak";
    var $column_order = array(null, 'jual_nofak', 'namaplg', 'jual_tanggal', 'no_hp', 'jual_total', 'status', null); //set column field database for datatable orderable
    var $column_search = array('jual_nofak', 'nama', 'A.no_hp'); //set column field database for datatable searchable 
    var $order = array('jual_nofak' => 'DESC'); // default order 

    private function _get_datatables_query()
    {
        $this->db->select('A.*, B.nama AS namaplg')->from('tbl_jual as A');
        $this->db->join('tbl_customer B', 'A.no_hp=B.no_hp', 'LEFT');
        $this->db->where('A.cabang=', '');
        $this->db->where('A.no_hp!=', '');
        $this->db->order_by('A.jual_tanggal', 'DESC');
        $i = 0;
        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
}
