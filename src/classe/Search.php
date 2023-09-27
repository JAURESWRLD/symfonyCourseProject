<?php

namespace App\classe;
use App\Entity\Category;

class Search 
{   

    /**
     * @var string
     */
    public $string = '';

    /**
     * @var Category[]
     */
    public $categories =[];

    /**
     * Summary of __toString
     * @return string
     */
    public function __toString(){
        // to show the name of the Category in the select
        return $this->string ;
    }

}