<?php 

namespace EMPRESA\classes;

use PDO;
use PDOException;

class Database
{    
    private $db_server;
    private $db_name;
    private $db_charset;
    private $db_username;
    PRIVATE $db_password;

    public function __construct($db_server, $db_name, $db_charset, $db_username, $db_password) {
        $this->db_server = $db_server;
        $this->db_name = $db_name;
        $this->db_charset = $db_charset;
        $this->db_username = $db_username;
        $this->db_password = $db_password;
    }
    
    //==================================================================
    public function EXE_QUERY($query, $parameters = null, $debug = true, $close_connection = true){
        //executes a query the the database (SELECT)
        $results = null;

        //connection
        $connection = new PDO(
            'mysql:host='.$this->db_server.
            ';dbname='.$this->db_name.
            ';charset='.$this->db_charset,
            $this->db_username,
            $this->db_password,
            array(PDO::ATTR_PERSISTENT => true));      
            
        if($debug){
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }

        //execution
        try {
            if ($parameters != null) {
                $gestor = $connection->prepare($query);
                $gestor->execute($parameters);
                $results = $gestor->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $gestor = $connection->prepare($query);
                $gestor->execute();
                $results = $gestor->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {        
            return false;
        }

        //close connection
        if ($close_connection) {
            $connection = null;
        }

        //returns results
        return $results;
    }

    //==================================================================
    public function EXE_NON_QUERY($query, $parameters = null, $debug = true, $close_connection = true){
        //executes a query to the database (INSERT, UPDATE, DELETE)

        //connection
        $connection = new PDO(
            'mysql:host='.$this->db_server.
            ';dbname='.$this->db_name.
            ';charset='.$this->db_charset,
            $this->db_username,
            $this->db_password,
            array(PDO::ATTR_PERSISTENT => true));   

        if($debug){
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        
        //execution
        $connection->beginTransaction();
        try {
            if ($parameters != null) {
                $gestor = $connection->prepare($query);
                $gestor->execute($parameters);
            } else {
                $gestor = $connection->prepare($query);
                $gestor->execute();
            }
            $connection->commit();
        } catch (PDOException $e) {            
            $connection->rollBack();
            return false;
        }

        //close connection
        if ($close_connection) {
            $connection = null;
        }
        
        return true;
    }
}