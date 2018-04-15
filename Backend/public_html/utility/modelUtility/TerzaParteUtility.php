<?php

class TerzaParteUtility
{
    public static function create($newRecords){
        $dbManager = new dbPool();
        $result = array();
        foreach ($newRecords as $singleRecord) {
            $userValues = array(
                $singleRecord['Username'],
                $singleRecord['ClienteId']
            );
            $result["Value"] = $dbManager->insertCmd("INSERT INTO TerzaParte (ThirdPartyUsername,ClienteId) VALUES (?,?)", $userValues);
        }
        echo json_encode($result, true);
    }


    public static function update($newRecords){

        $dbManager = new dbPool();
        $command1 = "UPDATE TerzaParte SET ";
        $command2 = " WHERE Username = ? ";
        $result = array();

        foreach ($newRecords as $single_get){
            $temp_array = TerzaParteUtility::generateUpdateCmd($command1, $command2, $single_get);
            $result["Value"] = $dbManager->queryCmd($temp_array["command"], $temp_array["values"]);
        }
        echo json_encode($result, true);
    }

    public static function generateUpdateCmd($command1, $command2, $parameter_array){

        $keys_array = array_keys($parameter_array);
        $values_array = array();

        foreach($keys_array as $key){
            if($key != 'Username'){
                array_push($values_array,$parameter_array[$key]);
                if($key == end($keys_array)){
                    $command1 .= " ".$key." = ?".$command2;
                } else{
                    $command1 .= " ".$key." = ? ,";
                }
            }else{$keyId = $parameter_array['Username'];}
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
                $singleRecord['Username']
            );
           $result['Value'] = $dbManager->deleteCmd("DELETE FROM TerzaParte  WHERE ThirdPartyUsername = ? ", $userValues);
        }
        echo json_encode($result, true);
    }

    public static function get($parameter_array){
        $dbManager = new dbPool();
        $command = "SELECT * FROM TerzaParte WHERE";
        $final_array = array();

        if($parameter_array == null){
            $resultArray = $dbManager -> queryCmd("SELECT * FROM TerzaParte",null);
            return json_encode($resultArray, true);
        }else{

            foreach ($parameter_array as $single_get){
                $temp_array = TerzaParteUtility::generateQueryCmd($command, $single_get);
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