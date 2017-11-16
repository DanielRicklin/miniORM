<?php

namespace models;

class Article extends \models\Model{

    protected static $table = 'article';
    protected static $primaryKey = 'id';

    public function categorie(){
		return $this->belongs_to("\models\Categorie", 'id_categ');
	}

}