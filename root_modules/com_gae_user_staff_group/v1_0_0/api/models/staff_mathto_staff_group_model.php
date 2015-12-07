<?php

class Staff_mathto_staff_group_model extends base_module_model
{
    /**
     * @param int $group_id
     * @return int
     */
    public function count_staff($group_id)
    {
        $this->db->where('staff_group_id', $group_id);
        $this->db->from('staff_mathto_staff_group');
        return $this->db->count_all_results();
    }
}
