<?
class root_sampledata_model extends root_model {

    public function generateListData($keyStr,$sampleData,$cur_page,$per_page,$maxNumber,$subNumber=0,$searchString=""){

        $startIndex = (($cur_page-1)*$per_page);
        if($startIndex<0){
            $startIndex = 0;
        }
        $endIndex = $startIndex+$per_page;

        if($endIndex>$maxNumber){
           $endIndex = $maxNumber; 
        }

        $newgid = $subNumber+$startIndex+ord(md5($keyStr+$searchString));

        $dataList = array();
        for($i=$startIndex;$i<$endIndex;$i++){

            $itemData = array();
            foreach($sampleData as $key => $value){

                $keyEx = explode("|",$key,3);
                $valueForKey = $key." ".@strval($value)."-".$newgid;

                if(sizeof($keyEx)>1){

                    $extend_key = strtolower(trim($keyEx[1]));

                    if($extend_key=="pri"){

                        $valueForKey = $newgid;

                    }else if($extend_key=="time"){

                        $valueForKey = intval($value)+$newgid;

                    }else if($extend_key=="rand"){

                        $value_rand_str = explode(",",$key,2);
                        $valueForKey = rand(intval(trim($value_rand_str[0])),intval(trim($value_rand_str[1])));

                    }else if($extend_key=="ori"){
                        $valueForKey = $value;
                    }else if($extend_key=="subarray"){ 
                        if((is_array($value)&&sizeof($value)>1)){
                            $subArraySize = sizeof($value);  

                            if(strlen(@trim($keyEx[2]))>0){
                                $subArraySize = (int)trim($keyEx[2]);
                            }
                            $subData = $this->generateListData($keyStr,$value,1,$subArraySize,$subArraySize,$newgid,"");
                            $valueForKey = $subData["dataList"];
                        }else{

                            $valueForKey = $value;
                        }
                    }else if($extend_key=="subdata"){

        
                            $subArraySize = sizeof($value);  
                            $subData = $this->generateListData($keyStr,$value,1,1,$subArraySize,$newgid,"");
                            $valueForKey = $subData["dataList"][0];
                        
                    } 

                    $itemData[trim($keyEx[0])] = $valueForKey;
                }else{
                    $itemData[$key] = $valueForKey;
                }

            }
            array_push($dataList,$itemData);
            $newgid++;
        }

        return $dataList;
    }

}
?>