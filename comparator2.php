<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Comparator Results</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
<link href="style.css" rel="stylesheet" type="text/css"/>

<!-- Begin IE Fixes (Don't touch unless you know what you're doing!)-->
	<!--[if IE]>
	<link type="text/css" href="ie.css" rel="stylesheet" />
	<![endif]-->
<!-- End of IE fixes -->

</head>
<body>
<div id="container">
	<div id="navigation">
		<ul>
				<li><a href="index.php">Ngram Analyzer</a></li>
		<li><a href="comparator.php">Text Comparator</a></li>

		<li><a href="http://guidetodatamining.com">Guide to Data Mining</a></li>
		
		</ul>
	</div>
		<div id="header">
		  <h1>Comparator Results</h1>
		  <h2>analyze your texts.</h2>
		</div>
				<div id="wrapper">
				<div id="content">
					<h1>Analysis Complete</h1>
					
		
    
    <?php







	       #####
	      #####
         #####           ANALYSIS FUNCTIONS
        #####
       #####



include('loglikelihood.php');

$ngrams = array();
#$ngrams['fo42haj'] = 0;

   function separatePun($word){
  
      # separate punctuation from word. so treat punctuation as separate tokens
  	  $pat1 = "/^[\"'\(\[<]/";
  	  $pat2 = "/[\"'\)\]\.\!\?;\:,]$/";
  	  $result = array();
      while(preg_match($pat1, $word)){
          array_push($result, substr($word, 0, 1));
      	  $word = substr($word, 1);
      	  
      }
      $res2 = array();
      
      #echo"<p>$pat2</p>";
      while(preg_match($pat2, $word)){
          array_push($res2, substr($word, -1));
      	  $word = substr($word, 0, -1);
      	  
      }
      
      $pos = strpos($word, "'");
      if ($pos === false){ 
      	  array_push($result, $word);
      }
      else {
      	array_push($result, substr($word, 0, $pos));
      	array_push($result, substr($word, $pos));
      }
      $res2 = array_reverse($res2);
      foreach($res2 as $item){
      	array_push($result, $item);
      }
      
      return $result;
  
  }
function deletePun($word){
  
  	  $orig = $word;
      # separate punctuation from word. so treat punctuation as separate tokens
  	  $pat1 = "/^[\"'\(\[<]/";
  	  $pat2 = "/[\"'\)\]\.\!\?;\:,]$/";
  	  $result = array();
      while(preg_match($pat1, $word)){
      	  $word = substr($word, 1);      	  
      }
      while(preg_match($pat2, $word)){
      	  $word = substr($word, 0, -1);
      	  
      }
      if ($word == ''){
          $word = $orig;
      }
      $result = array($word);
      return $result;
  
  }
  
   function processLine2($line){
       global $uni2;
       global $total2;
       global $unigrams;
  	   $words = preg_split('/\s+/', $line);
  	   #$ngrams = array();
       foreach($words as $word){
    	 $wordcomponents = deletePun($word);
    	 
    	 #$current = $word;
    	 foreach($wordcomponents as $current){
    	      #echo "X$current ";
    	      $total2 = $total2 + 1;
    	      if (isset($uni2[$current])){
    	          $uni2[$current] = $uni2[$current] + 1;
    	      }
    	      else {
    	         $uni2[$current] = 1;
    	      }
    	    
    	 }
       }
  
  }
 

  function processLine($line){
       global $uni1;
       global $total;
       global $unigrams;
  	   $words = preg_split('/\s+/', $line);
  	   #$ngrams = array();
       foreach($words as $word){
    	 $wordcomponents = deletePun($word);
    	 
    	 #$current = $word;
    	 foreach($wordcomponents as $current){
    	      #echo "X$current ";
    	      $total = $total + 1;
    	      if (isset($uni1[$current])){
    	          $uni1[$current] = $uni1[$current] + 1;
    	      }
    	      else {
    	         $uni1[$current] = 1;
    	      }
    	    
    	 }
       }
  
  }

     ###
    ###   BY FREQUENCY
   ###
   function byFrequency(){
       
       global $uni1;
       global $total;
       global $thetext;
       
  	   if (is_array($thetext) == true)
       {
  	       foreach($thetext as $aline){
    	      processLine($aline);
           }
       }
       else {
          if (substr($thetext, 0, 4) == 'http') {
      		 $urls = preg_split('/\s+/', $thetext);
      		 foreach($urls as $url){
      		 	if (substr($url, 0, 4) == 'http') {
      		 		#echo "<p>URL: $url</p>";
      	    		processLine(file_get_contents($url));
      	    	}
      	     }
          }
          else{
      	     processLine($thetext);
          }
       }
  
   }
   
     ###
    ###   BY FREQUENCY
   ###
   function byFrequency2(){
       
       global $uni2;
       global $total2;
       global $reference;
       
  	   if (is_array($reference) == true)
       {
  	       foreach($reference as $aline){
    	      processLine2($aline);
           }
       }
       else {
          if (substr($reference, 0, 4) == 'http') {
      		 $urls = preg_split('/\s+/', $reference);
      		 foreach($urls as $url){
      		    #echo "<p>$url</p>";
      	    	processLine2(file_get_contents($url));
      	     }
          }
          else{
      	     processLine2($reference);
          }
       }
  
   }
   
      ###
     ###  USING LOG LIKELIHOOD
    ###
    function ll($w2, $w1, $w1w2, $total){
      #echo "<p>$w2 $w1 $w1w2 $total</p>";
      $e1 = $w1 * ($w2 + $w1w2) / ($w1 + $total);
      
      $e2 = $total * ($w1w2 + $w2) / ($w1 + $total);
      #echo"<p>E1: $e1</p><p>E2: $e2</p>";
      if (($e1 != 0) and ($e2 != 0)) {
      	$g2 = 2 * (($w1w2 * log(($w1w2 / $e1), 2)) + ($w2 * log(($w2 / $e2), 2)));
      	return $g2;
      }
      else{
      	return 0;
      }
    }
    
    
       ###
      ###    MUTUAL INFORMATION
     ###
    function mi($x, $y, $xy, $tot){
       if ($xy < 5){
           return 0;
       }
       $nom = $xy / $tot;
       $det = ($x / $tot) * ($y / $tot);
       return  log(($non / $det), 2);
    
    }
    

    ###
   ###     
  ###    M A I N
 ###
