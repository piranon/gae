<?php

class Referral_model extends base_module_model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BLOCK = 2;

    /** @var array */
    private $select_fields;

    public function __construct()
    {
        parent::__construct();
        $this->select_fields = [
            'referral.referral_id',
            'referral.shop_id',
            'referral.parent_id',
            'referral.name',
            'referral.status',
            'referral.sort_index',
            'referral.create_time',
            'referral.update_time'
        ];
    }

    /**
     * @param array $referral
     * @return int
     * @throws Exception
     */
    public function insert($referral)
    {
        $this->db->insert('referral', array_filter($referral));
        $referral_id = $this->db->insert_id();

        if (!$referral_id) {
            throw new Exception('Cannot insert referral data');
        }

        return $referral_id;
    }

    /**
     * @param array $referral
     * @param string $referral_id
     * @return mixed
     * @throws Exception
     */
    public function update($referral, $referral_id)
    {
        $this->db->where('referral_id', $referral_id);
        $this->db->update('referral', $referral);

        $result = $this->db->affected_rows();

        if (!$result){
            throw new Exception('Cannot update category data');
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function get_referrals()
    {
        $this->db->select(implode(', ', $this->select_fields));
        $this->db->from('referral');
        $this->db->where('parent_id', 0);
        $this->db->where_in('status', [self::STATUS_ACTIVE, self::STATUS_BLOCK]);
        $this->db->order_by('referral.sort_index', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * @param array $referral_ids
     * @param int $status
     * @return mixed
     * @throws Exception
     */
    public function batch_update($referral_ids, $status)
    {
        $this->db->where_in('referral_id', $referral_ids);
        $this->db->update('referral', ['status' => $status]);
        $result = $this->db->affected_rows();

        if (!$result){
            throw new Exception('Cannot update referral data');
        }

        return $result;
    }

    public function get_cate_child($id, $level)
    {
        $level++;
        $this->db->from('referral');
        $this->db->where('parent_id', $id);
        $this->db->where_in('status', [self::STATUS_ACTIVE, self::STATUS_BLOCK]);
        $this->db->order_by('referral.sort_index', 'asc');
        $query = $this->db->get();
        $referrals = $query->result_array();

        foreach ($referrals as $key => $referral) {
            if ($level <= 5) {
                $cate_child = $this->get_cate_child($referral['referral_id'], $level);
                $referrals[$key]['cate_child_count'] = count($cate_child);
                $referrals[$key]['cate_child'] = $cate_child;
            }
        }

        return $referrals;
    }
}
