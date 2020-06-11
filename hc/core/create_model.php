<?php 

$string = "<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class " . $m . " extends CI_Model
{

    public \$table = '$table_name';
    public \$id = '$pk';
    public \$order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }";

if ($jenis_tabel <> 'reguler_table') {
    
$column_all = array();
foreach ($all as $row) {
    $column_all[] = $row['column_name'];
}
$columnall = implode(',', $column_all);
    
$string .="\n\n    // datatables
    function json() {
        \$this->datatables->select('".$columnall."');
        \$this->datatables->from('".$table_name."');
        //add this line for join
        //\$this->datatables->join('table2', '".$table_name.".field = table2.field');
        \$this->datatables->add_column('action', anchor(site_url('".$c_url."/read/\$1'),'Read').\" | \".anchor(site_url('".$c_url."/update/\$1'),'Update').\" | \".anchor(site_url('".$c_url."/delete/\$1'),'Delete','onclick=\"javasciprt: return confirm(\\'Are You Sure ?\\')\"'), '$pk');
        return \$this->datatables->generate();
    }";
}

$string .="\n\n    // get all
    function get_all()
    {
        \$this->db->order_by(\$this->id, \$this->order);
        return \$this->db->get(\$this->table)->result();
    }

    // get data by id
    function get_by_id(\$id)
    {
        \$this->db->where(\$this->id, \$id);
        return \$this->db->get(\$this->table)->row();
    }
    
    // get total rows
    function total_rows(\$q = NULL) {
        \$this->db->like('$pk', \$q);";

foreach ($non_pk as $row) {
    $string .= "\n\t\$this->db->or_like('" . $row['column_name'] ."', \$q);";
}    

$string .= "\n\t\$this->db->from(\$this->table);
        return \$this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data(\$limit, \$start = 0, \$q = NULL) {
        \$this->db->order_by(\$this->id, \$this->order);
        \$this->db->like('$pk', \$q);";

foreach ($non_pk as $row) {
    $string .= "\n\t\$this->db->or_like('" . $row['column_name'] ."', \$q);";
}    

$string .= "\n\t\$this->db->limit(\$limit, \$start);
        return \$this->db->get(\$this->table)->result();
    }

    // insert data
    function insert(\$data)
    {
        \$this->db->insert(\$this->table, \$data);
    }

    // update data
    function update(\$id, \$data)
    {
        \$this->db->where(\$this->id, \$id);
        \$this->db->update(\$this->table, \$data);
    }

    // delete data
    function delete(\$id)
    {
        \$this->db->where(\$this->id, \$id);
        \$this->db->delete(\$this->table);
    }

}

/* End of file $m_file */
/* Location: ./application/models/$m_file */
/* Please DO NOT modify this information : */
/* by Vicky Arisandy ".date('Y-m-d H:i:s')." */";




$hasil_model = createFile($string, $target."models/" . $m_file);

?>