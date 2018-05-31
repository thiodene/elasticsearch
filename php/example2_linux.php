# On the command line
# -------------------------------------------------------------------------------------------------

curl -XGET <my_url>:9200/logstash-index-*/_search?pretty -d '
{
"size": 0,
 "aggs" : {
    "langs" : {
            "terms" : { 
               "field" : "name" ,
                "size": 0
                      }
              }
         }
}'

# Inside of PHP script
# -------------------------------------------------------------------------------------------------

$url = '<my_url>:9200/logstash-index-*/_search?pretty';
$data = array(
    "size" => 0,
    "aggs" => array (
        "langs" => array (
                "terms" => array ( 
                   "field" => "name" ,
                    "size" => 0
                )
        )
    )
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, true); 
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$return = curl_exec($ch) or die(curl_error());
curl_close($ch);
//var_dump($return);

//return is json_encoded, you can decode it to have an array
$array_return = json_decode($return,true);

$aggregationsArray = array(); 
foreach($array_return['aggregations']['name']['buckets'] as $person) 
{
    $aggregationsArray[$person['key']] = $person['doc_count']; 
}
var_dump($aggregationsArray);
