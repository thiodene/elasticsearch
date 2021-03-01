<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

use Elasticsearch\ClientBuilder;

use App\Http\Controllers\ExtendedSecurityController;

use App\Release;
use App\Http\Resources\ElasticApi;

class ElasticSearchController extends Controller
{

    /**
     * ElasticSearch GET/PUT/POST/DELETE/SEARCH commands
     * for Indexing/Mapping
     */
    private $client;
    private $index;
    public function __construct() 
    {
        $hosts = [[
        'host' => env('ES_HOST'),
        'user' => env('ES_USER'),
        'pass' => env('ES_PASS'),
        'scheme' => env('ES_SCHEME'),
        'port' => env('ES_PORT'),
        ]];
        $this->client = ClientBuilder::create()->setHosts($hosts)->build();
    }

    
    // Post to the ES
    public function elastic_release($release)
    {

        $params = array();
        $params['body']  = array(
                'cache' => time()
        );
        
        $params['index'] = env('ES_INDEX');
        
        // ENGLISH RELEASE
        // ***************************************************************************

        // Get english release
        $english_release = $release;
        $english_release["language"] = "en";
        //$english_release = ["data" => new ElasticApi($english_release)];
        $english_release = new ElasticApi($english_release);

        // Set english content to proper data format
        //$params['body'] = array("data" => new ReleaseApi($show_release_english));
        $params['body'] = json_encode($english_release);

        // Json Encode
        //json_encode($english);

        $result = $this->client->index($params);
        //return $result;

        $french_release = $release;
        $french_release["language"] = "fr";
        //$french_release = ["data" => new ElasticApi($french_release)];
        $french_release = new ElasticApi($french_release);

        $params['body'] = json_encode($french_release);

        // Json Encode
        //json_encode($english);

        $result = $this->client->index($params);

    }
    
    public function search_index()
    {
        $params = array();

        $params = [
            'index'  => env('ES_INDEX') 
        ];

        //var_dump($params);
        $result = $this->client->search($params);
        return $result;
    }

    public function show_release($release_id)
    {
        
        $params = array();
        $params = [
            'index' => env('ES_INDEX'),
            'body'  => [
                'query' => [
                    'match' => [
                        'id' => $release_id
                    ]
                ]
            ]
        ];
        
        $result = $this->client->search($params);

        return $result;
    }
   
    public function show_mapping()
    {
        $params = array();
        $params['index'] = env('ES_INDEX');

        $result = $this->client->indices()->getMapping($params);
        //$result = $this->client->indices()->getMapping();
        return $result;

    }

    public function create_index(Request $request)
    {
        $params = array();
        $params['body']  = array(
                'cache' => time()
        );
        $params['index'] = env('ES_INDEX');
        $params['type']  = env('ES_INDEX_TYPE');
        //var_dump($params);
        $result = $this->client->index($params);
        return $result;
    }

    public function create_index_with_mapping()
    {
        $params = array();
        $params['body']  = array(
                'cache' => time()
        );

        
        $params = [
            'index' => env('ES_INDEX'),
            'body' => [
                'settings' => [
                    'number_of_shards' => 3,
                    'number_of_replicas' => 2
                ],
                'mappings' => [
                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => [
                        'id' => [
                            'type' => 'long'
                        ],
                        'contacts' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'content_title' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'content_subtitle' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'content_lead' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'content_body' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 1024 ] ]
                        ],
                        'keywords' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'language' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'ministry_id' => [
                            'type' => 'long'
                        ],
                        'ministry_acronym' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'ministry_name' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'ministry_abbreviated' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'quickfacts' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'release_date_time' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'release_date_time_formatted' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'release_id_translated' => [
                            'type' => 'long'
                        ],
                        'release_type_id' => [
                            'type' => 'long'
                        ],
                        'release_type_name' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'release_type_id' => [
                            'type' => 'long'
                        ],
                        'release_type_label' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'release_resources' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'slug' => [
                            'type' => 'text'
                        ],
                        'status_type_id' => [
                            'type' => 'long'
                        ],
                        'topics' => [ //------------------------------------------------
                            'properties' => [ 
                                'label' => [
                                    'type' => 'text',
                                    'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                                ],
                                'description' => [
                                    'type' => 'text',
                                    'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                                ],
                                'value' => [
                                    'type' => 'long'
                                ]
                            ]
                        ],
                        'unformatted_slug' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'unformatted_slug_translated' => [
                            'type' => 'text',
                            'fields' => [ 'keyword' => ["type" => "keyword",'ignore_above' => 256 ] ]
                        ],
                        'release_distribution_id' => [
                            'type' => 'long'
                        ],
                        'release_language_distribution' => [
                            'type' => 'long'
                        ]
                    ]
                ]
            ]
        ];
        



        $result = $this->client->indices()->create($params);
        //$result = $this->client->index($params);
        return $result;
    }

    public function elastic_release_delete($release_id)
    {
        $params = array();
        $params = [
            'index' => env('ES_INDEX'),
            'body'  => [
                'query' => [
                    'match' => [
                        'id' => $release_id
                    ]
                ]
            ]
        ];
        
        $result = $this->client->search($params);

        // Check if any document exists for this release_id
        if ($result["hits"]["total"]["value"] > 0)
        {
            //$doc_id = $result["hits"]["hits"][0]["_id"];
            // Loop over each Release with similar ID ex: "EN", "FR",...
            foreach ($result["hits"]["hits"] as $release) 
            {
                $doc_id = $release["_id"];

                // Now delete this DOC from its Indexed ID value
                // Re-initialize $params
                $params = array();
                $params = [
                    'index' => env('ES_INDEX'),
                    'id'    => $doc_id
                ];
            
                // Delete doc at /my_index/_doc_/my_id
                $result = $this->client->delete($params);
            
            }
        }
        //return $result;
        // Look for the Release in the ES Index if exists delete it
        //return $result["hits"]["hits"][0]["_id"];
        //return $result["hits"]["total"]["value"];
        return $result;

    }
    /**
     * Delete an existing Index
     * Removes also the mapping and existing data stored
     * 
     * @return \Illuminate\Http\Response
     */
    public function delete_index()
    {
        $params = array();
        
        $params = [ 'index' => env('ES_INDEX'),
                    'client' => [ 'ignore' => [400, 404] ] ];
        
                    //$response = $client->indices()->delete($params);
        $result = $this->client->indices()->delete($params);
        return $result;
    }

}
