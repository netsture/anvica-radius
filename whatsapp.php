<?php
$password = rand(100000, 999999);
$message = "*Anvica Hotspot* Verification Code: {$password} Keep it confidential. Support: www.anvica.in";

$number       = "919898183457";
$otp          = "586784";
$message      = $message;
$media_url    = "https://hotspot.anvica.in/public/upload/whatsapp.jpeg";
$filename     = "whatsapp.jpeg";
$instance_id  = "691DB236D9631";
$access_token = "68e941fe60320";

$apiUrl = "https://t.api.io.in/api/send";

$params = [
    'number'        => $number,
    'type'          => 'media',
    'message'       => $message,
    'media_url'     => $media_url,
    'filename'      => $filename,
    'instance_id'   => $instance_id,
    'access_token'  => $access_token,
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $apiUrl . "?" . http_build_query($params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
} else {
    echo "API Response: " . $response;
}

curl_close($ch);

print_r(json_decode($response, true));