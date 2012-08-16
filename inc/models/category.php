<?php

/**
 * category.php
 * 
 * wrapper class for Axon
 * 
 * @package Acivity
 * @author Sascha Ohms
 * @author Philipp Hirsch
 * @copyright Copyright 2011, Bugtrckr-Team
 * @license http://www.gnu.org/licenses/lgpl.txt
 *   
 */

namespace models;

class Category extends \Axon
{
    public function __construct()
    {
        $this->sync('Category');
    }
}
