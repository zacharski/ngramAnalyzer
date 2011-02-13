<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>File Comparator</title>
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
		  <h1>Online Text Comparator</h1>
		  <h2>analyze your texts.</h2>
		</div>
				<div id="wrapper">
				<div id="content">
					<h1>Compare the words in this text:</h1>
					
					
					<form method="post" action="comparator2.php">
				
				<p>
    <textarea id="mytext" name="mytext" cols="70" rows="20" placeholder="Enter your text here or type in URLs one per line."></textarea><br /></p>
    
    <h1>To those in this text:</h1>
    <textarea id="mytext" name="reference" cols="70" rows="20" placeholder="Enter your text here or type in URLs one per line."></textarea><br /></p>

    <p> <input type="submit" value="Submit" /> </p>
    
    
				</form>
					
					</div>
				</div>
<?php 
include('bottom2.html');
?>

</div>
</body>
</html>
<!-- Content by Ron Zacharski. Released under Creative Commons Attribution ShareAlike 3.0 Unported License -->
<!-- Design by Smallpark.org. Released as open source. -->