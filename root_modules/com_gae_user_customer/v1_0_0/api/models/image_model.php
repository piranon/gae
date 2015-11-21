<?php
 
class Image_model extends base_module_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("root_image_model");
    }

    /**
     * @param int $customer_id
     * @param int $table_id
     * @return mixed
    */
    public function upload_image_profile($customer_id, $table_id)
    {
        $field_name = 'profile_pic';
        if (empty($_FILES[$field_name])) {
            return true;
        }

        $this->delete_image_profile($customer_id, $table_id);

        $max_number = 1;
        $object_table_id = $table_id;
        $object_id = $customer_id;
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
     * @param int $customer_id
     * @param int $table_id
     */
    public function delete_image_profile($customer_id, $table_id)
    {
        $object_table_id = $table_id;
        $object_id = $customer_id;
        $type_id = 1;

        $this->root_image_model->cleanImageRelationByKey($object_table_id, $object_id, $type_id);
    }
}
