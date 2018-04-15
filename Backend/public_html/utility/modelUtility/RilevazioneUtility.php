<?php
header('Access-Control-Allow-Origin: *');


class RilevazioneUtility
{

    public static function create($newRecords)
    {

        $dbManager = new dbPool();
        foreach ($newRecords as $singleRecord) {

            $dateValue = (string)MainUtility::getDateByMilliseconds($singleRecord['dataOra']);
            $hourValue = (string)MainUtility::getHourByMilliseconds($singleRecord['dataOra']);
            $valuesArray = array(
                $dateValue,
                $singleRecord['valore'],
                $singleRecord['errore'],
                $singleRecord['sensoreId'],
                $hourValue
            );

            $dbManager->insertCmd("INSERT INTO Rilevazione ( Data, Valore, Errore , SensoreId , Ora) VALUES (?,?,?,?,?)", $valuesArray);

        }
    }

    public static function delete($newRecords)
    {
/*        $dbManager = new dbPool();
        foreach ($newRecords as $singleRecord){
            $userValues = array(
                $singleRecord[]
            );
        }*/


    }

    public static function get()
    {
        $dbManager = new dbPool();
        $resultArray = $dbManager->queryCmd("SELECT * FROM Rilevazione", null);
        return json_encode($resultArray, true);
    }

    public static function detectionGet($newRecords)
    {
        $dbManager = new dbPool();
        foreach ($newRecords as $singleRecord) {
            $valuesArray = array(
                $singleRecord['Id']
            );
            $resultArray = $dbManager->queryCmd("SELECT * FROM Rilevazione INNER JOIN Sensore ON SensoreId = Id where ImpiantoId = ?", $valuesArray);
        }

        return json_encode($resultArray, true);
    }
}