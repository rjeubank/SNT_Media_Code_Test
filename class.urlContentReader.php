<?php
class urlContentReader{
	private $url='';
	private $headline='';
	private $arrArticle = array();
	private $imagePath = '';
	private $rawContent = '';

	function __construct($url) {
		$this->url = $url;
		$this->loadHtmlContent();
		$this->parseCnnContent();
	}

	function setUrl($inputUrl) {
		$this->url = $inputUrl;
	}

	function loadHtmlContent(){
		$this->rawContent = file_get_contents($this->url);

	}
	function getHtmlContent(){
   		return $this->rawContent;
	}

	function getHeadline(){
   		return $this->headline;
	}

	function getArticle(){
   		return $this->arrArticle;
	}

	function displayContent(){
		echo '<img src="' . $this->imagePath . '" />';
		echo "Headline: " .  $this->headline . "<br>";
		echo "Article:<br>";
		foreach($this->arrArticle as $paragraph)
			echo $paragraph . "<br>";

	}

	function parseCnnContent(){
		
		//Grab Headline from raw content located in the pg-headline class
		$headline = strstr($this->rawContent,'<h1 class="pg-headline">');
		$this->headline = strip_tags(strstr($headline,'</h1>',true));
		//Grab image path using the image tag in the html
		$rawImagePath = strstr($this->rawContent,'data-src-large=');
		$arrImagePath = explode('"',$rawImagePath,5);
		//$arrImagePath = explode("=",$arrImagePath[0]);
		$this->imagePath = $arrImagePath[1];
		//Parse the raw content searching for body paragraphs putting them in an array for the article for individual paragraphs to be stored seperately.
		$parseContent = $this->rawContent;
		while(preg_match ('/<p class="zn-body__paragraph">/i',$parseContent))
		{
			$parseContent = strstr($parseContent,'<p class="zn-body__paragraph">');
			$this->arrArticle[] = strip_tags(strstr($parseContent,'</p>',true));
			$parseContent = substr($parseContent,27);
		}
		//Check end of article content to see if it contains link text to other articles, if so pop that text off the array.
		while(preg_match ('/Read:/i',end($this->arrArticle)))
			array_pop($this->arrArticle);
	}
}
?>