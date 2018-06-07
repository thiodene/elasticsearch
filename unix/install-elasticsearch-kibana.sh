#!/usr/bin/env bash
echo "
[elasticsearch-5.x]
name=Elasticsearch repository for 6.x packages
baseurl=https://artifacts.elastic.co/packages/6.x/yum
gpgcheck=1
gpgkey=https://artifacts.elastic.co/GPG-KEY-elasticsearch
enabled=1
autorefresh=1
type=rpm-md

" > /etc/yum.repos.d/elk.repo


sudo yum -y install java-1.8.0-openjdk elasticsearch kibana logstash epel-release nginx httpd-tools


#nginx
sudo htpasswd -b -c /etc/nginx/htpasswd.users adki 82hncFGasdlasd
sudo htpasswd -b -c /etc/nginx/conf.d/$(hostname -f).htpasswd adki 82hncFGasdlasd
echo "server {
listen 80;
server_name kibana;
auth_basic RestrictedAccess;
auth_basic_user_file /etc/nginx/conf.d/$(hostname -f).htpasswd;
    location / {
    proxy_pass http://localhost:5601;
    proxy_http_version 1.1;
    proxy_set_header Upgrade \$http_upgrade;
    proxy_set_header Connection 'upgrade';
    proxy_set_header Host \$host;
    proxy_cache_bypass \$http_upgrade;
    }
}" > /etc/nginx/conf.d/kibana.conf
echo "server {
listen 9201;
server_name elasticsearch;
auth_basic RestrictedAccess;
auth_basic_user_file /etc/nginx/conf.d/$(hostname -f).htpasswd;
    location / {
    proxy_pass http://localhost:9200;
    proxy_http_version 1.1;
    proxy_set_header Upgrade \$http_upgrade;
    proxy_set_header Connection 'upgrade';
    proxy_set_header Host \$host;
    proxy_cache_bypass \$http_upgrade;
    }
}" > /etc/nginx/conf.d/elasticsearch.conf

sed -i 's/80 /6400 /g'  /etc/nginx/nginx.conf
#sed -i 's/default_server;/default_server; deny all; /g'  /etc/nginx/nginx.conf

sed -i 's/#cluster.name: my-application/cluster.name: sims/g'  /etc/elasticsearch/elasticsearch.yml
sed -i 's/#node.name: node-1/node.name: node-1/g'  /etc/elasticsearch/elasticsearch.yml


sudo systemctl start elasticsearch.service
sudo systemctl start kibana.service
sudo systemctl start logstash.service
sudo systemctl start nginx

sudo systemctl daemon-reload
sudo systemctl enable kibana.service
sudo systemctl enable elasticsearch.service
sudo systemctl enable logstash.service
sudo systemctl enable nginx

sudo firewall-cmd --zone=public --add-port=80/tcp --permanent
sudo firewall-cmd --zone=public --add-port=9201/tcp --permanent
sudo firewall-cmd --zone=public --add-port=12201/udp --permanent
sudo firewall-cmd --zone=public --add-service=http --permanent
sudo firewall-cmd --reload
echo "installation done"
