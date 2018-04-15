<?php

class CredenzialiUtility
{

    public static function create($newRecords){
        $dbManager = new dbPool();
        $bool =array();

        foreach ($newRecords as $singleRecord) {

            $userValues = array(
                $singleRecord['Username'],
                password_hash($singleRecord['Password'], PASSWORD_DEFAULT),
                $singleRecord['Ruolo']
            );
            $dbManager->insertCmd("INSERT INTO Utente ( Username, Password, Ruolo) VALUES (?,?,?)", $userValues);

        }
    }

    public static function update($newRecords){

        $dbManager = new dbPool();
        $command1 = "UPDATE Utente SET ";
        $command2 = " WHERE Username = ? ";

        foreach ($newRecords as $single_get){
            $temp_array = CredenzialiUtility::generateUpdateCmd($command1, $command2, $single_get);
            $dbManager->queryCmd($temp_array["command"], $temp_array["values"]);

        }
    }

    public static function generateUpdateCmd($command1, $command2, $parameter_array){

        $keys_array = array_keys($parameter_array);
        $values_array = array();

        foreach($keys_array as $key){
            if($key != 'Username'){
                if($key == 'Password'){
                    $passwordCript = password_hash($parameter_array[$key], PASSWORD_DEFAULT);
                    array_push($values_array,$passwordCript);
                }else{
                    array_push($values_array,$parameter_array[$key]);
                }
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
        $result = array();

        $dbManager = new dbPool();
        foreach ($newRecords as $singleRecord){
            $valuesArray = array(
                $singleRecord['Username']
            );
            $result["Value"] =  $dbManager->deleteCmd("DELETE FROM Utente  WHERE Username = ? ", $valuesArray);
        }
        echo json_encode($result, true);

    }

    public static function get($parameter_array){
        $dbManager = new dbPool();
        $command = "SELECT * FROM Utente WHERE";
        $final_array = array();

        if($parameter_array == null){
            $resultArray = $dbManager -> queryCmd("SELECT * FROM Utente",null);
            return json_encode($resultArray, true);
        }else{

            foreach ($parameter_array as $single_get){
                print_r($single_get);
                $temp_array = AmministratoreUtility::generateQueryCmd($command, $single_get);
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





    public static function getLogin(){
        $dbManager = new dbPool();
        $resultArray = $dbManager->queryCmd("SELECT * FROM Utente", null);
        return $resultArray;
    }


    /**
     * Funzione che restituisce il numero di record presenti nella tabella Credenziali
     */
    public static function getUserNumbers(){
      /*  $dbManager = new dbPool();
        $userList = $dbManager -> queryCmd("SELECT * FROM Utente",null);
        return count($userList);*/
      echo "";
    }

}