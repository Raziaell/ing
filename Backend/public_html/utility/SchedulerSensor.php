<?php
require 'mainUtility.php';
require 'modelUtility/EntityNames.php';

//Recupero la lista di tutti i sensori
$result_list = json_decode(MainUtility::get(EntityNames::SENSORE,null),true);

foreach ($result_list as $singleSensor) {

    //Id sensore corrente
    $idSensor = $singleSensor["Id"];
    
    //Se il sensore + attivo
    if($singleSensor["Stato"] == 1){

        $currentDate = date('Y-m-d', time());
        $currentHour = date('H:i:s', time());

        //Array per effettuare l'inserimento
        $recordToInsert = array();

        $messageError = "";
        $value = 0;

        //Genero un numero random per generare casualmente un errrore quando tale numero è uguale a 5
        $randomInteger = rand ( 0 , 25 );
        if($randomInteger == 5){
            $messageError = "ERROR FOUND";
            //Se c'è l'errore devo aggioranre lo stato del sensore
            $object = array(
                "stato" => 0,
                "id" => $idSensor,
            );
            MainUtility::update(EntityNames::SENSORE,$object);
        } else {
            $value = generateDetectionValue($singleSensor["Tipo"]);
        }

        //L'array per effettuare l'inserimento
        $singleRecord = array(
            "dataOra" => time() * 1000,
            "valore" => $value,
            "errore" => $messageError,
            "sensoreId" => $idSensor
        );
        array_push($recordToInsert,$singleRecord);
        MainUtility::create(EntityNames::RILEVAZIONE,$recordToInsert);
    }

}

/**
 * Funzione che genera un valore di una rilevazione Random in base alla tipologia del sensore
 * @param $sensorType il tipo del sensore
 * @return float|int   il valore random generato
 */
function generateDetectionValue($sensorType){

    if(strcasecmp($sensorType,"umidità")){
        $randomInteger = rand ( 0 , 100 );
        return $randomInteger;
    } else if(strcasecmp($sensorType,"temperatura")){
        $randomInteger = rand ( 0 , 50 );
        return $randomInteger;
    } else if(strcasecmp($sensorType,"precipitazioni")){
        $randomInteger = rand ( 0 , 100 ) / 100;
        return $randomInteger;
    } else if(strcasecmp($sensorType,"pressione")){
        $randomInteger = rand ( 900 , 1050 );
        return $randomInteger;
    } else if(strcasecmp($sensorType,"vento")){
        $randomInteger = rand ( 0 , 100 );
        return $randomInteger;
    } else if(strcasecmp($sensorType,"inquinamento")){
        $randomInteger = rand ( 0 , 500 );
        return $randomInteger;
    }
}

?>