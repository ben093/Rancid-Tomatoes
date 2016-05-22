<?php
	/*
	HW3
	*/
	
	// /movie.php?film=tmnt
	//get movie name from query string
	$movie = $_GET["film"];
	
	//open info file
	$file = fopen($movie . "/info.txt", "r");
	
	$title = fgets($file);
	$year = fgets($file);
	$overallRating = fgets($file);
	
	fclose($file);
	
	
	//open overview file
	$file = fopen($movie . "/overview.txt", "r");
	
	$movieInfo = array();
	
	//push all lines of overview into an array
	while(!feof($file))
	{
		array_push($movieInfo, fgets($file));
	}
	fclose($file);

	//concatenate title/year to a single variable
	$header = $title . "(" . trim($year) . ")";
	
	//iterate through each movie
	for($i = 0; $i < count($movieInfo); $i++)
	{
		$movieInfo[$i] = explode(":", $movieInfo[$i]);
	}
	
	//tether icon
	if($overallRating >= 60)
	{
		$ratingImg = "freshbig.png";
		$ratingImgAlt = "Fresh";
	}
	else
	{
		$ratingImg = "rottenbig.png";
		$ratingImgAlt = "Rotten";
	}
	
	//reviews
	$reviews = glob($movie . "/review*.txt");
	
	//create review arrays
	$reviewText = array();
	$reviewRating = array();
	$reviewName = array();
	$reviewPublication = array();
	$reviewRatingImg = array();
	
	//populate array's for reviews
	for($i = 0; $i < count($reviews); $i++)
	{
		$file = fopen($reviews[$i], "r");
		array_push($reviewText, fgets($file));
		array_push($reviewRating, fgets($file));
		array_push($reviewName, fgets($file));
		array_push($reviewPublication, fgets($file));
		fclose($file);	
		
		if(strpos($reviewRating[$i], "FRESH") !== FALSE)
		{
			array_push($reviewRatingImg, "fresh.gif");
		}
		else
		{
			array_push($reviewRatingImg, "rotten.gif");
		}
	}	
?>
<!DOCTYPE HTML>
<!--
CSC 365
Fall 2014
HW 3
Ben Borgstede
-->
<html>
	<head>
		<title>Rancid Tomatoes</title>
		<meta charset="UTF-8" />
		<link href="movie.css" type="text/css" rel="stylesheet" />
		<link rel="icon" 
			type="image/png" 
			href="http://courses.cs.washington.edu/courses/cse190m/11sp/homework/2/rotten.gif">
	</head>
	<body>
		<div class="header">
			<img src="http://www.cs.washington.edu/education/courses/cse190m/12sp/homework/2/banner.png" alt="Rancid Tomatoes" />
		</div>
		
		<h1 class="title"><?php echo $header; ?></h1>	
		
	<div class="page">
		<div class="movieInfo">			
			<img src="<?php echo $movie; ?>/overview.png" alt="general overview" />
			
			<dl>
				<?php
				for($i = 0; $i < count($movieInfo); $i++)
				{
					?>
						<dt><?php echo $movieInfo[$i][0] ?></dt>
						<dd><?php echo $movieInfo[$i][1]; ?></dd>
					<?php
				}				
				?>
			</dl>
		</div>
		<div class="headerTitle">
			<img src="<?php echo $ratingImg; ?>" alt="<?php echo $ratingImgAlt; ?>" />
			<h1><?php echo $overallRating; ?>%</h1>
		</div>
		<div id="reviews">
			<div class="column">
				<?php 
				for($i = 0; $i < count($reviews); $i++)
				{ ?>
					<p class="quoteBox">
						<img src="<?php echo $reviewRatingImg[$i]; ?>" alt="<?php echo $reviewRating[$i]; ?>" />
						<q><?php echo $reviewText[$i]; ?></q>
					</p>
					<p class="authorBox">
						<img src="critic.gif" alt="Critic" />
						<?php echo $reviewName[$i]; ?> <br />
						<?php echo $reviewPublication[$i]; ?>
					</p>
				<?php 
					if(round(count($reviews) / 2) == $i + 1)
					{
						?>
						</div><div class="column">
						<?php
					}
				} ?>
			</div>
		</div>
		<p class="entries"><?php echo "(1-" . count($reviews) . ")" . " of " . count($reviews); ?></p>
	</div>
		<div class="validators">
			<a href="https://webster.cs.washington.edu/validate-html.php"><img src="http://webster.cs.washington.edu/w3c-html.png" alt="Valid HTML5" /></a> <br />
			<a href="https://webster.cs.washington.edu/validate-css.php"><img src="http://webster.cs.washington.edu/w3c-css.png" alt="Valid CSS" /></a>
		</div>
	</body>
</html>
