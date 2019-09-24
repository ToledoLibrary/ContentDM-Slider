<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Local History Digital Collections and Exhibits Slideshow | Toledo Lucas County Public Library</title>

<!--
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
-->

<link rel="stylesheet" href="bootstrap.min.css">
<script src="jquery-3.3.1.slim.min.js"></script>
<script src="bootstrap.min.js"></script>


<style>

body {background-color:#002B45; font-family: 'Arial', sans-serif;}

h1 {color:#CD202C;padding-top: 10px;}

h1 img {height:5vh; margin-right:30px;padding-bottom:5px;}

.highlight {color:black; background-color:#fff; opacity:.85; font-size: 1.2em;}

.row {  }

.carousel { height: 93vh; }

.carousel-item { height: 93vh; width:auto; }

.carousel-item img { height: 93vh; }

.header {height:7vh;}

</style>


<script>
  jQuery(document).ready(function ($) {

 $('.carousel').carousel({
  interval: 10000
})

$('.carousel').carousel('cycle');

});    


</script>


    </head>

    
	
<body>
<div class="container-fluid">
<div class="row">
<div class="col-12 no-gutters justify-content-center d-flex header">
<h1> <img src="http://www.toledolibrary.org/images/logo_reversed.svg"/> COMMUNITY PHOTO ALBUM </h1>
</div>
</div>
<div class="row">
<div class="col-12 no-gutters justify-content-center d-flex">
  <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">

          <?php

function remoteFileExists($url) {
    $curl = curl_init($url);

    //don't fetch the actual page, you only want to check the connection is ok
    curl_setopt($curl, CURLOPT_NOBODY, true);

    //do request
    $result = curl_exec($curl);

    $ret = false;

    //if request did not fail
    if ($result !== false) {
        //if request was ok, check response code
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  

        if ($statusCode == 200) {
            $ret = true;   
        }
    }

    curl_close($curl);

    return $ret;
}


$xmlData = file_get_contents('https://server16007.contentdm.oclc.org/dmwebservices/index.php?q=dmQuery/p16007coll31/CISOSEARCHALL%5e%5eall%5eand/title!identi/notes!reverse/300/1/1/0/0/0/xml');

// Create the document object

$xml = simplexml_load_string($xmlData);

$pager = array();

// How many hits did the search yield?

foreach ($xml->xpath('//pager') as $hits) {
        $pager[] = array(
                'start' => (string) $hits->start,
                'total' => (string) $hits->total
        );
}

$result = array();

// Get the nodes and loop them

foreach ($xml->xpath('//record') as $record) {
        $result[] = array(
                'collection' => (string) $record->collection,
                'title' => (string) $record->title,
                'subject' => (string) $record->subjec,
                'descri' => (string) $record->descri,
                'pointer' => (string) $record->pointer,
                'identi' => (string) $record->identi
        );
}

// The first record, $pager[0], will have the total number of results and the starting record

$numberOfHits = $pager[0]["total"];
$startingAt = $pager[0]["start"];

//echo "Number of hits: $numberOfHits starting at record number $startingAt\n\n";

// I can get away with just checking the first record for the collection alias, since I am only searching 1 collection. If I was searching across all the collections, I would have to check each alias

$collectionName = $result[0]["collection"];

//echo "Collection alias: $collectionName\n\n";

$resultCount = count($result) - 1;
$active = 0;

for ($i=0;$i<=$resultCount;$i++) {
/*
        $title = $result[$i]["title"];
        $subject = $result[$i]["subject"];
        $description = $result[$i]["descri"];
        $pointer = $result[$i]["pointer"];
        echo "$title: $subject: $description: $thumb\n\n";
*/
		$title = $result[$i]["title"];
        $pointer = $result[$i]["pointer"];
        $identi = $result[$i]["identi"];
        
 
if (strpos($identi, '.jpg') !== false) {

//$imageurl = 'https://ohiomemory.org/digital/iiif/p16007coll31/'.$pointer.'/full/1000,/0/default.jpg';
$imageurl = 'https://ohiomemory.org/digital/iiif/p16007coll31/'.$pointer.'/full/pct:90/0/default.jpg';




       // echo $pointer;
	   //echo '<li><img src=https://ohiomemory.org/digital/iiif/p16007coll31/'.$pointer.'/full/full/0/default.jpg/></li>';
	   
	   if ($active == '0') {
	   	echo '<div class="carousel-item active">';
	   $active = '1';
	   }
	   else {
	   	echo '<div class="carousel-item">';
	   }
	   
	
	  
	   echo '<img src="'.$imageurl.'" class="d-block" alt="">';
       echo '<div class="carousel-caption">';
       echo '<p class="highlight">'.$title.'</p>';
       echo '</div>';
       echo '</div>';
	   //echo $title;
	   }

    
}


?>
        

    
    </div>
   <!--
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  -->
  </div>
</div>
        


</div> <!--row -->
</div> <!-- containter -->






            </body>

</html>
       