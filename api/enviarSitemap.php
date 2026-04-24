<?php
include ("conectkarl.php");

// Crea un nuevo documento XML
$dom = new DOMDocument('1.0', 'UTF-8');

// Crea el elemento raíz <urlset>
$urlset = $dom->createElement('urlset');
$urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');


$sql = $db->query("SELECT * from tours where activo = 1 and visible = 1");
if($sql->execute()){
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		// Crea el elemento <url>
		$url = $dom->createElement('url');
		$loc = $dom->createElement('loc', "https://grupoeuroandino.com/tours/".$row['url'] );
		$url->appendChild($loc);
		$urlset->appendChild($url);
	}
}



// Agrega más elementos <url> según sea necesario

// Agrega el elemento <urlset> al documento
$dom->appendChild($urlset);

$rutaArchivo = '/home/perutra1/grupoeuroandino.com/sitemap_tours.xml';
$dom->save($rutaArchivo);

echo 'Archivo XML guardado correctamente en: ' . $rutaArchivo;
?>