<?php

class Staff_mathto_staff_group_model extends base_module_model
{
    /**
     * @param array $mathto_staff
     * @return int
     * @throws Exception
     */
    public function insert($mathto_staff)
    {
        $this->db->insert('staff_mathto_staff_group', $mathto_staff);
        $id = $this->db->insert_id();

        if (!$id) {
            throw new Exception('Cannot insert group data');
        }

        return $id;
    }

    /**
     * @param int $staff_group_id
     * @param int $staff_id
     * @return bool
     */
    function create_mathto_staff_group($staff_group_id, $staff_id)
    {
        if (empty($staff_group_id)) {
            return false;
        }

        $this->db->where('staff_group_id', $staff_group_id);
        $this->db->where('staff_id', $staff_id);
        $qurey = $this->db->get('staff_mathto_staff_group');

        if ($qurey->num_rows() > 0) {
            $this->db->where('staff_group_id', $staff_group_id);
            $this->db->where('staff_id', $staff_id);
            $this->db->update('staff_mathto_staff_group',[
                'staff_group_id' => $staff_group_id,
                'staff_id' => $staff_id,
                'update_time' => time()
            ]);
        } else {
            $this->db->insert('staff_mathto_staff_group', [
                'staff_group_id' => $staff_group_id,
                'staff_id' => $staff_id,
                'create_time' => time()
            ]);
        }

        return $this->db->affected_rows();
    }

    /**
     * @param int $staff_id
     * @return array
     */
    public function get_staffs($staff_id)
    {
        $this->db->select([
            'staff_group.staff_group_id',
            'staff_group.name'
        ]);
        $this->db->from('staff_mathto_staff_group');
        $this->db->join(
            'staff_group',
            'staff_group.staff_group_id = staff_mathto_staff_group.staff_group_id',
            'left'
        );
        $this->db->where('staff_mathto_staff_group.staff_id', $staff_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
