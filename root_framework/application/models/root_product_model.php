<?

class root_product_model extends root_model {


	public function updateSimpleDataById($updateData,$item_id){
        $updateData["update_time"] = time();
        return $this->update($updateData," WHERE product_id = ? ",array($item_id));
    }

    public function delete($deleteIdArray=array()){

        $primary_field = "product_id";

        if(!(is_array($deleteIdArray)&&(sizeof($deleteIdArray)>0))){
            resDie(array(),"delete-is-not-array");
        }

        $idArray = $this->getUniqIdArrayForDelete($primary_field,$deleteIdArray);

        $deleteDataArray = array();
        $success_count = 0;
        if(sizeof($idArray)>0){
            foreach ($idArray as $index => $value) {
                $deleteRow = array();
                $deleteRow[$primary_field] = $value;
                if($value==0){
                    $deleteRow["result"] = 0;
                }else{
                    if($this->getDataById($value)){
                        $result =$this->updateSimpleDataById(array("status"=>0),$value);
                        $deleteRow["result"] = 1;
                        $success_count++;
                    }else{
                        $deleteRow["result"] = 0;
                    }
                }
                array_push($deleteDataArray,$deleteRow);
            }
        }

        $deleteResult = array();
        $deleteResult["total"] = sizeof($idArray);
        $deleteResult["success"] = $success_count;
        $deleteResult["detail"] = $deleteDataArray;
        return $deleteResult;
    }



}

?>