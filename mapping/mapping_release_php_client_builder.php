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
