<?php 
if (isset($_COOKIE["NAHUI"])) {
	header('Location: http://google.com/');
	return;
	}
if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) { $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP']; }
$ip = $_SERVER['REMOTE_ADDR'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$sub1 = (isset($_GET['_clickid']) && !empty($_GET['_clickid'])) ? $_GET['_clickid'] : $_POST['clickid'];
$sub2 = $_POST['bay'];
$fbp = (isset($_GET['_fbp']) && !empty($_GET['_fbp'])) ? $_GET['_fbp'] : $_POST['fbp'];
$order = [
'ip' => (!empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null), // ip пользователя
'name' => $name,
'phone' => $phone,
'api_key' => 'DMf5eT55Vds6F2A37-SPP-UuaVlEHV2L',
'stream_code' => 'sgkl',
'lang' => 'pt',
'offer_id' => '3725',
'country' => 'pt',
'sub1' => $sub1,
'sub2' => $sub2,
];

if (isset($phone)) {
	$headers = [
        "Host" => $uri,
        "User-Agent" => (!empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null),
        "Accept" => (!empty($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null),
        "Accept-Language" => (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : null),
        "Keep-Alive" => '15',
        "Connection" => "keep-alive",
        "Referer" => (!empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null),
	];
	
$uri = 'http://api.cpagetti.com/order/register';
$curl = curl_init();
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_URL, $uri);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $order);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$return = curl_exec($curl);
curl_close($curl);
setcookie("NAHUI", "123", time() + (3600 * 24));

date_default_timezone_set('Europe/Moscow');
$time = date('Y-m-d H:i:s');
$message = "$time;$fbp;$sub1;$sub2;$ip;$name;$phone;$return\n";
file_put_contents('log.txt', $message, FILE_APPEND | LOCK_EX); 

header("Location: success.html");

$urls = 'http://keitaro.cc/56b2efe/postback?status=lead&subid=' . urlencode($sub1) . '&sub_id_12=' . $name . '&sub_id_13=' . $phone;

file_get_contents($urls);

exit;

} else {
   date_default_timezone_set('Europe/Moscow');
    $time = date('Y-m-d H:i:s');
    $message = "$time;$stream;$sub1;$ip;$fio;$phone;NO PHONE\n";
    file_put_contents('log.txt', $message, FILE_APPEND | LOCK_EX);
}

?>

