<?php
class Wdtv {
	static $address = "http://192.168.1.106";
	static function load() {
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
	static function load2() {
		$ch = curl_init();
		$headers = [
			'Content-Type: text/xml',
//			'SOAPACTION: urn:schemas-upnp-org:service:AVTransport:1#GetTransportInfo"',
		];

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$command = 'GetMute';
		$data = '';
		$data .= '<s:Envelope';
		$data .= ' xmlns:s="http://schemas.xmlsoap.org/soap/envelope"';
		$data .= ' s:encodingStyle="http://schemas.xmlsoap.org/soap/encoding">';
		$data .= '<s:Body>';
		$data .= '<u:'.$command.'';
		$data .= ' xmlns:u="urn:schemas-upnp-org:service:RenderingControl:1">';
		$data .= '<InstanceID>0</InstanceID>';
		$data .= '</u:'.$command.'>';
//		$data .= '</u:GetTransportInfo>';
		$data .= '</s:Body>';
		$data .= '</s:Envelope>';
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_URL, self::$address.":10184/MediaRenderer_RenderingControl/control");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);

		curl_close ($ch);

		echo htmlentities($server_output);

	}
	static function transformer($xml, $xsl) {
		// CHargement du source XML
		$xml = new DOMDocument;
		$xml->loadXML($xml);

		$xsl = new DOMDocument;
		$xsl->load('upnp.xsl');

		// Configuration du transformateur
		$proc = new XSLTProcessor;
		$proc->importStyleSheet($xsl); // attachement des règles xsl

		echo $proc->transformToXML($xml);

	}
	static function explorer() {
		$ch = curl_init();
		$headers = [
			'Content-Type: text/xml',
//			'SOAPACTION: urn:schemas-upnp-org:service:AVTransport:1#GetTransportInfo"',
		];

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$command = 'GetMute';
		$data = '';
		$data .= '<s:Envelope';
		$data .= ' xmlns:s="http://schemas.xmlsoap.org/soap/envelope"';
		$data .= ' s:encodingStyle="http://schemas.xmlsoap.org/soap/encoding">';
		$data .= '<s:Body>';
		$data .= '<u:'.$command.'';
		$data .= ' xmlns:u="urn:schemas-upnp-org:service:RenderingControl:1">';
		$data .= '<InstanceID>0</InstanceID>';
		$data .= '</u:'.$command.'>';
//		$data .= '</u:GetTransportInfo>';
		$data .= '</s:Body>';
		$data .= '</s:Envelope>';
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_URL, self::$address.":10184/MediaRenderer_RenderingControl/control");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);

		curl_close ($ch);

		echo htmlentities($server_output);

	}
}
Wdtv::explorer();


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
