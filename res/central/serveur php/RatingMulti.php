<?php


/**
* This class provide some methods to calculate the ELO rating in a
* game with a lot of players.
* However, the number of points of each player does not impact the final rating, only
* the winning, drawing or losing does .
**/
class ratingmulti
{

    /**
     * @var int The K Factor used, maximum of ELO which can be earned
     */
    const KFACTOR = 16;

    /** 2D arrays **/
    protected $_allExpectedScores;
    protected $_allResults;

    /** 1D arrays **/
    protected $_tabPoints; // Contains the points earned by each player, useful for know who beat who
    protected $_Elo; // ELO before the calculation
    public $_newElo; // Elo after the calculation

   
    public function  __construct($tabElo, $tabPts)
    {
    	if( (count($tabElo) != count($tabPts)) || (count($tabElo) < 2) || (count($tabPts) < 2) )
    	{
    		// Can't process data
    	}
    	else
    	{
	    	$_allExpectedScores = array();
	    	$_allResults = array();
	        $this->_Elo = $tabElo;
	        $this->_tabPoints = $tabPts;
	        $this->_allExpectedScores = $this->_getExpectedScores($this->_Elo);
	        $this->_allResults = $this->_getResults($this->_tabPoints);
	        $this->_newElo = $this->_getNewElo($this->_Elo, $this->_allExpectedScores, $this->_allResults);
    	}
 	}

    public function setNewSettings($tabElo, $tabPts)
    {
    	if( (count($tabElo) != count($tabPts)) || (count($tabElo) < 2) || (count($tabPts) < 2) )
    	{
    		// Can't process data
    	}
    	$_allExpectedScores = array();
    	$_allResults = array();
        $this->_Elo = $tabElo;
        $this->_tabPoints = $tabPts;
        $this->_allExpectedScores = $this->_getExpectedScores($this->_Elo);
        $this->_allResults = $this->_getResults($this->_tabPoints);
        $this->_newElo = $this->_getNewElo($this->_Elo, $this->_allExpectedScores, $this->_allResults);
    }
 	/** Set an array with each confrontation of each player with the values : win=1 draw=0.5 lose=0 **/
    protected function _getExpectedScores($tabElo)
    {
    	$allExpectedScores; // 2D array
		$arr_length = count($tabElo); // Number of players
		for($i = 0; $i < $arr_length; $i++)
		{
		    for($j = 0; $j < $arr_length; $j++)
			{
				if($i == $j) // Same player
					$allExpectedScores[ $i ][ $j ] = 0;
				else
					$allExpectedScores[ $i ][ $j ] = 1 / ( 1 + ( pow( 10 , ( $tabElo[ $j ] - $tabElo[ $i ] ) / 400 ) ) );
			}
		}
		return $allExpectedScores;
    }

    /** Fill a 2D array with the multiple game results (win 1 , lose 0 , draw 0.5) thanks to the ranking **/
    protected function _getResults($tabPoints)
    {
    	$allResults;
    	$arr_length = count($tabPoints); // Number of players
    	for($i = 0; $i < $arr_length; $i++)
		{
		    for($j = 0; $j < $arr_length; $j++)
			{
				if($i == $j) // Same player
					$allResults[ $i ][ $j ] = 0;
				else
				{
					if($tabPoints[ $i ] > $tabPoints[ $j ])
						$allResults[ $i ][ $j ] = 1;
					elseif($tabPoints[ $i ] == $tabPoints[ $j ])
						$allResults[ $i ][ $j ] = 0.5;
					elseif($tabPoints[ $i ] < $tabPoints[ $j ])
						$allResults[ $i ][ $j ] = 0;
				}
			}
		}
		return $allResults;
    }

    // Calculate the new ratings for each player
    protected function _getNewElo($currentElo, $allExpectedScores, $allResults)
    {
    	$newElo;
    	$arr_length = count($currentElo); // Number of players
    	for($i = 0; $i < $arr_length; $i++)
		{
			$pts;
		    for($j = 0; $j < $arr_length; $j++)
			{
				if($i != $j) // Ignore same player
					$pts[] = $currentElo[ $i ] + ( self::KFACTOR * ( $allResults[ $i ][ $j ] - $allExpectedScores[ $i ][ $j ] ) );
			}
			$newElo[$i] = array_sum($pts) / count($pts); // Average of all the ELO points earned or lost
			unset($pts);
		}
		return $newElo;
    }
}	


// EXEMPLE
//joueur 1 a gagné et son elo et 1000 et c'est point de la partie est 10 :
//joueur 2 a perdu et son elo et 1500 et c'est point de la partie est 6 :
$testfef = array(1000,1500);
$testPts = array(10,6);
$ratingmulti = new ratingmulti($testfef,$testPts); 

//Joueur1 = $rating->_newElo['0'];
//Joueur2 = $rating->_newElo['1'];


// EXEMPLE
//joueur 1 a gagné et son elo et 1000 et c'est point de la partie est 10 :
//joueur 2 a perdu et son elo et 1500 et c'est point de la partie est 6 :
//joueur 3 a perdu et son elo et 1300 et c'est point de la partie est 8 :
$testfef = array(1000,1500,1300);
$testPts = array(10,6,8);
$ratingmulti = new ratingmulti($testfef,$testPts); 