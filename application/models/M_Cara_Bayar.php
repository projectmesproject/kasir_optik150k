<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Cara_Bayar extends CI_Model
{
    private $table = "tbl_cara_bayar";
    private $primary = "id";
    var $column_order = array(null, 'id', 'cara_bayar', null); //set column field database for datatable orderable
    var $column_search = array('id', 'cara_bayar'); //set column field database for datatable searchable 
    var $order = array('id' => 'ASC'); // default order 

    private function _get_datatables_query()
    {
        $this->db->select('*');
        $this->db->from($this->table);
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
    public function list()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $data = $this->db->get()->result();
        return $data;
    }

    public function get($id)
    {
        $this->db->select('*');
        $this->db->where($this->primary, $id);
        $this->db->from($this->table);
        $data = $this->db->get()->row_array();
        return $data;
    }

    public function getById($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $data = $this->db->get($this->table)->result_array();
        return $data;
    }

    public function getNew($id)
    {
        $data = $this->getById($id);
        if ($data) {
            $id = [];
            foreach ($data as $value) {
                array_push($id, (int)$value['id']);
            }
            $res = max($id);
            return $res + 1;
        } else {
            return substr($id, 2, 1) . "01";
        }
    }

    public function create($data)
    {
        $this->db->insert($this->table, $data);
    }
    public function delete($id)
    {
        $this->db->where($this->primary, $id);
        $res = $this->db->delete($this->table);
        return $res;
    }
    public function update($id, $data)
    {
        $this->db->where($this->primary, $id);
        $res = $this->db->update($this->table, $data);
        return $res;
    }
}
