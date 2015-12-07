<?php

class Staff_group_model extends base_module_model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public function insert($staff_group)
    {
        $this->db->insert('staff_group', array_filter($staff_group));
        $group_id = $this->db->insert_id();

        if (!$group_id) {
            throw new Exception('Cannot insert staff group data');
        }

        return $group_id;
    }

    /**
     * @param array $staff_group
     * @param int $staff_group_id
     * @return boolean
     * @throws Exception
     */
    public function update($staff_group, $staff_group_id)
    {
        $this->db->where('staff_group_id', $staff_group_id);
        $this->db->update('staff_group', array_filter($staff_group));

        $result = $this->db->affected_rows();

        if (!$result){
            throw new Exception('Cannot update staff group data');
        }

        return $result;
    }

    /**
     * @return array
     */
    public function get_staff_group_by_id($id)
    {
        $this->db->from('staff_group');
        $this->db->where('staff_group_id', $id);
        $this->db->where('status', Staff_group_model::STATUS_ACTIVE);
        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * @return array
     */
    public function get_staff_groups()
    {
        $this->db->from('staff_group');
        $this->db->where('status', staff_group_model::STATUS_ACTIVE);
        $this->db->order_by('create_time', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * @param array $staff_group_ids
     * @return array
     * @throws Exception
     */
    public function batch_delete($staff_group_ids)
    {
        $this->db->where_in('staff_group_id', $staff_group_ids);
        $this->db->update('staff_group', ['status' => Staff_group_model::STATUS_INACTIVE]);
        $result = $this->db->affected_rows();

        if (!$result){
            throw new Exception('Cannot delete staff group data');
        }

        return $result;
    }
}
