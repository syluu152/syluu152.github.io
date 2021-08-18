<?php
$url = "https://portal.vietcombank.com.vn/Usercontrols/TVPortal.TyGia/pXML.aspx";

	//Lay noi dung trang web


function get_web_page( $url )
{
$options = array(
    CURLOPT_RETURNTRANSFER => true,     // return web page
    CURLOPT_HEADER         => false,    // don't return headers
    CURLOPT_FOLLOWLOCATION => true,     // follow redirects
    CURLOPT_ENCODING       => "",       // handle all encodings
    CURLOPT_USERAGENT      => "spider", // who am i
    CURLOPT_AUTOREFERER    => true,     // set referer on redirect
    CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
    CURLOPT_TIMEOUT        => 120,      // timeout on response
    CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
);

$ch      = curl_init( $url );
curl_setopt_array( $ch, $options );
$content = curl_exec( $ch );
$err     = curl_errno( $ch ); //Mã lỗi
$errmsg  = curl_error( $ch ); //Thông báo lỗi
$header  = curl_getinfo( $ch ); //Dữ liệu
curl_close( $ch );

$header['errno']   = $err;
$header['errmsg']  = $errmsg;
$header['content'] = $content;
return $header;
}

$data = get_web_page($url);
$result = $data["content"];

// print_r($result)

$obj = simplexml_load_string($result);
//require_once("login.php");
require_once("includes/main-header.php");
require_once("includes/top-header.php");
require_once("includes/menu-bar.php");
//require_once("navigation.php");
echo "<br><h3>TỶ GIÁ QUY ĐỔI TIỀN TỆ</h3></br>";
echo "<table border='1'>";
echo "<th>CurrencyCode</th><th>CurrencyName</th><th>Buy</th><th>Transfer</th><th>Sell</th>";
foreach ($obj->Exrate as $arr) {
	echo "<tr>";
		echo "<td>{$arr['CurrencyCode']}</td>";
		echo "<td>{$arr['CurrencyName']}</td>";
		echo "<td>{$arr['Buy']}</td>";
		echo "<td>{$arr['Transfer']}</td>";
		echo "<td>{$arr['Sell']}</td>";
	echo "</tr>";

}
echo "</table>";
echo "<br></br>";
require_once("includes/footer.php");