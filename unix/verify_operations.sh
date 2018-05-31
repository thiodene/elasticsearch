# Example of verifying if operations have been successful / Command line

curl -XGET 'http://localhost:9200/blog/user/dilbert?pretty=true'
curl -XGET 'http://localhost:9200/blog/post/1?pretty=true'
curl -XGET 'http://localhost:9200/blog/post/2?pretty=true'
curl -XGET 'http://localhost:9200/blog/post/3?pretty=true'
