<?php

require_once '/storage/ssd3/867/5238867/public_html/script/databaseAccess/dbInstance.php';

require 'modelUtility/AmministratoreUtility.php';
require 'modelUtility/CredenzialiUtility.php';
require 'modelUtility/SensoreUtility.php';
require 'modelUtility/RilevazioneUtility.php';
require 'modelUtility/ClienteUtility.php';
require 'modelUtility/ImpiantoUtility.php';
require 'modelUtility/TerzaParteUtility.php';
require 'modelUtility/PrivilegioUtility.php';

class MainUtility
{

    public function __construct()
    {
    }

    public static function create($nameEntity, $jsonParsed)
    {
        switch ($nameEntity) {

            case EntityNames::AMMINISTRATORE:
                AmministratoreUtility::create($jsonParsed);

                break;

            case EntityNames::CLIENTE:
                ClienteUtility::create($jsonParsed);
                break;

            case EntityNames::CREDENZIALI:

                CredenzialiUtility::create($jsonParsed);
                break;

            case EntityNames::IMPIANTO:
                ImpiantoUtility::create($jsonParsed);
                break;

            case EntityNames::RILEVAZIONE:
                RilevazioneUtility::create($jsonParsed);
                break;

            case EntityNames::SENSORE:
                SensoreUtility::create($jsonParsed);
                break;
            case EntityNames::TERZAPARTE:
                TerzaParteUtility::create($jsonParsed);
                break;
            case EntityNames::PRIVILEGIO:
                PrivilegioUtility::create($jsonParsed);
                break;
        }

    }

    public static function delete($nameEntity, $jsonParsed)
    {
        switch ($nameEntity) {
            case EntityNames::AMMINISTRATORE:
                AmministratoreUtility::delete($jsonParsed);
                break;
            case EntityNames::CLIENTE:
                ClienteUtility::delete($jsonParsed);
                break;
            case EntityNames::CREDENZIALI:
                CredenzialiUtility::delete($jsonParsed);
                break;
            case EntityNames::IMPIANTO:
                ImpiantoUtility::delete($jsonParsed);
                break;
            case EntityNames::RILEVAZIONE:
                RilevazioneUtility::delete($jsonParsed);
                break;
            case EntityNames::SENSORE:
                SensoreUtility::delete($jsonParsed);
                break;
            case EntityNames::TERZAPARTE:
                TerzaParteUtility::delete($jsonParsed);
                break;
        }

    }

    public static function update($nameEntity, $jsonParsed)
    {
        switch ($nameEntity) {
            case EntityNames::AMMINISTRATORE:
                AmministratoreUtility::update($jsonParsed);
                break;
            case EntityNames::CLIENTE:
                ClienteUtility::update($jsonParsed);
                break;
            case EntityNames::CREDENZIALI:
                CredenzialiUtility::update($jsonParsed);
                break;
            case EntityNames::IMPIANTO:
                ImpiantoUtility::update($jsonParsed);
                break;
            case EntityNames::SENSORE:
                SensoreUtility::update($jsonParsed["stato"],$jsonParsed["id"]);
                break;
            case EntityNames::TERZAPARTE:
                TerzaParteUtility::update($jsonParsed);
                break;
        }

    }

    /**
     * Funzione che restituisce tutti i record di una entità.
     * @param $nameEntity   il nome dell'entità
     * @param $array    da definire
     * @return string   JSON
     */
    public static function get($nameEntity, $jsonParsed)
    {
        switch ($nameEntity) {
            case EntityNames::AMMINISTRATORE:
                return AmministratoreUtility::get($jsonParsed);
                break;
            case EntityNames::CLIENTE:
                return ClienteUtility::get($jsonParsed);
                break;
            case EntityNames::CREDENZIALI:
                return CredenzialiUtility::get($jsonParsed);
                break;
            case EntityNames::IMPIANTO:
                return ImpiantoUtility::get($jsonParsed);
                break;
            case EntityNames::RILEVAZIONE:
                return RilevazioneUtility::get($jsonParsed);
                break;
            case EntityNames::SENSORE:
                return SensoreUtility::get($jsonParsed);
                break;
            case EntityNames::TERZAPARTE:
                return TerzaParteUtility::get($jsonParsed);
                break;

        }

    }

    /**
     * Funzione che restituisce una data in strina col formato 'dd/mm/yyyy' da un valore di millisecondi
     * @param $seconds       i millisecondi
     * @return string        'dd/mm/yyyy'
     */
    public static function getDateByMilliseconds($seconds)
    {

        $dbFormatDate = 'Y-m-d';
        return date($dbFormatDate, $seconds / 1000);
    }

    /**
     * Funzione che restituisce una data in strina col formato 'dd/mm/yyyy' da un valore di millisecondi
     * @param $seconds       i millisecondi
     * @return string        'dd/mm/yyyy'
     */
    public static function getHourByMilliseconds($seconds)
    {

        return date('H:i:s', $seconds / 1000);
    }

    /**
     * Funzione che restituisce un JSON Object con 'result' come property.
     * Result è un boolean che indica se è la prima volta che si interagisce col sistema o meno.
     */
    public static function isFirstTime()
    {
        $result = array();
        $result["result"] = CredenzialiUtility::getUserNumbers() == 0;
        return  json_encode($result,true);
    }

    /**
     * Funzione di Log-in che restituisce un JSON Object con 'ruolo' come property
     * isNull è una stringa che contiene il ruolo dell'utente autenticato.
     */

    public static function login($parsedList){
        $isNull = null;
        $array = array();
        $dbManager = new dbPool();


        $result = CredenzialiUtility::getLogin();


        foreach ($parsedList as $singleRecord){
               $array['Username'] = $singleRecord['Username'];
                $array['Password'] = $singleRecord['Password'];
        }

        foreach ($result as $singleRecord) {
            if($array['Username'] == $singleRecord['Username'] && password_verify($array['Password'], $singleRecord['Password'])) {

                $isNull = $singleRecord['Ruolo'];

                return $isNull;
            }
        }
        return $isNull;
    }

    public static function trova($parsedList){
        $isNull = null;
        $array = array();
        $dbManager = new dbPool();


        $result = CredenzialiUtility::getLogin();


        foreach ($parsedList as $singleRecord){
            $array['Username'] = $singleRecord['Username'];
        }

        foreach ($result as $singleRecord) {
            if($array['Username'] == $singleRecord['Username']) {

                $isNull = $singleRecord['Ruolo'];

                return $isNull;
            }
        }
        return $isNull;
    }



}

?>