<?

class root_product_time_model extends root_model {

	public function updateSimpleDataById($updateData,$item_id){
        $updateData["update_time"] = time();
        return $this->update($updateData," WHERE product_id = ? ",array($item_id));
    }

}