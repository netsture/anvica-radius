<?php

$number       = "919898183457";
$otp          = "586784";
$message      = "$otp is your OTP for login into your account. ANVICA HOTSPOT";
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
echo $response;
print_r($response);