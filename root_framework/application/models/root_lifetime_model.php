<?

class root_lifetime_model extends root_model {

	private function addNewLifeTimeForProduct($product_id){

        $shop_id = $this->currentShopId();
        $this->load->model("product_model");
        $holder_object_table_id = $this->product_model->getTableId();

        $dbData = array();
        $dbData["holder_object_table_id"] = $holder_object_table_id;
        $dbData["holder_object_id"] = $product_id;
        $dbData["shop_id"] = $shop_id;
        $dbData["status"] = 1;
        $dbData["create_time"] = time();
        $dbData["update_time"] = time();

        $lifetime_id = $this->insertToTable("lifetime",$dbData);
		return $lifetime_id;
	}

	private function getExistsLifeTimeId($product_id){
		$lifetime_id = $this->checkExistsLifeTimeIdForProduct($product_id);
		if(!$lifetime_id){
			$lifetime_id = $this->addNewLifeTimeForProduct($product_id);
		}
		return $lifetime_id;
	}

	private function checkExistsLifeTimeIdForProduct($product_id){

        $shop_id = $this->currentShopId();
        $this->load->model("product_model");
        $holder_object_table_id = $this->product_model->getTableId();

		$sql = " 
            SELECT
                lifetime.lifetime_id AS lifetime_id
            FROM 
                lifetime
            WHERE
                lifetime.status > 0
                AND lifetime.shop_id = ?
                AND lifetime.holder_object_table_id = ?
                AND lifetime.holder_object_id = ?
            LIMIT 
                0,1
            ";
        $param_ar = array($shop_id,$holder_object_table_id,$product_id);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();

        if(@$result_ar[0]["lifetime_id"]==""){
            return false;
        }
        return @$result_ar[0]["lifetime_id"];
	}

    public function enableForProduct($product_id){
    	$this->load->model("root_product_model");
    	return $this->root_product_model->enableLifeTime($product_id);
    }

    public function disableForProduct($product_id){
    	$this->load->model("root_product_model");
    	return $this->root_product_model->disableLifeTime($product_id);
    }

    private function clearLifeTimeForProduct($product_id){

        $shop_id = $this->currentShopId();
        $this->load->model("product_model");
        $holder_object_table_id = $this->product_model->getTableId();

        $dbData = array();
        $dbData["status"] = 0;
        $dbData["update_time"] = time();

        $where_str = " 
            WHERE 
                lifetime.shop_id = ?
                AND lifetime.holder_object_table_id = ? 
                AND lifetime.holder_object_id = ? 
            ";
        $param_ar = array($shop_id,$holder_object_table_id,$product_id);

        return  $this->updateToTable("lifetime",$dbData,$where_str,$param_ar);
    }

    public function setLifeTimeForProduct($product_id,$start_time,$end_time){

        $this->clearLifeTimeForProduct($product_id);
        $lifetime_id = $this->getExistsLifeTimeId($product_id);

    	$dbData = array();
        $dbData["start_time"] = intval($start_time);
        $dbData["end_time"] = intval($end_time)
    	$dbData["update_time"] = time();

        $where_str = " WHERE  lifetime.lifetime_id = ? ";
        $param_ar = array($lifetime_id);

        return $this->updateToTable("lifetime",$dbData,$where_str,$param_ar);
    }

    public function getLifeTimeForProduct($product_id){

        $this->load->model("product_model");
        $holder_object_table_id = $this->product_model->getTableId();

        $sql = " 
            SELECT
                lifetime.lifetime_id AS lifetime_id,
                lifetime.start_time AS lifetime_start_time,
                lifetime.end_time AS lifetime_end_time
            FROM 
                lifetime
            WHERE
                lifetime.status > 0
                AND lifetime.holder_object_table_id = ?
                AND lifetime.holder_object_id = ?
            ORDER BY 
                lifetime.create_time DESC
            LIMIT 
                0,1
            ";
        $param_ar = array($holder_object_table_id,$product_id);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();

        if(@$result_ar[0]["lifetime_id"]==""){
            return false;
        }
        return @$result_ar[0];

    }

}