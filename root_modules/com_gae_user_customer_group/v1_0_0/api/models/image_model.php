<?php

class Image_model extends base_module_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("root_image_model");
    }

    /**
     * @param int $table_id
     * @param int $row_id
     * @return mixed
     */
    public function get_image($table_id, $row_id)
    {
        $this->db->select('image.image_id, image.file_name, image.file_dir');
        $this->db->from('image_matchto_object');
        $this->db->join('image', 'image.image_id = image_matchto_object.image_id', 'left');
        $this->db->where('image_matchto_object.holder_object_table_id', $table_id);
        $this->db->where('image_matchto_object.holder_object_id', $row_id);
        $query = $this->db->get();
        return $query->row_array();
    }
}
