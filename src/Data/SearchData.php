<?php

namespace App\Data;

use App\Entity\TypeJobs;

class SearchData 

{
      /**
     * @var int
     */
    public $page = 1;

/**
 * @var string
 */
    public $q='' ;

    
/**
 * @var Experience[]
 */

public $Experience=[];


/**
 * @var Skills[]
 */

public $Skills=[];


 /**
  * @var Title[]
  */
public $Title=[];




/**
 * @var startdate[]
 */

public $startdate =[] ;
/**
 * @var enddate[]
 */

public $enddate =[] ;
/**
 * @var TypeJobs[]
 */

public $TypeJobs =[] ;



/**
 * @var Candidates[]
 */

public $Candidates =[] ;
}



