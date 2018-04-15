<?php


class ImpiantoUtility
{
    public static function create($newRecords){
        $dbManager = new dbPool();
        $result = array();

        foreach ($newRecords as $singleRecord) {

            $valuesArray = array(
                $singleRecord["Longitudine"],
                $singleRecord["Latitudine"],
                $singleRecord["Nome"],
                $singleRecord['Stato'],
                $singleRecord['ClienteId']
            );
            $result["Value"] = $dbManager->insertCmd("INSERT INTO Impianto ( Longitudine, Latitudine, Nome, Stato, ClienteId) VALUES (?,?,?,?,?)", $valuesArray);
        }
        echo json_encode($result, true);
        }


    public static function update($newRecords){

        $dbManager = new dbPool();
        $command1 = "UPDATE Impianto SET ";
        $command2 = " WHERE Id = ? ";
        $result = array();

        foreach ($newRecords as $single_get){
            $temp_array = ImpiantoUtility::generateUpdateCmd($command1, $command2, $single_get);
            $result["Value"] = $dbManager->queryCmd($temp_array["command"], $temp_array["values"]);
        }
        echo json_encode($result, true);
    }

    public static function generateUpdateCmd($command1, $command2, $parameter_array){

        $keys_array = array_keys($parameter_array);
        $values_array = array();

        foreach($keys_array as $key){
            if($key != 'Id'){
                array_push($values_array,$parameter_array[$key]);
                if($key == end($keys_array)){
                    $command1 .= " ".$key." = ?".$command2;
                } else{
                    $command1 .= " ".$key." = ? ,";
                }
            }else{$keyId = $parameter_array['Id'];}
        }
        array_push($values_array,$keyId);

        $result = array(
            "command" => $command1,
            "values" => $values_array
        );

        return $result;
    }


    public static function delete($newRecords){
        $dbManager = new dbPool();
        $result = array();
        foreach ($newRecords as $singleRecord) {
            $userValues = array(
                $singleRecord['Id']
            );
            $result["Value"] = $dbManager->deleteCmd("DELETE FROM Impianto  WHERE Id = ? ", $userValues);
        }
        echo json_encode($result, true);
    }


    public static function get($parameter_array){
        $dbManager = new dbPool();
        $command = "SELECT * FROM Impianto WHERE";
        $final_array = array();

        if($parameter_array == null){
            $resultArray = $dbManager -> queryCmd("SELECT * FROM Impianto",null);
            return json_encode($resultArray, true);
        }else{

            foreach ($parameter_array as $single_get){
                $temp_array = ImpiantoUtility::generateQueryCmd($command, $single_get);
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