### 

if (isset($_GET['ex'])) {
    #$server = 'http://localhost/ngramAnalyzer';
    $server = 'http://guidetodatamining.com/ngramAnalyzer';
    $text = $_GET['ex'];
    if ($text== 'walden'){
    	
    	$thetext = "$server/walden.txt";
    	$reference = "$server/moby.txt";
    }
    elseif ($text== 'lotus'){
    	
    	$thetext = "$server/lotus.txt";
    	$reference = "$server/walden.txt";
    }
    elseif ($text== 'lotus2'){
    	
    	$thetext = "$server/lotus.txt";
    	$reference = "$server/moby.txt";
    }
}
else {
#echo "<p>EX</p>";
	$thetext = $_POST['mytext'];
	$reference = $_POST['reference'];
}
$total2 = 0;
##########
##  I am editing here
####
   $n = $_POST['gram'];
   $punc = $_POST['punctuation'];
   $method = $_POST['method'] ;

#echo $thetext;
$uni1 = array();
$uni2 = array();
$dir = array();
$total = 0;

byFrequency();
byFrequency2();
  $len1 = count($uni1);
  $len2 = count($uni2);
  
  #echo "<p>LEN $len1 $len2</p>";
  // echo "<p>TOTAL $total $total2</p>";
//   echo "<p>the ".$uni1['the'].'     '.$uni2['the']."</p>";
//   echo "<p>Buddha ".$uni1['Buddha'].'     '.$uni2['Buddha']."</p>";
//   echo "<p>Compassion ".$uni1['compassion'].'     '.$uni2['compassion']."</p>";
//   echo "<p>".ll($uni2['compassion'], $total, $uni1['compassion'],  $total2)."</p>";
//   echo "<p>".ll($uni2['compassion'], $total, 0,  $total2)."</p>";
//   echo "<p>".ll($uni2['the'], $total, $uni1['the'],  $total2)."</p>";
   echo "<p>Total number of tokens in first text: $total   &nbsp;&nbsp;&nbsp; In second: $total2</p>";
   echo "<p>Count column refers to number of occurrences of the word in the first text. ";
   echo "Log Likelihood in a black font indicates the word was used more frequently in the first corpus than in the second; red font indicates it was less frequently used.</p>";
  arsort($uni1, SORT_NUMERIC);
    $len1 = count($uni1);

    #echo "<p>LEN $len1 $len2</p>";
  # okay now compute log likelihood.
  $log = array();
  echo "<table><tr><th>Word</th><th>Count</th><th>Log Likelihood</th></tr>\n";
  foreach($uni1 as $gram =>$count){
     if ($count < 6){
         break;
     }
     $c2 = $uni2[$gram];
     if ($c2 != 0){
     #echo '.';
        $loglike = logLikelihoodRatio($count, $c2, $total - $count, $total2 - $c2);
        #echo $loglike;
        if ($loglike != 0){
     	    $log[$gram] =$loglike;
     	    if (($count / $total) > ($c2 / $total2)){
     	    	$dir[$gram] = '';
     	    }
     	    else{
     	    	$dir[$gram] = 'neg';
     	    }
     	}
     }
  }
  $c3 =  count($log);
  #echo "<p>LOG LEN $c3</p>";
  arsort($log, SORT_NUMERIC);
  foreach($log as $gram=>$val){
      $count = $uni1[$gram];
  	  $direction = $dir[$gram];
  	  #$direction = '+';
      echo "<tr><td>$gram</td><td>$count</td><td class=\"$direction\"> $val</td></tr>\n";
    }
       
   
       
      
       echo "</table>";
 


 


	       #####
	      #####
         #####           END ANALYSIS FUNCTIONS
        #####
       #####

  
?>
				</div>
				</div>
<?php 
include('bottom3.html');
?>
</div>
</body>
</html>

<!-- Content by Ron Zacharski. Released under Creative Commons Attribution ShareAlike 3.0 Unported License -->
<!-- Design by Smallpark.org. Released as open source. -->