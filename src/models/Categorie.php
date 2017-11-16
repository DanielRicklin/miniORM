<?php

namespace models;

class Categorie extends \models\Model
{
    protected static $table = 'categorie';
    protected static $primaryKey = 'id';

    public function articles(){
        return $this->has_many('\models\Article','id_categ');
    }
}