<?php

class PrivilegioUtility
{
    public static function create($newRecords){
        $dbManager = new dbPool();



        foreach ($newRecords as $singleRecord) {

            //PER OGNI IMPIANTO ID INSERISCO
            foreach($singleRecord["Impianti"] as $idImpianto){


                $userValues = array(
                    $idImpianto,
                    $singleRecord['Username']
                );
                $dbManager->insertCmd("INSERT INTO Privilegio (  ImpiantoId, Username ) VALUES (?,?)", $userValues);
            }

        }

    }

    public static function get($parameter_array){
        $dbManager = new dbPool();
        $command = "SELECT * FROM Privilegio WHERE";
        $final_array = array();

        if($parameter_array == null){
            $resultArray = $dbManager -> queryCmd("SELECT * FROM Privilegio",null);
            return json_encode($resultArray, true);
        }else{

            foreach ($parameter_array as $single_get){
                $temp_array = AmministratoreUtility::generateQueryCmd($command, $single_get);
                $resultArray = $dbManager->queryCmd($temp_array["command"], $temp_array["values"]);
                array_push($final_array,$resultArray);

            }

            return json_encode($final_array, true);
        }

    }



}