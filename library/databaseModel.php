<?php 

abstract class DatabaseModel{

    private static $instance = null;
    protected $pdo;
    protected $campos;

    private static function conectar(){
       try{
            if(self::$instance == null):
                $dsn = "mysql:host=".HOST_DB.";dbname=".BANCO_DB;
                self::$instance = new PDO($dsn, USER_DB, PW_DB, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);	
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            endif;
       }catch (PDOException $e){
            echo "Erro: ". $e->getMessage();	   
       }
       return self::$instance; 
    }

    protected static function getDB(){
       return self::conectar();
    }
    
    protected  function init(){
        $this->pdo = self::conectar();
    }

    protected function allRegister($tabela, $campos = ['*'], $where = [], $orderby = ['nome ASC']) {        
        $CAMPOS = $this->compactCampos($campos);
        $WHERE  = $this->compactWhere($where);
        $ORDER  = $this->compactOrder($orderby);
        $SQL    = "SELECT {$CAMPOS} FROM `{$tabela}` {$WHERE} {$ORDER}";
        $SELECT = $this->pdo->prepare($SQL);
        $SELECT->execute();
        return $SELECT->fetchAll(PDO::FETCH_OBJ);        
    }
    
    protected function saveRegister($tabela, $campos, $where = null) {
        if(!$tabela ||!$campos) return false;
        if($where):
            $CAMPOS  = implode(' = ?, ', array_keys($campos)) . ' = ?';
            $CAMPOSW = implode(' = ?, ', array_keys($where)) . ' = ?';
            $VALUESW = array_values($where);            
            $SQL     = "UPDATE `{$tabela}` SET {$CAMPOS} WHERE {$CAMPOSW}";
            $UPDATE  = $this->pdo->prepare($SQL);
            $CONT    = 1;
            foreach(array_values($campos) as $x): 
                $UPDATE->bindValue("{$CONT}"   , $x);
                $CONT++;
            endforeach;
            foreach(array_values($where) as $x): 
                $UPDATE->bindValue("{$CONT}"   , $x);
                $CONT++;
            endforeach;
            $UPDATE->execute();
            if($UPDATE): return true; endif;
        else:
            $CAMPOS = implode(', ', array_keys($campos));
            $VALUES = $this->compactBindValues(array_values($campos));
            $BIND   = $VALUES['bind'];
            $SQL    = "INSERT INTO `{$tabela}`({$CAMPOS}) VALUES({$BIND})";
            $INSERT = $this->pdo->prepare($SQL);
            $CONT   = 1;
            foreach($VALUES['values'] as $x => $v): 
                $INSERT->bindValue("{$CONT}"   , $v);
                $CONT++;
            endforeach;
            $INSERT->execute();
            if($INSERT) return $this->pdo->lastInsertId();   
        endif;     
        return false;
    }
    
    
    
    /**********************************************************************************************/
    /******************************************TRATATIVAS******************************************/    
    /**********************************************************************************************/
    
    protected function compactWhere($where, $lixeira = 0, $implement = true){        
        $WHERE = '';        
        if($implement) $WHERE = 'WHERE 1';
        if($lixeira != null) $WHERE .= " AND lixeira = {$lixeira} ";        
        if($where && is_array($where))
            foreach($where as $x => $y) 
                $WHERE .= " AND {$x} = '{$y}' ";        
        return $WHERE;            
    }
    
    protected function compactOrder($order){        
        $ORDER = " ORDER BY " . implode(', ', $order);        
        return $ORDER;            
    }
    
    protected function compactCampos($campos){        
        if(is_array($campos)) $campos = implode(', ', $campos);        
        return $campos;            
    }
    
    protected function compactBindValues($campos){ 
        $bind     = '';
        $arrValue = [];
        $cont     = 0;
        
        foreach ($campos as $x):
            $bind = $bind . '?, ';
            $arrValue[$cont] = $x;
            $cont++;
        endforeach;
        
        return ['bind' => substr($bind, 0, -2), 'values' => $arrValue ];   
        
    }
    
}