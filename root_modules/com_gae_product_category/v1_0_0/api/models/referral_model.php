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
            'referral.update_time',
            'image.image_id',
            'image.file_name',
            'image.file_dir'
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
}
