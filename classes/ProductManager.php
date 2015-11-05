<?php
 	
class ProductManager{

	public $id;
	public $name;
	public $price;
	public $description;
	public $specifications;
	public $images;
	protected static $xPhat;

	public function __construct($urlProduct,$prefixId="azk"){
		$this->id = uniqid($prefixId);
		$this->images = [];
		$this->xpath = $this->createXpaht($urlProduct);
	} 


	/*private function  createProduct($urlProduct){
	
		//$elements  = $xpath->query('//'.$htmlTag.'[contains(@class,"'.$htmlClass.'")]');
		$xpath =  createXpaht($linkProduct);
		
		$elements = $xpath->query('//div[@class="wbm ne"]');
		$nameProducts = getContentFromElements($elements);
		echo $nameProducts."<br><br>";
		
		$elements = $xpath->query('//div[@class="copy"]');
		$description = getContentFromElements($elements);
		echo $description."<br><br>";

		$elements = $xpath->query('//div[@class="details clearfix"]/ul');
		$specifications = getContentFromElements($elements,"<br>");
		echo $specifications ."<br><br>";

		$elements = $xpath->query('//div[@class="msrp clearfix"]/span');
		$price = getContentFromElements($elements);
		$price = clearPrice($price);
		echo $price ."<br><br>";

		$elements = $xpath->query("//img[@class='product-hero-image']/@src");
		$images = getContentFromElements($elements);
		$images = explode(",", $images);
		var_dump($images);
		echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
	}*/

	private function createXpaht($urlProduct){
		$dom = new DOMDocument();
		@$dom->loadHTML( file_get_contents($urlProduct) );
		return  new DOMXPath($dom);
	}

	public function addValue($query,$attrObj,$urlBase=''){
		//optimizar esto hay mucho codigi repetido!
		if($attrObj == "name") {
			$delimiter = "";
			$name = $this->getContentHtml($query, $delimiter);
			$this->name = trim($name);
		}elseif( $attrObj == "price"){
			$delimiter = "";
			$price = $this->getContentHtml($query, $delimiter);
			$price = trim($this->clearPrice($price));
			$this->price = $price;
		}else if($attrObj == "description"){
			$delimiter = "";
			$description = trim($this->getContentHtml($query, $delimiter));
			$this->description = $description;
		}else if($attrObj == "specifications"){
			$delimiter = " -sl- ";
			$specifications = $this->getContentHtml($query,$delimiter);
			$specifications = $this->clearGiantSpecification($specifications);
			$this->specifications = trim($specifications);
		}else if ($attrObj == "images"){
			$delimiter = ',';
			$images =  $this->getImages($query,$delimiter);
			if( !empty($urlBase) )$images = $this->addUrlBase($images,$urlBase);
			$this->images = $images;
		}
	}

	private function clearGiantSpecification($specification){
		$specialCharts = array('Ã¢ÂÂ¬','Ã¡','Ã©','ÃÂ­','Ã³','Ãº','Á');
		$normalCharts = array('','á','é','í','ó','ú');
	/*	for($i = 0; $i<count($specialCharts)-1; $i++){
			$specification = str_replace($specialCharts[$i],$normalCharts[$i],$specification);
		}*/
		$specification = str_replace('ÃÂ','í',$specification);
		$specification = str_replace('CUADRO',' -sl- CUADRO -sl ',$specification);
		$specification = str_replace('COMPONENTES',' -sl- COMPONENTES -sl ',$specification);
		$specification = str_replace('TRANSMISIÓN',' -sl- TRANSMISIÓN -sl ',$specification);
		$specification = str_replace('RUEDAS',' -sl- RUEDAS -sl ',$specification);
		$specification = str_replace('OTROS',' -sl- OTROS -sl ',$specification);
		return  utf8_encode($specification);


	}

	private function addUrlBase($items,$url){
		return array_map(function($item) use ($url){ return $url.$item; },$items);
	}

	private function getImages($query,$delimiter=","){
		$srcs = $this->xpath->query($query);
		$imgs = $this->getContentFromElements($srcs,$delimiter);
		$imgs = array_filter( explode(",", $imgs) , function($imgUrl){ return !empty($imgUrl);} );
		return  $imgs;
	}

	private function getContentHtml($query,$delimiter=''){
		$elements = $this->xpath->query($query);
		$content = $this-> getContentFromElements($elements,$delimiter);
		return utf8_encode($content);
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
		$price = trim( preg_replace( "/[a-zA-Z]/", "", $price) );
		return str_replace( array('$','€'),'',$price);
	}

	public function showInfo(){
		$esto =  get_object_vars($this);
		var_dump($esto);
	}

	/////////////////////////////////////////////////////////////STATICS FUNCTION//////////////////////////////////////////////////////////////////////////////


	public static function setUrlBase($urlbase,$source){
		return array_map( function($link) use ($urlbase){ return $urlbase.trim( str_replace('"','',$link) ); } ,$source );
	}


	public static function GetAhreftLinks($urlPge,$xpathQuery){
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