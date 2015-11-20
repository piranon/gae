<?php

class Customer_model extends base_module_model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public function insert($customer)
    {
        $this->db->insert('customer', $customer);
        return $this->db->insert_id();
    }

    public function delete($id)
    {
        $this->db->where('customer_id', $id);
        $this->db->update('customer', ['status' => Customer_model::STATUS_INACTIVE]);
        return $this->db->affected_rows();
    }

    public function batch_delete($ids)
    {
        $this->db->where_in('id', $ids);
        $this->db->update('customer', ['status' => Customer_model::STATUS_INACTIVE]);
        return $this->db->affected_rows();
    }

    public function get_customer_by_id($id)
    {
        $fields = [
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
        $this->db->select(implode(', ', $fields));
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
        $fields = [
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
        $this->db->select(implode(', ', $fields));
        $this->db->from('customer');
        $this->db->join('image_matchto_object', 'image_matchto_object.holder_object_id = customer.customer_id', 'left');
        $this->db->join('image', 'image.image_id = image_matchto_object.image_id', 'left');
        $this->db->where('customer.status', Customer_model::STATUS_ACTIVE);
        $this->db->order_by('customer.create_time', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_customer()
    {
        $fields = [
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
        $this->db->select(implode(', ', $fields));
        $this->db->from('customer');
        $this->db->join('image_matchto_object', 'image_matchto_object.holder_object_id = customer.customer_id', 'left');
        $this->db->join('image', 'image.image_id = image_matchto_object.image_id', 'left');
        $this->db->where('customer.status', Customer_model::STATUS_ACTIVE);
        $this->db->order_by('customer.create_time', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
}
