<?php

#
#  Caculate the Shannon entropy.
#  Return the entropy value for the elements
#
function entropy($elements){
   $sum = 0;
   $result = 0;
   foreach ($elements as $element){
   	  if ($element < 0){
   	  		echo  "ERROR: Should not have negative count for entropy calculation";
   	  }
   	  if ($element > 0){
   	      $result += $element * log($element);
   	      $sum += $element;
   	  }
   	}
   	$result -= $sum * log($sum);
	return -$result;
}

function logLikelihoodRatio($k11, $k12, $k21, $k22){
    $rowEntropy = entropy(array($k11, $k12)) + entropy(array($k21, $k22));
    $columnEntropy = entropy(array($k11, $k21)) + entropy(array($k12, $k22));
    $matrixEntropy = entropy(array($k11, $k12, $k21, $k22));
    if ($rowEntropy + $columnEntropy > $matrixEntropy){
    	return 0;
    }
    return 2 * ($matrixEntropy - $rowEntropy - $columnEntropy);
}

#echo logLikelihoodRatio(150, 782, 12443, 14294293);

#echo logLikelihoodRatio(276, 1002, 26036, 229785);
?>