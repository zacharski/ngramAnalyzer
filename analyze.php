<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Ngram Analyzer</title>
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
		<li><a href="index.php">Analyzer</a></li>
		<li><a href="#">About Us</a></li>
		<li><a href="#">Our Products</a></li>
		<li><a href="#">Contact Us</a></li>
		</ul>
	</div>
		<div id="header">
		  <h1>Online NGram Analyzer</h1>
		  <h2>analyze your texts.</h2>
		</div>
				<div id="wrapper">
				<div id="content">
					<h1>Welcome to Lemonaid</h1>
					
		
    
    <?php


	       #####
	      #####
         #####           ANALYSIS FUNCTIONS
        #####
       #####


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
  
  

  function processLine($line){
       global $ngrams;
       global $previous;
       global $n;
       global $total;
  	   $words = preg_split('/\s+/', $line);
  	   #$ngrams = array();
       foreach($words as $word){
    	 $wordcomponents = separatePun($word);
    	 #$current = $word;
    	 foreach($wordcomponents as $current){
    	      #echo "X$current ";
    	      $gram = '';
    	      $total++;
    	      for($i = $n - 2; $i >= 0; $i--){
    	            $gram = "$gram$previous[$i] ";
    	      }
    	      $gram = "$gram$current";
    	      #$ngrams[$gram] = 1;
    	      #if (array_key_exists($gram, $ngrams))
    	      if (isset($ngrams[$gram]))
    	      {
    	          $ngrams[$gram] = $ngrams[$gram] + 1;
    	      }
    	      else {
    	         $ngrams[$gram] = 1;
    	      #   #echo "...";
    	      }
    	      $previous[4] = $previous[3];
    	      $previous[3] = $previous[2];
    	      $previous[2] = $previous[1];
    	      $previous[1] = $previous[0];
    	      $previous[0] = $current;
    	    
    	 }
       }
  
  }

    ###
   ###     MAIN
  ###


$thetext = $_POST['mytext'];
$cutoff = $_POST['cutoff'];
$total = 0;
$n = $_POST['gram'];
  #echo $thetext;
  $previous = array('', '', '', '');
  if (is_array($thetext) == true)
  {
  	foreach($thetext as $aline){
    	processLine($aline);
    }
  }
  else {
      if (substr($thetext, 0, 4) == 'http')
      {
      		$urls = preg_split('/\s+/', $thetext);
      		foreach($urls as $url){
      	    	processLine(file_get_contents($url));
      	    }
      }
      else{
      	processLine($thetext);
      }
  }
  echo "<p>Total number of tokens: $total</p>";
  arsort($ngrams, SORT_NUMERIC);
  echo "<table><tr><th>ngram</th><th>count</th><th>frequency</th></tr>\n";
  foreach($ngrams as $gram =>$count){
  	   if ($count < $cutoff){
  	   	   break;
  	   }
       $freq = ($count * 100) / $total;
       echo "<tr><td>$gram</td><td>$count</td><td>$freq</td></tr>\n";
       
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
include('bottom.html');
?>
</div>
</body>
</html>

<!-- Content by Ron Zacharski. Released under Creative Commons Attribution ShareAlike 3.0 Unported License -->
<!-- Design by Smallpark.org. Released as open source. -->