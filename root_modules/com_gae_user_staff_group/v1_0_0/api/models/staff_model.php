<?php

class Staff_model extends base_module_model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BLOCK = 2;

    /** @var array */
    private $staff_select_fields;

    public function __construct()
    {
        parent::__construct();
        $this->staff_select_fields = [
            'staff.staff_id',
            'staff.user_name',
            'staff.first_name',
            'staff.last_name',
            'staff.email',
            'staff.status',
            'staff.create_time',
            'staff.update_time',
            'image.image_id',
            'image.file_name',
            'image.file_dir'
        ];
    }

    /**
     * @param array $staff
     * @return int
     * @throws Exception
     */
    public function insert($staff)
    {
        $this->db->insert('staff', array_filter($staff));
        $staff_id = $this->db->insert_id();

        if (!$staff_id) {
            throw new Exception('Cannot insert staff data');
        }

        return $staff_id;
    }

    /**
     * @param array $staff
     * @param int $staff_id
     * @return boolean
     * @throws Exception
     */
    public function update($staff, $staff_id)
    {
        $this->db->where('staff_id', $staff_id);
        $this->db->update('staff', array_filter($staff));

        $result = $this->db->affected_rows();

        if (!$result){
            throw new Exception('Cannot update staff data');
        }

        return $result;
    }

    /**
     * @param $id
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('staff_id', $id);
        $this->db->update('staff', ['status' => Staff_model::STATUS_INACTIVE]);
        return $this->db->affected_rows();
    }

    /**
     * @param array $staff_ids
     * @return boolean
     * @throws Exception
     */
    public function batch_delete($staff_ids)
    {
        $this->db->where_in('staff_id', $staff_ids);
        $this->db->update('staff', ['status' => Staff_model::STATUS_INACTIVE]);
        $result = $this->db->affected_rows();

        if (!$result){
            throw new Exception('Cannot delete staff data');
        }

        return $result;
    }

    /**
     * @param int $staff_id
     * @return array
     */
    public function get_staff_by_id($staff_id)
    {
        $this->staff_select_fields[] = 'staff.password';
        $this->db->select(implode(', ', $this->staff_select_fields));
        $this->db->from('staff');
        $this->db->join('image_matchto_object', 'image_matchto_object.holder_object_id = staff.staff_id', 'left');
        $this->db->join('image', 'image.image_id = image_matchto_object.image_id', 'left');
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where_in('staff.status', [Staff_model::STATUS_ACTIVE, Staff_model::STATUS_BLOCK]);
        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * @return array
     */
    public function get_staffs()
    {
        $this->db->select(implode(', ', $this->staff_select_fields));
        $this->db->from('staff');
        $this->db->join('image_matchto_object', 'image_matchto_object.holder_object_id = staff.staff_id', 'left');
        $this->db->join('image', 'image.image_id = image_matchto_object.image_id', 'left');
        $this->db->where('staff.status', Staff_model::STATUS_ACTIVE);
        $this->db->or_where('staff.status', Staff_model::STATUS_BLOCK);
        $this->db->order_by('staff.create_time', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
}
