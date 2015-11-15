<?
 
class mcar_model extends base_module_model {

    public function call(){
       return " mship_model -> callSomeThing ";
    }

    public function getData(){
    	$string = "This is car data";
    	return $string;
    }

    public function getRelateShipData(){

    	$this->mLoadModel("mship_model");
    	return $this->mship_model->getAllMenu();

    }
}

?>