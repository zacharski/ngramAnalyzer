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
		<li><a href="index.php">Ngram Analyzer</a></li>
		<li><a href="comparator.php">Text Comparator</a></li>
		<li><a href="http://guidetodatamining.com">Guide to Data Mining</a></li>
		
		</ul>
	</div>
		<div id="header">
		  <h1>Online NGram Analyzer</h1>
		  <h2>analyze your texts.</h2>
		</div>
				<div id="wrapper">
				<div id="content">
					<h1>Welcome</h1>
					
					
					<form method="post" action="analyze.php">
				
				<p>
    <textarea id="mytext" name="mytext" cols="70" rows="20" placeholder="Enter your text here or type in URLs one per line."></textarea><br /></p>
    
    
    <p><input type ="radio" name="method" checked="checked" value="byFreq" /><b>Using Frequency</b>: Show 
    
    <select name="gram" id="gram">
    <option value="1">unigrams</option>
    <option value="2" selected="selected">bigrams</option>
    <option value="3" >trigrams</option>
    <option value="4">4grams</option>
    <option value="5">5grams</option>
    </select>
    
    that occur at least 
    
     <select name="cutoff" id="cutoff">
    <option value="1">one</option>
    <option value="2" selected="selected">two</option>
    <option value="3" >three</option>
    <option value="4">four</option>
    <option value="5">five</option>
    <option value="10">ten</option>
    <option value="20">twenty</option>
    <option value="50">fifty</option>
    </select>
    
     times. &nbsp; 
    
    
   </p>
    <p><input type ="radio" name="method" value="LogLike" /><b>Using Log Likelihood</b>: Show bigram collocations</p>
    <p><input type ="checkbox" name="punctuation" value="checked" /><b>Treat punctuation as separate tokens</b></p>
    <p> <input type="submit" value="Submit" /> </p>
    
    
				</form>
					
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