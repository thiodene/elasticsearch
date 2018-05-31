curl -XGET 'http://localhost:9200/blog/_search?pretty=true' -d '
{ 
    "query" : { 
        "range" : { 
            "postDate" : { "from" : "2011-12-10", "to" : "2011-12-12" } 
        } 
    } 
}'
