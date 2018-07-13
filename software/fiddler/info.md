# Execute commands for ElasticSearch given a URL, a Header, a Body and a method
Example:
URL: 
http://localhost:9200/company
http://localhost:9200/company/employee/_search
http://localhost:9200/vehicles/car/_search
http://localhost:9200/vehicles/bike/_search
http://localhost:9200/vehicles/truck/_search

HEADER: Content-type: application/json

METHOD: PUT, GET, POST....

BODY: 
  PUT
  {
  "settings": {
     "index": {
           "number_of_shards": 1,
           "number_of_replicas": 1
     },
     "analysis": {
       "analyzer": {
         "analyzer-name": {
               "type": "custom",
               "tokenizer": "keyword",
               "filter": "lowercase"
         }
       }
     },
     "mappings": {
       "employee": {
         "properties": {
           "age": {
                 "type": "long"
           },
           "experienceInYears": {
                 "type": "long"      
           },
           "name": {
                 "type": "string",
                 "analyzer": "analyzer-name"
           }
         }
       }
     }
   }  
  }

