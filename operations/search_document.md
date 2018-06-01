#Multi-Index, Multi-Typeedit
#All search APIs can be applied across multiple types within an index, 
#and across multiple indices with support for the multi index syntax. 
#For example, we can search on all documents across all types within the twitter index:
GET /twitter/_search?q=user:kimchy


#We can also search within specific types:
GET /twitter/tweet,user/_search?q=user:kimchy


#We can also search all tweets with a certain tag across several indices (for example, when each user has his own index):
GET /kimchy,elasticsearch/_search?q=tag:wow

#Or we can search all tweets across all available indices using _all placeholder:
GET /_all/_search?q=tag:wow 

#Or even search across all indices and all types:
GET /_search?q=tag:wow
