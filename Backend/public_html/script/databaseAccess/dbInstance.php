<?php
require_once 'configFile.php';

class dbPool
{


    /**
     * dbPool constructor.
     */
    public function __construct()
    {

        try {
            $this->connect();
        } catch (PDOException $error) {

            echo $error->getMessage() . '<br>';
            echo 'Errore con la connessione al DB:';

        }
    }

    /**
     * Method that creates a DB instance
     */
    private function connect()
    {

        $this->dbInstance = new PDO('mysql:host=' . ConfigurationDB::HOST . ';dbname=' . ConfigurationDB::NAME_DB . ';charset=utf8mb4', ConfigurationDB::USERNAME, ConfigurationDB::PASSWORD);

    }

    /**
     * Method to query the db
     * @param  $string_query      the SQL command
     * @param  $parameter_array   array with WHERE condition fields
     * @return $results           result array
     */
    public function queryCmd($string_query, $parameter_array)
    {

        try {

            $stmt = $this->dbInstance->prepare($string_query);

            if ($parameter_array == null) {
                $stmt->execute();

            } else {
                $stmt->execute($parameter_array);
            }

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $error) {

            echo $error->getMessage() . '<br>';
            echo 'Errore nella query';
        }

    }



    /**
     * Method to update a db table
     * @param $string_query        the SQL command
     * @param $parameter_array     array with SET fields and WHERE condition fields
     * @return  true if there are updated rows;else false
     **/
    public function updateCmd($string_query, $parameter_array)
    {

        try {

            $stmt = $this->dbInstance->prepare($string_query);

            if ($parameter_array == null) {
                $stmt->execute();

            } else {
                $stmt->execute($parameter_array);
            }

            // Se uguale a zero vuol dire che nessuna riga è stata aggiornata
            if ($affected_rows = $stmt->rowCount() != 0)
                return true;
            else
                return false;


        } catch (PDOException $error) {

            echo $error->getMessage() . '<br>';
            echo 'Errore nel comando di UPDATE';
        }

    }


    /**
     * Method to insert a row in db table
     * @param $string_query            the SQL command
     * @param $values_array            array with row fields to insert
     */

    public function insertCmd($string_query, $values_array)
    {
        try
        {
            $stmt = $this->dbInstance->prepare($string_query);
            if ($values_array == null) {
                $stmt->execute();

            } else {
                return $stmt->execute($values_array);

            }

        } catch (PDOException $error) {

            echo $error->getMessage() . '<br>';
            echo 'Errore nel comando di INSERT';
        }


    }

    public function deleteCmd($string_query, $parameter_array)
    {

        try {


            $stmt = $this->dbInstance->prepare($string_query);

            if ($parameter_array == null) {
                $stmt->execute();

            } else {
                return $stmt->execute($parameter_array);
            }

        } catch (PDOException $error) {

            echo $error->getMessage() . '<br>';
            echo 'Errore nel comando di DELETE';
        }


    }


    private static function getKeysArray($convertedArray)
    {


        $obj_keys_array = array();

        while ($key = current($convertedArray)) {

            $temp = array();
            foreach (array_keys($key) as $value) {
                array_push($temp, $value);
            }

            array_push($obj_keys_array, $temp);
            next($convertedArray);
        }
        return $convertedArray;
    }

    private static function getAttributesName( $convertedArray)
    {

        $final_array = array();
        $count = 0;
        $obj_key_array = self::getKeysArray($convertedArray);


        foreach ($obj_key_array as $set_key) {

            $str = "";
            $array = array();
            $current_array_key = array_keys($set_key);



            $array['values'] = array();

            foreach ($current_array_key as $obj_key) {

                array_push($array['values'], $convertedArray[$count][$obj_key]);
                if ($obj_key != end($current_array_key)) {
                    $str .= $obj_key;
                    $str .= ",";

                } else
                    $str .= $obj_key;

            }

            $count = $count + 1;

            $array['set_attr'] = $str;
            print_r($array);
            array_push($final_array, $array);

        }

        return $final_array;

    }





}

?>