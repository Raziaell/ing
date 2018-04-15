<?php

require_once 'utility/modelUtility/EntityNames.php';
require 'script/Slim/Slim.php';
require 'utility/mainUtility.php';
date_default_timezone_set('Europe/Rome');
\Slim\Slim::registerAutoloader();


$app = new \Slim\Slim(array('debug' => true));

/**
 * Funzione che stampa un JSON Object con 'result' come property.
 * Result è un boolean che indica se è la prima volta che si interagisce col sistema o meno.
 */

$app->get('/isFirstTime', function () {

    echo MainUtility::isFirstTime();
});

/** LOG-IN */


$app->post('/login',  function () use ($app){
    $json = $app->request->getBody();


        $parsedList = json_decode($json,true);

        $result = array();
        $result["Ruolo"] = MainUtility::login($parsedList);

        if($result["Ruolo"] == null){
            $result["Trovato"]= false;
            echo json_encode($result,true);
        }else{

            $result["Trovato"]= true;
            echo json_encode($result,true);
        }
});

/** AMMINISTRATORE */

//READ
$app->post('/amministratoreGet',  function () use ($app) {
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    echo MainUtility::get(EntityNames::AMMINISTRATORE, $parsedList);
});

//INSERT
$app->post('/amministratorePost', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    MainUtility::create(EntityNames::CREDENZIALI,$parsedList);
    MainUtility::create(EntityNames::AMMINISTRATORE,$parsedList);
});

//UPDATE
$app->post('/amministratorePut', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    MainUtility::update(EntityNames::AMMINISTRATORE,$parsedList);
});

//DELETE
$app->post('/amministratoreDelete', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    MainUtility::delete(EntityNames::CREDENZIALI,$parsedList);

});


/** CLIENTE */
//READ
$app->post('/clienteGet', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    echo MainUtility::get(EntityNames::CLIENTE, $parsedList);
});

//INSERT
$app->post('/clientePost', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    MainUtility::create(EntityNames::CREDENZIALI,$parsedList);
    MainUtility::create(EntityNames::CLIENTE,$parsedList);
});

//UPDATE
$app->post('/clientePut', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    MainUtility::update(EntityNames::CLIENTE,$parsedList);
});

//DELETE
$app->post('/clienteDelete', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    MainUtility::delete(EntityNames::CREDENZIALI,$parsedList);

});

/** TERZA PARTE */
//READ
$app->post('/getThirdParty', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    echo MainUtility::get(EntityNames::TERZAPARTE, $parsedList);
});

//INSERT
$app->post('/createThirdParty', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);


    $userValues = array(
        "Username" => $parsedList["Username"],
        "Password" => $parsedList["Password"],
        "Ruolo" => "ThirdParty"
    );
    MainUtility::create(EntityNames::CREDENZIALI,array($userValues));

    $thirdPartyValues = array(
        "Username" => $parsedList["Username"],
        "ClienteId" => $parsedList["ClienteId"]
    );
    MainUtility::create(EntityNames::TERZAPARTE,array($thirdPartyValues));

    $privilegioValues = array(
        "Username" => $parsedList["Username"],
        "Impianti" =>$parsedList["Impianti"]
    );
    MainUtility::create(EntityNames::PRIVILEGIO,array($privilegioValues));
});

//INSERT
$app->post('/createPrivilegio', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
});

//UPDATE
$app->post('/updateThirdParty', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    MainUtility::update(EntityNames::CLIENTE,$parsedList);
});

//DELETE
$app->post('/deleteThirdParty', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    MainUtility::delete(EntityNames::TERZAPARTE,$parsedList);


});

/** SENSORE */
//READ
$app->post('/sensoreGet', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    echo MainUtility::get(EntityNames::SENSORE, $parsedList);
});

//INSERT
$app->post('/sensorePost', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    MainUtility::create(EntityNames::SENSORE,$parsedList);
});

//DELETE
$app->post('/sensoreDelete', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    MainUtility::delete(EntityNames::SENSORE,$parsedList);
});

/** RILEVAZIONE **/

//READ
$app->post('/rilevazioneGet', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    echo MainUtility::get(EntityNames::RILEVAZIONE,$parsedList);
});

//DELETE
$app->post('/rilevazioneDelete', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    MainUtility::delete(EntityNames::RILEVAZIONE,$parsedList);
});

/** IMPIANTO */

//READ
$app->post('/impiantoGet', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    echo MainUtility::get(EntityNames::IMPIANTO,$parsedList);
});

//INSERT
$app->post('/impiantoPost', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    MainUtility::create(EntityNames::IMPIANTO,$parsedList);
});

//UPDATE
$app->post('/impiantoPut', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    MainUtility::update(EntityNames::IMPIANTO,$parsedList);
});

//DELETE
$app->post('/impiantoDelete', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    MainUtility::delete(EntityNames::IMPIANTO,$parsedList);
});

//CHANGE_PASSWORD
$app->post('/credenzialiPut', function () use ($app){
    $json = $app->request->getBody();
    $parsedList = json_decode($json,true);
    MainUtility::update(EntityNames::CREDENZIALI,$parsedList);
});

$app->post('/idGet', function () use ($app){
        $json = $app->request->getBody();
        $parsedList = json_decode($json,true);
        $result = ClienteUtility::idGet($parsedList);
        echo $result;
});

$app->post('/getDetectionByPlant', function () use ($app){
    $json = $app->request->getBody();
    $parsedValue = json_decode($json,true);
    $result = RilevazioneUtility::detectionGet($parsedValue);
    echo $result;
});

$app->post('/trovaUtente', function () use ($app){
    $json = $app->request->getBody();
    $parsedValue = json_decode($json,true);

    $result = array();
    $result["Ruolo"] = MainUtility::trova($parsedValue);

    if($result["Ruolo"] == null){
        $result["Trovato"]= false;
        echo json_encode($result,true);

    }elseif($result["Ruolo"] == "Admin"){
        echo MainUtility::get(EntityNames::AMMINISTRATORE, $parsedValue);
    }elseif($result["Ruolo"] == "Cliente"){
        echo MainUtility::get(EntityNames::CLIENTE, $parsedValue);
    }else{
        MainUtility::create(EntityNames::TERZAPARTE,$parsedValue);
    }

});

$app->run();

?>