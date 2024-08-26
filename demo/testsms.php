<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://sunshine.com.bd/app/SmsSend",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Cookie: ci_session=89c8781bdd227f3733ce29a9a1edd8ba0603b65d"
  ),
));

$response = curl_exec($curl);

curl_close($curl);