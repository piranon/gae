<?php

class Image_model extends base_module_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("root_image_model");
    }

    /**
     * @param int $row_id
     * @param int $table_id
     * @return mixed
    */
    public function upload_image($row_id, $table_id)
    {
        $field_name = 'profile_pic';
        if (empty($_FILES[$field_name])) {
            return true;
        }

        $this->delete_image($row_id, $table_id);

        $max_number = 1;
        $object_table_id = $table_id;
        $object_id = $row_id;
        $type_id = 1;

        $this->root_image_model->uploadImageMatchToObject(
            $field_name,
            $object_table_id,
            $object_id,
            $type_id,
            $max_number
        );
    }

    /**
     * @param int $row_id
     * @param int $table_id
     */
    public function delete_image($row_id, $table_id)
    {
        $object_table_id = $table_id;
        $object_id = $row_id;
        $type_id = 1;

        $this->root_image_model->cleanImageRelationByKey($object_table_id, $object_id, $type_id);
    }

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
