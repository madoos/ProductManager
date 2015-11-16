<?php
 	
class ProductManager{

	public $id;
	public $name;
	public $price;
	public $description;
	public $specifications;
	public $images;
	protected static $xPhat;

	public function __construct($urlProduct,$prefixId){
		$this->id = uniqid($prefixId);
		$this->images = [];
		$this->xpath = $this->createXpaht($urlProduct);
	} 
	
	private function createXpaht($urlProduct){
		$html =  file_get_contents($urlProduct);
		$html = $this->encodeToIso($html);
		$dom = new DOMDocument();
		@$dom->loadHTML( $html );
		return  new DOMXPath($dom);
	}

	public function encodeToUtf8($string) {
		return mb_convert_encoding($string, 'UTF-8', mb_detect_encoding($string,'UTF-8,ISO-8859-1,ISO-8859-15', true));
	}

	public function encodeToIso($string) {
		return mb_convert_encoding($string, 'ISO-8859-1', mb_detect_encoding($string,'UTF-8,ISO-8859-1,ISO-8859-15', true));
	}

	public function addValue($query,$attrObj,$urlBase=''){
		//optimizar esto hay mucho codigi repetido!
		switch ($attrObj) {
			case "name":
				$delimiter = " ";
				$name = $this->getContentHtml($query, $delimiter);
				$this->name = str_replace("'","",$name);
				break;
			case "price":
				$delimiter = "";
				$price = $this->getContentHtml($query, $delimiter);
				$price = $this->clearPrice($price);
				$this->price =$price;
				break;
			case "description":
				$delimiter = "";
				$description = $this->getContentHtml($query, $delimiter);
				$this->description = " "; //$description;
				break;
			case "specifications":
				$delimiter = " -sl- ";
				$specifications = $this->getContentHtml($query,$delimiter);
				$this->specifications = $specifications;
				break;
			case "images":
				$delimiter = ',';
				$images =  $this->getImages($query,$delimiter);
				if( !empty($urlBase) )$images = $this->addUrlBase($images,$urlBase);
				$this->images = $images;
				break;
		}

	}

	private function addUrlBase($items,$url){
		return array_map(function($item) use ($url){ return $url.$item; },$items);
	}

	private function getImages($query,$delimiter=","){
		$srcs = $this->xpath->query($query);
		$imgs = $this->getContentFromElements($srcs,$delimiter);
		$imgs = array_filter( explode(",", $imgs) , function($imgUrl){ return !empty($imgUrl);} );
		return  array_reverse($imgs);
	}

	private function getContentHtml($query,$delimiter=' '){
		$elements = $this->xpath->query($query);
		$content = $this-> getContentFromElements($elements,$delimiter);
		return trim($content);
	}

	private function getContentFromElements($elements,$delimiter=""){
		$content = "";
		if (!is_null($elements)) {
	 		foreach ($elements as $element) {
	    		$nodes = $element->childNodes;		
	    		foreach ($nodes as $node) {
	      			$content .= $node->nodeValue.$delimiter;
	    		}
	  		}
	  	}
	  	return $content;
	}

	private  function clearPrice($price){
		return  trim( preg_replace( "/[a-zA-Z]/", "", $price) );

	}

	public function showInfo(){
		$self =  get_object_vars($this);
		var_dump($self);
	}

	/////////////////////////////////////////////////////////////STATICS FUNCTION//////////////////////////////////////////////////////////////////////////////

	public static function setUrlBase($urlbase,$source){
		return array_map( function($link) use ($urlbase){ return $urlbase.trim( str_replace('"','',$link) ); } ,$source );
	}

	public static function getAhreftLinks($urlPge,$xpathQuery){
		$result = [];
		$dom = new DOMDocument();
		@$dom->loadHTML( file_get_contents( $urlPge ) );
		$xpath = new DOMXPath($dom);
		$elements  = $xpath->query($xpathQuery);
		for ($i = 0; $i < $elements->length; $i++) {
			$href = $elements->item($i);
			$result[] = $href->getAttribute('href');
		}
		return $result;

	}


}

?>