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
		<li><a href="#">Home</a></li>
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
    
   
					
					<p>After a long hiatus from designing open source templates, I'm back! Lemonaid is a design that uses some brighter and more contemporary colours. The yellow tries to make the design look more &quot;alive&quot;. I like the way it's turned out, and enjoy the colour scheme. This design, like all of my designs, are pretty minimalistic and simple, and it's just the way I like it (Hehe). A little about me: I am a student living in Canada, and do web design as a hobby on my spare time. If you want me to design a site for you, feel free to drop me a line at <strong>web @ smallpark . org</strong>, or visit my site at <strong><a href="http://smallpark.org">smallpark.org</a></strong> (Under construction). Also, if you're looking for web hosting, you can give <a href="http://dreamhost.com">Dreamhost</a> a shot, if you use the promocode <strong>BIGDREAM</strong>, you can save 50 bucks on any plan. (And then I earn some affiliate bucks :). Now for some more Lorem Ipsum:</p>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Pellentesque tortor risus, iaculis nec, ultricies in, tempus vitae, quam. Proin semper magna a dui. Maecenas ut sem a leo molestie pretium. Nulla velit. Proin faucibus libero vitae velit. Integer mi mauris, consectetuer at, facilisis tempus, feugiat ut, nunc. Ut ut eros. Nam suscipit. Aliquam tristique arcu. <a href="#">Mauris quam.</a> Mauris vel pede id massa hendrerit convallis. Sed a orci. Morbi consequat semper metus. In hac habitasse platea dictumst. </p>
					<h1>Lorem Ipsum Dolor Sit</h1>
					<p>Ut magna libero, posuere ac, pharetra et, nonummy in, augue. Nullam quis ipsum. In congue, tellus ac pulvinar tempor, est enim euismod neque, at rhoncus arcu arcu eu justo. Vestibulum nec nibh. In mollis, magna ut feugiat fringilla, nunc metus tempus purus, id adipiscing ante lacus nec orci. Pellentesque vel enim.</p>
				</div>
				</div>
<div id="sidebar">
	<h1>Another Sidebar</h1>
	<p>Vestibulum nec urna ac elit hendrerit congue. Mauris et odio non odio congue viverra. Pellentesque at mi in lacus faucibus fermentum. Integer quis odio in lorem ornare laoreet. Aenean condimentum. Maecenas vitae lacus a est ultrices nonummy. Etiam sed sapien a mi feugiat egestas. Nam sed arcu sed arcu pretium interdum. Ut quis tellus. <a href="#">Class aptent taciti sociosqu ad litora torquent per conubia </a>nostra, per inceptos hymenaeos. Etiam quis nibh. Quisque sed risus. Integer lobortis eros eu dui. Aliquam et ante. Sed nulla diam, sagittis at, nonummy sed, lobortis et, elit. Morbi rhoncus viverra tortor. Sed posuere turpis vel orci. Vivamus euismod leo vitae lectus cursus sagittis. </p>
</div>
<div id="extra">
	<h1>Extra Stuff </h1>
	<p> Praesent erat tortor, eleifend ac, mattis vel, condimentum non, ipsum. Nam pretium ante a erat. Nam justo. In ultricies volutpat diam. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed libero arcu, egestas pharetra, sagittis vitae, fringilla vitae, odio. Sed volutpat libero. Vivamus malesuada pretium dolor. Donec quis eros vel pede pretium ornare. Vivamus ac eros. Phasellus sodales lectus ut dolor luctus sollicitudin. Fusce volutpat dui ac leo. Morbi urna pede, consectetuer ornare, cursus cursus, porta vitae, mi. </p>
</div>
<div id="footer">

	<span id="design-by">Design by <a href="http://smallpark.org">Smallpark Studios<!-- Thank you for keeping this on --></a></span> 
	  Creative Commons License.
</div>
</div>
</body>
</html>

<!-- Design by Smallpark.org. Released as open source. -->