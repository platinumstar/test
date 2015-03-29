<?php
$html = "";
$url = "http://localhost/test/sample.xml";
$xml = simplexml_load_file($url);
for ($i = 0; $i < 3; $i++) {
	$title = $xml->Product[$i]->description;
	$html .= "<p>$title</p>";
	//echo $html;
	//rss
	//channel	
}
echo $html;
?>
