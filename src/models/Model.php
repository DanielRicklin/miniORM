<?php

namespace models;

use \query\Query as Query;

Abstract class Model {
    protected static $table;
    protected static $primaryKey = 'id';
    protected $_v = [];

    public function __construct(array $t = null){
        if(!is_null($t)) {
            $this->_v = $t;
        }
    }

    public function __get($attr_name){
        if (array_key_exists($attr_name, $this->_v)){
            return $this->_v[$attr_name];
        }else{
            return $this->$attr_name();
        }
    }
    
    public function __set($attr_name,$valeur){
        $this->_v[$attr_name]=$valeur;
    }

    public function insert(){
        $query = Query::table(static::$table);
        $this->_v[static::$primaryKey] = $query->insert($this->_v);
    }

    public function delete(){
        if(isset($this->_v[static::$primaryKey])){
            $query = Query::table(static::$table);
            $query->where(static::$primaryKey, '=', $this->_v[static::$primaryKey])->delete();
        }
    }

    public static function all(){
        $query = Query::table(static::$table)->get();
        $tab = [];
        foreach($query as $val){
            $obj = new static($val);
            $tab[] = $obj;
        }
        return $tab;
    }

    public static function find($id, array $tab_column = null){
        $query = Query::table(static::$table);

        if(!is_null($tab_column)){
            $query = $query->select($tab_column);
        }

        if(gettype($id)=="array"){
            if(gettype($id[0])=="array"){
				foreach($id as $tab){
					$query = $query->where($tab[0],$tab[1],$tab[2]);
				}
			}else{
				$query = $query->where($id[0],$id[1],$id[2]);
			}
			
		}else{
			$query = $query->where(static::$primaryKey,'=',$id);
        }
        
        $query = $query->get();

        $tab = [];
        foreach($query as $val){
            $obj = new static($val);
            $tab[] = $obj;
        }
        return $tab;
    }
    

    public static function first($id, array $tab_column = null){
        $query = Query::table(static::$table);

        if(!is_null($tab_column)){
            $query = $query->select($tab_column);
        }

        if(is_array($id)){
            if(is_array($id[0])){
				foreach($id as $tab){
					$query = $query->where($tab[0],$tab[1],$tab[2]);
				}
			}else{
				$query = $query->where($id[0],$id[1],$id[2]);
            }
            $query = $query->get();
			
		}else{
			$query = $query->where(static::$primaryKey,'=',$id)->get();
        }
        
        

        $tab = [];
        foreach($query as $val){
            $obj = new static($val);
            $tab[] = $obj;
        }
        return $tab[0];
    }

    public function belongs_to($nom, $column){
        $result=new $nom();
		$result=$result::first($this->$column);
		return $result;
    }
	
	public function has_many($nom, $column){
		$result=new $nom();
		$key=static::$primaryKey;
		$result=$result::find([$column,'=',$this->$key]);
		return $result;
	}
}