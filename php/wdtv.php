<?php
class Wdtv {
	static $address = "http://192.168.1.106";
	static function load() {
//echo __LINE__; die;
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		//
		$data = file_get_contents("php://input");

		//$data = http_build_query($_POST);
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, self::$address."/cgi-bin/toServerValue.cgi");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);

		curl_close ($ch);

		echo $server_output;
	}
	static function load2($command) {
//echo __LINE__; die;
		$ch = curl_init();
		$address = self::$address.":10184";
//		$command = 'GetMute';
//		$action = 'urn:schemas-upnp-org:service:AVTransport:1';
//		$page = "MediaRenderer_RenderingControl/control";
		////////////////////
//		$command = "GetTransportInfo";
//		$command = "Pause";
		$action = "urn:schemas-upnp-org:service:AVTransport:1";
		$page = "MediaRenderer_AVTransport/control";
		////////////////////
//curl
//-H "Content-Type: text/xml"
//-H 'SOAPACTION: urn:schemas-upnp-org:service:AVTransport:1#GetTransportInfo"'
//-XPOST
//-d '
//<s:Envelope xmlns: s="http://schemas.xmlsoap.org/soap/envelope" s:encodingStyle="http://schemas.xmlsoap.org/soap/encoding">
//<s:Body>
//<u:GetTransportInfo xmlns:u="urn:schemas-upnp-org:service:AVTransport:1">
//<InstanceID>0</InstanceID>
//</u:GetTransportInfo>
//</s:Body>
//</s:Envelope>'
//http://wdtvlive:10184/MediaRenderer_AVTransport/control
		$headers = [
			'Content-Type: text/xml',
			'SOAPACTION: '.$action.'#'.$command.'"',
		];

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$data = '';
		$data .= '<s:Envelope';
		$data .= ' xmlns:s="http://schemas.xmlsoap.org/soap/envelope"';
		$data .= ' s:encodingStyle="http://schemas.xmlsoap.org/soap/encoding">';
		$data .= '<s:Body>';
		$data .= '<u:'.$command.'';
		$data .= ' xmlns:u="'.$action.'">';
		$data .= '<InstanceID>0</InstanceID>';
		$data .= '</u:'.$command.'>';
//		$data .= '</u:GetTransportInfo>';
		$data .= '</s:Body>';
		$data .= '</s:Envelope>';
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_URL, $address."/".$page."");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);

		curl_close ($ch);

//		echo htmlentities($server_output);
		header("content-type: text/xml");
		echo $server_output;

	}
	static function transformer($src) {
//echo __LINE__; die;
		// CHargement du source XML
		$xml = new DOMDocument;
		$xml->loadXML($src);

		$xsl = new DOMDocument;
		$xsl->load('upnp.xsl');

		// Configuration du transformateur
		$proc = new XSLTProcessor;
		$proc->importStyleSheet($xsl); // attachement des règles xsl

		return $proc->transformToXML($xml);

	}
	static function explorer() {
//echo __LINE__; die;
		$address = self::$address.":10184";
		exit($adress);
		if (isset($_GET['xml'])) {
			$address .= "/" . $_GET['xml'];
		}
		echo $address;
		$ch = curl_init();
		$headers = [
//			'Content-Type: text/xml',
//			'SOAPACTION: urn:schemas-upnp-org:service:AVTransport:1#GetTransportInfo"',
		];

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_URL, $address);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);
//		var_dump($server_output);

		curl_close ($ch);

		$resultat = self::transformer($server_output);

//		echo htmlentities($resultat);
		echo $resultat;

	}
}
