<?

class root_stock_model extends root_model {

    public function __construct()
    {
        parent::__construct();
    }

    public function addStockForProduct($product_id,$amount){
    	$amount = abs($amount);
    	return $this->insertStockRowForProduct($product_id,$amount);
    }

    public function subStockForProduct($product_id,$amount){
    	$amount = abs($amount)*-1;
    	return $this->insertStockRowForProduct($product_id,$amount);
    }
    private function insertStockRowForProduct($product_id,$amount){

    	$amount = intval($amount);
    	$dbData = array();
    	$dbData["product_id"] = intval($product_id);
    	$dbData["index"] = 0;
    	$dbData["amount"] = $amount;
    	$dbData["status"] = 1;
    	$dbData["create_time"] = time();
    	$dbData["update_time"] = time();

    	$stock_id = $this->insertToTable("stock",$dbData);
        if(!$stock_id){
            return false;
        }
        return $stock_id;
    }

    public function getTotalStockNumberForProduct($product_id){

    	$sql = "
    		SELECT 
    			SUM(stock.amount) AS total_number
    		FROM 
    			stock
    		WHERE
    			stock.status = 1
    			stock.product_id = ?
    	";
    	$param_ar = array();
        $param_ar = array_merge($product_id);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();
        return intval(@$result_ar[0]["total_number"]);
    }

    public function enableStockForProduct($product_id){
    	$this->load->model("root_stock_model");
    	return $this->root_stock_model->updateSimpleDataById(array("is_stock_enable"=>1),$product_id);
    }

    public function disableStockForProduct($product_id){
    	$this->load->model("root_stock_model");
    	return $this->root_stock_model->updateSimpleDataById(array("is_stock_enable"=>0),$product_id);
    }

?>