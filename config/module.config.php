<?php
return [
    'service_manager' => [
        'abstract_factories' => [
            'Matryoshka\Model\Wrapper\Mongo\Service\MongoDbAbstractServiceFactory',
            'Matryoshka\Model\Wrapper\Mongo\Service\MongoCollectionAbstractServiceFactory'
        ],
        'invokables' => [
            'Matryoshka\Model\Wrapper\Mongo\ResultSet\HydratingResultSet' => 'Matryoshka\Model\Wrapper\Mongo\ResultSet\HydratingResultSet',
            'Strapieno\Place\Model\Criteria\Mongo\PlaceMongoCollectionCriteria' => 'Strapieno\Place\Model\Criteria\Mongo\PlaceMongoCollectionCriteria',
            'Matryoshka\Model\Wrapper\Mongo\Criteria\Isolated\ActiveRecordCriteria' => 'Matryoshka\Model\Wrapper\Mongo\Criteria\Isolated\ActiveRecordCriteria',
            'Matryoshka\Model\Wrapper\Mongo\Criteria\ActiveRecord\ActiveRecordCriteria' => 'Matryoshka\Model\Wrapper\Mongo\Criteria\ActiveRecord\ActiveRecordCriteria',
        ],
        'aliases' => [
            'Strapieno\Model\ResultSet\HydratingResultSet' => 'Matryoshka\Model\Wrapper\Mongo\ResultSet\HydratingResultSet',
            'Strapieno\Model\Criteria\IsolatedActiveRecordCriteria' => 'Matryoshka\Model\Wrapper\Mongo\Criteria\Isolated\ActiveRecordCriteria',
            'Strapieno\Place\Model\Criteria\PlaceCollectionCriteria' => 'Strapieno\Place\Model\Criteria\Mongo\PlaceMongoCollectionCriteria',
            'Strapieno\Model\Criteria\NotIsolatedActiveRecordCriteria' => 'Matryoshka\Model\Wrapper\Mongo\Criteria\ActiveRecord\ActiveRecordCriteria'
        ],
        'shared' => [
            // Do not share instance of ResultSet to avoid collisions on prototype strategies,
            'Matryoshka\Model\Wrapper\Mongo\ResultSet\HydratingResultSet' => false,
        ]
    ],
    'mongodb' => [
        'Mongo\Db' => [
            'database' => 'strapieno',
        ],
    ],
    'mongocollection' => [
        'DataGateway\Mongo\Place' => [
            'database' => 'Mongo\Db',
            'collection' => 'place',
        ],
    ],
    'matryoshka-objects' => [
        'Place' => [
            'type' => 'Strapieno\Place\Model\Entity\PlaceEntity',
            'active_record_criteria' => 'Strapieno\Model\Criteria\NotIsolatedActiveRecordCriteria'
        ]
    ],
    'matryoshka-models' => [
        'Strapieno\Place\Model\PlaceModelService' => [
            'datagateway' => 'DataGateway\Mongo\Place',
            'type' => 'Strapieno\Place\Model\PlaceModelService',
            'object' => 'Place',
            'resultset' => 'Strapieno\Model\ResultSet\HydratingResultSet',
            'paginator_criteria' => 'Strapieno\Place\Model\Criteria\PlaceCollectionCriteria',
            'hydrator' => 'Strapieno\Place\Model\Hydrator\PlaceModelMongoHydrator',
            'listeners' => [
                'Strapieno\Utils\Model\Listener\DateAwareListener',
            ],
        ],
    ],
    'strapieno_input_filter_specs' => [
        'Strapieno\Place\Model\InputFilter\DefaultPostalAddressInputFilter' => [
            'address_locality' => [
                'require' => false,
                'allow_empty' => true,
                'name' => 'address_locality',
                'filters' => [
                    'stringtrim' =>  [
                        'name' => 'stringtrim',
                    ]
                ]
                // TODO add validator
            ],
            'address_region' => [
                'require' => false,
                'allow_empty' => true,
                'name' => 'address_region',
                'filters' => [
                    'stringtrim' =>  [
                        'name' => 'stringtrim',
                    ]
                ]
                // TODO add validator
            ],

            'postal_code' => [
                'require' => false,
                'allow_empty' => true,
                'name' => 'postal_code',
                'filters' => [
                    'stringtrim' =>  [
                        'name' => 'stringtrim',
                    ]
                ]
                // TODO add validator
            ],

            'street_address' => [
                'require' => false,
                'allow_empty' => true,
                'name' => 'street_address',
                'filters' => [
                    'stringtrim' =>  [
                        'name' => 'stringtrim',
                    ]
                ]
                // TODO add validator
            ],

            'address_country' => [
                'require' => false,
                'allow_empty' => true,
                'name' => 'address_country',
                'filters' => [
                    'stringtrim' =>  [
                        'name' => 'stringtrim',
                    ]
                ]
                // TODO add validator
            ],
        ],
        'Strapieno\Place\Model\InputFilter\DefaultGeoCoordiateInputFilter' => [
            'latitude' => [
                'require' => false,
                'allow_empty' => true,
                'name' => 'latitude',
                'filters' => [
                    'stringtrim' =>  [
                        'name' => 'stringtrim',
                    ]
                ],
                'validators' => [
                    'latitude' => [
                        'name' => 'latitude'
                    ]
                ]
            ],
            'longitude' => [
                'require' => false,
                'allow_empty' => true,
                'name' => 'longitude',
                'filters' => [
                    'stringtrim' =>  [
                        'name' => 'stringtrim',
                    ]
                ],
                'validators' => [
                    'longitude' => [
                        'name' => 'longitude'
                    ]
                ]
            ],
            'elevation' => [
                'require' => false,
                'allow_empty' => true,
                'name' => 'elevation',
                'filters' => [
                    'stringtrim' =>  [
                        'name' => 'stringtrim',
                    ]
                ],
                'validators' => [
                    'longitude' => [
                        'name' => 'between',
                        'options' => [
                            'min' => -10994, // Challenger Abyss
                            'max' => 8848 // Everest
                        ],
                    ]
                ]

            ],
        ],
        'Strapieno\Place\Model\InputFilter\DefaultInputFilter' => [
            // TODO wrong shold stay in api module
            'user_id' => [
                'require' => false,
                'allow_empty' => true,
                'name' => 'user_id',
                'validators' => [
                    'user-entityexist' => [
                        'name' => 'user-entityexist'
                    ]
                ]

            ],
            'fax_number' => [
                'require' => false,
                'allow_empty' => true,
                'name' => 'fax_number',
                'filters' => [
                    'stringtrim' =>  [
                        'name' => 'stringtrim',
                    ]
                ]
                // TODO add validator
            ],
            'telephone' => [
                'require' => false,
                'allow_empty' => true,
                'name' => 'telephone',
                'filters' => [
                    'stringtrim' =>  [
                        'name' => 'stringtrim',
                    ]
                ]
                // TODO add validator
            ],
            'name' => [
                'require' => false,
                'allow_empty' => true,
                'name' => 'name',
                'filters' => [
                    'stringtrim' =>  [
                        'name' => 'stringtrim',
                    ]
                ]
            ],
            'geo_coordinate' => [
                'name' => 'geo_coordinate',
                'type' => 'Strapieno\Place\Model\InputFilter\DefaultGeoCoordiateInputFilter'
            ],
            'postal_address' => [
                'name' => 'postal_address',
                'type' => 'Strapieno\Place\Model\InputFilter\DefaultPostalAddressInputFilter'
            ],
        ],
    ]
];
