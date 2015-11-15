<?
 
class mship_model extends base_module_model {

    public function callSomeThing(){
       return " mship_model -> callSomeThing ";
    }

    public function getAllMenu(){
    	$this->load->model("menu_model");
    	return $this->menu_model->getAllMenuData(12);
    }
}

?>