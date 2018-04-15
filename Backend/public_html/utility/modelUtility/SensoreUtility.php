<?php


class SensoreUtility
{
    public static function create($newRecords){
        $dbManager = new dbPool();
        $result = array();

        foreach ($newRecords as $singleRecord ){
            $valuesArray = array(
                $singleRecord['Tipo'],
                $singleRecord['Marca'],
                $singleRecord['Stato'],
                $singleRecord["ImpiantoId"]
            );

           $result["Value"] = $dbManager->insertCmd("INSERT INTO Sensore(Tipo, Marca, Stato, ImpiantoId) VALUES (?,?,?,?)", $valuesArray);
        }
        echo json_encode($result, true);
    }



    public static function delete($newRecords){
        $result = array();
        $dbManager = new dbPool();
        foreach ($newRecords as $singleRecord){
            $valuesArray = array(
                $singleRecord['Id']
            );
            $result["Value"] = $dbManager->deleteCmd("DELETE FROM Sensore  WHERE Id = ? ", $valuesArray);
        }
        echo json_encode($result, true);

    }

    public static function update($stato,$id){
        $result = array();
        $dbManager = new dbPool();
        $result["Value"] =  $dbManager -> updateCmd("UPDATE Sensore SET stato = ? WHERE  id = ?",array($stato,$id));
        echo json_encode($result, true);
    }

    public static function get($parameter_array){
        $dbManager = new dbPool();
        $command = "SELECT * FROM Sensore WHERE";
        $final_array = array();

        if($parameter_array == null){
            $resultArray = $dbManager -> queryCmd("SELECT * FROM Sensore",null);
            return json_encode($resultArray, true);
        }else{

            foreach ($parameter_array as $single_get){
                $temp_array = SensoreUtility::generateQueryCmd($command, $single_get);
                $resultArray = $dbManager->queryCmd($temp_array["command"], $temp_array["values"]);
                array_push($final_array,$resultArray);
            }
            return json_encode($final_array, true);
        }

    }

    public static function generateQueryCmd($command,$parameter_array){

        $keys_array = array_keys($parameter_array);
        $values_array = array();
        foreach($keys_array as $key){
            array_push($values_array,$parameter_array[$key]);
            if($key == end($keys_array)){
                $command .= " ".$key." = ?";
            } else{
                $command .= " ".$key." = ? AND";
            }
        }

        $result = array(
            "command" => $command,
            "values" => $values_array
        );
        return $result;
    }
}