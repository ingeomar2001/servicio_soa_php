<?php

if(is_null($_GET["director"])){
    $director = "tarantino";
}
else{
    $director = $_GET["director"];
}

$start = microtime(true);
echo CallAPI("GET","http://netflixroulette.net/api/api.php",array('director'=>$director));
microtime(true) - $start;

// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value
function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
               $url = sprintf("%s?%s", $url, http_build_query($data,null,'&',PHP_QUERY_RFC3986));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
 

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}
?>