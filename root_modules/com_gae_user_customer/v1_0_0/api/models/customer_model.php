<?php

class Customer_model extends base_module_model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    private $customer_select_fields;

    public function __construct()
    {
        parent::__construct();
        $this->customer_select_fields = [
            'customer.customer_id',
            'customer.user_name',
            'customer.first_name',
            'customer.last_name',
            'customer.birthday',
            'customer.gender_type_id',
            'customer.email',
            'customer.phone',
            'customer.tag',
            'customer.create_time',
            'customer.update_time',
            'image.image_id',
            'image.file_name',
            'image.file_dir',
        ];
    }

    public function insert($customer)
    {
        $this->db->insert('customer', $customer);
        $customer_id = $this->db->insert_id();

        if (!$customer_id) {
            throw new Exception('Cannot insert customer data');
        }

        return $customer_id;
    }

    public function delete($id)
    {
        $this->db->where('customer_id', $id);
        $this->db->update('customer', ['status' => Customer_model::STATUS_INACTIVE]);
        return $this->db->affected_rows();
    }

    public function batch_delete($ids)
    {
        $this->db->where_in('customer_id', $ids);
        $this->db->update('customer', ['status' => Customer_model::STATUS_INACTIVE]);
        $result = $this->db->affected_rows();

        if (!$result){
            throw new Exception('Cannot delete customer data');
        }

        return $result;
    }

    public function get_customer_by_id($id)
    {
        $this->db->select(implode(', ', $this->customer_select_fields));
        $this->db->from('customer');
        $this->db->join('image_matchto_object', 'image_matchto_object.holder_object_id = customer.customer_id', 'left');
        $this->db->join('image', 'image.image_id = image_matchto_object.image_id', 'left');
        $this->db->where('customer.status', Customer_model::STATUS_ACTIVE);
        $this->db->where('customer.customer_id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_customers()
    {
        $this->db->select(implode(', ', $this->customer_select_fields));
        $this->db->from('customer');
        $this->db->join('image_matchto_object', 'image_matchto_object.holder_object_id = customer.customer_id', 'left');
        $this->db->join('image', 'image.image_id = image_matchto_object.image_id', 'left');
        $this->db->where('customer.status', Customer_model::STATUS_ACTIVE);
        $this->db->order_by('customer.create_time', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
}
