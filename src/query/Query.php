<?php

namespace query;

use connection\ConnectionFactory;

class Query {


    private $sqlTable;
    private $fields = '*';
    private $where = null;
    private $args = [];
    private $sql = "";

    public static function table(string $table){

        $query = new Query;
        $query->sqlTable = $table;
        return $query;

    }

    public function select(array $fields){

        $this->fields = implode(',',$fields);
        return $this;

    }

    public function where($col, $op, $val){

        if(!is_null($this->where)){

            $this->where .= ' AND '.$col.' '.$op.' ? ';
            $this->args[] = $val;

        } else {

            $this->args[] = $val;
            $this->where = $col.' '.$op.' ?';

        }

        return $this;

    }

    public function get(){


        if(isset($this->where)){

            $this->sql = 'SELECT '. $this->fields . ' FROM '. $this->sqlTable.' WHERE '.$this->where;

        } else {

            $this->sql = 'SELECT '. $this->fields . ' FROM '. $this->sqlTable;

        }

		$pdo = ConnectionFactory::getConnection();
		$rq = $pdo->prepare($this->sql);
		$rq->execute($this->args);
        return $rq->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function delete(){

        if(!is_null($this->where)){

            $this->sql = 'DELETE FROM '. $this->sqlTable .' WHERE '.$this->where;

            $pdo = connectionFactory::getConnection();
            $rq = $pdo->prepare($this->sql);
            $rq->execute($this->args);

        }



	}

	public function insert(array $t) {
		$this->sql = 'insert into '.$this->sqlTable;
		$into = [];
		$values=[];
		foreach($t as $attname => $attval){
			$into[]=$attname;
			$values[]=' ? ';
			$this->args[]=$attval;
		}
		$this->sql.= ' ('. implode(',',$into).') '.'values ('.implode(',',$values).')';
		$pdo = ConnectionFactory::getConnection();
		$stmt = $pdo->prepare($this->sql);
		$stmt->execute($this->args); 
		return (int)$pdo->lastInsertId($this->sqlTable);
	}

   public function update($tab){

       $tabKey = array();
       $tabValue = array();

       foreach ($tab as $key => $values){

           $tabKey[]= "$key=?";
           $this->args[]= $values;

       }


       $tabReverse = array_reverse($this->args);

       $set = implode(',',$tabKey);
       $this->sql = 'UPDATE '.$this->sqlTable.' SET '.$set.' WHERE '.$this->where;

      $pdo = connectionFactory::getConnection();
       $rq = $pdo->prepare($this->sql);
       $rq->execute($tabReverse);

   }
}