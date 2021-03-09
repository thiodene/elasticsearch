        $params = [
            'index' => env('ES_INDEX'),
            'body' => [
                'mappings' => [
                    'properties' => [
                        'id'                                => ['type' => 'integer'],
                        'ministry_id'                       => ['type' => 'integer'],
                        'release_id_translated'             => ['type' => 'integer', 'index' => false],
                        'release_type_id'                   => ['type' => 'integer', 'index' => false],
                        'status_type_id'                    => ['type' => 'integer'],
                        'release_distribution_id'           => ['type' => 'integer', 'index' => false],
                        'contacts'                          => ['type' => 'text', 'index' => false],
                        'content_body'                      => ['type' => 'text'],
                        'content_lead'                      => ['type' => 'text'],
                        'content_subtitle'                  => ['type' => 'text'],
                        'content_title'                     => ['type' => 'text'],
                        'keywords'                          => ['type' => 'text', 'index' => false],
                        'language'                          => ["type" => "keyword", 'ignore_above' => 2],
                        'ministry_acronym'                  => ["type" => "keyword", 'ignore_above' => 10, 'index' => false],
                        'ministry_abbreviated'              => ['type' => 'text', 'index' => false],
                        'ministry_name'                     => ['type' => 'text'],
                        'quickfacts'                        => ['type' => 'text'],
                        'release_date_time'                 => ['type' => 'date'],
                        'release_date_time_formatted'       => ['type' => 'text', 'index' => false],
                        'release_type_label'                => ["type" => "keyword"],
                        'release_type_name'                 => ['type' => 'text', 'index' => false],
                        'release_resources'                 => ['type' => 'text', 'index' => false],
                        'slug'                              => ['type' => 'text', 'index' => false],
                        'topics' => [
                            'properties' => [ 
                                'label'                     => ["type" => "keyword"],
                                'description'               => ['type' => 'text', 'index' => false],
                                'value'                     => ['type' => 'integer', 'index' => false]
                            ]
                        ],
                        'unformatted_slug'                  => ['type' => 'text', 'index' => false],
                        'unformatted_slug_translated'       => ['type' => 'text', 'index' => false],
                        'release_language_distribution'     => ['type' => 'text', 'index' => false]
                    ]
                ]
            ]
        ];
