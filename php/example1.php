$param = "
    {
    'filtered' : {
        'query' : {
            'term' : { 'kingdom_interpreted' : 'Plantae' }
        }
    }

    }";
$header = array(
    "content-type: application/x-www-form-urlencoded; charset=UTF-8"
);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "http://xxxxx:9200/idx_occurrence/Occurrence/_search");
curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
$res = curl_exec($curl);
curl_close($curl);
return $res;
