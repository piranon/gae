<?php

class Attribute_model extends base_module_model
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
            'attribute.attribute_id',
            'attribute.shop_id',
            'attribute.attribute_type_id',
            'attribute.parent_id',
            'attribute.name',
            'attribute.status',
            'attribute.create_time',
            'attribute.update_time'
        ];
    }

    /**
     * @param array $attribute
     * @return int
     * @throws Exception
     */
    public function insert($attribute)
    {
        $this->db->insert('attribute', array_filter($attribute));
        $attribute_id = $this->db->insert_id();

        if (!$attribute_id) {
            throw new Exception('Cannot insert attribute data');
        }

        return $attribute_id;
    }

    /**
     * @param array $attribute
     * @param string $attribute_id
     * @return mixed
     * @throws Exception
     */
    public function update($attribute, $attribute_id)
    {
        $this->db->where('attribute_id', $attribute_id);
        $this->db->update('attribute', $attribute);

        $result = $this->db->affected_rows();

        if (!$result){
            throw new Exception('Cannot update category data');
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function get_attributes()
    {
        $this->db->select(implode(', ', $this->select_fields));
        $this->db->from('attribute');
        $this->db->where('parent_id', 0);
        $this->db->where_in('status', [self::STATUS_ACTIVE, self::STATUS_BLOCK]);
        $this->db->order_by('attribute.attribute_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * @param array $attribute_ids
     * @param int $status
     * @return mixed
     * @throws Exception
     */
    public function batch_update($attribute_ids, $status)
    {
        $this->db->where_in('attribute_id', $attribute_ids);
        $this->db->update('attribute', ['status' => $status]);
        $result = $this->db->affected_rows();

        if (!$result){
            throw new Exception('Cannot update attribute data');
        }

        return $result;
    }

    /**
     * @param array $attribute_ids
     * @param int $type
     * @return mixed
     * @throws Exception
     */
    public function batch_update_type($attribute_ids, $type)
    {
        $this->db->where_in('attribute_id', $attribute_ids);
        $this->db->update('attribute', ['attribute_type_id' => $type]);
        $result = $this->db->affected_rows();

        if (!$result){
            throw new Exception('Cannot update attribute data');
        }

        return $result;
    }

    /**
     * @param int $id
     * @param int $level
     * @return mixed
     */
    public function get_cate_child($id, $level)
    {
        $level++;
        $this->db->from('attribute');
        $this->db->where('parent_id', $id);
        $this->db->where_in('status', [self::STATUS_ACTIVE, self::STATUS_BLOCK]);
        $this->db->order_by('attribute.attribute_id', 'desc');
        $query = $this->db->get();
        $attributes = $query->result_array();

        foreach ($attributes as $key => $attribute) {
            if ($level <= 5) {
                $cate_child = $this->get_cate_child($attribute['attribute_id'], $level);
                $attributes[$key]['cate_child_count'] = count($cate_child);
                $attributes[$key]['cate_child'] = $cate_child;
            }
        }

        return $attributes;
    }
}
