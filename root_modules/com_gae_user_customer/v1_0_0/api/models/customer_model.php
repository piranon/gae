<?php

class Customer_model extends base_module_model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /** @var array */
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
            'image.file_dir'
        ];
    }

    /**
     * @param array $customer
     * @return int
     * @throws Exception
     */
    public function insert($customer)
    {
        $this->db->insert('customer', array_filter($customer));
        $customer_id = $this->db->insert_id();

        if (!$customer_id) {
            throw new Exception('Cannot insert customer data');
        }

        return $customer_id;
    }

    /**
     * @param array $customer
     * @param int $customer_id
     * @return boolean
     * @throws Exception
     */
    public function update($customer, $customer_id)
    {
        $this->db->where('customer_id', $customer_id);
        $this->db->update('customer', array_filter($customer));

        $result = $this->db->affected_rows();

        if (!$result){
            throw new Exception('Cannot update customer data');
        }

        return $result;
    }

    /**
     * @param $id
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('customer_id', $id);
        $this->db->update('customer', ['status' => Customer_model::STATUS_INACTIVE]);
        return $this->db->affected_rows();
    }

    /**
     * @param array $customer_ids
     * @return boolean
     * @throws Exception
     */
    public function batch_delete($customer_ids)
    {
        $this->db->where_in('customer_id', $customer_ids);
        $this->db->update('customer', ['status' => Customer_model::STATUS_INACTIVE]);
        $result = $this->db->affected_rows();

        if (!$result){
            throw new Exception('Cannot delete customer data');
        }

        return $result;
    }

    /**
     * @param int $customer_id
     * @return array
     */
    public function get_customer_by_id($customer_id)
    {
        $this->customer_select_fields[] = 'customer.password';
        $this->db->select(implode(', ', $this->customer_select_fields));
        $this->db->from('customer');
        $this->db->join('image_matchto_object', 'image_matchto_object.holder_object_id = customer.customer_id', 'left');
        $this->db->join('image', 'image.image_id = image_matchto_object.image_id', 'left');
        $this->db->where('customer.status', Customer_model::STATUS_ACTIVE);
        $this->db->where('customer.customer_id', $customer_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * @return array
     */
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
