#!/usr/bin/env bash
echo "
[elasticsearch-6.x]
name=Elasticsearch repository for 6.x packages
baseurl=https://artifacts.elastic.co/packages/6.x/yum
gpgcheck=1
gpgkey=https://artifacts.elastic.co/GPG-KEY-elasticsearch
enabled=1
autorefresh=1
type=rpm-md

" > /etc/yum.repos.d/elk.repo


sudo yum -y install java-1.8.0-openjdk elasticsearch  epel-release



sed -i 's/#cluster.name: my-application/cluster.name: sims/g'  /etc/elasticsearch/elasticsearch.yml
sed -i 's/#node.name: node-1/node.name: node-3/g'  /etc/elasticsearch/elasticsearch.yml


sudo systemctl start elasticsearch.service

sudo systemctl daemon-reload
sudo systemctl enable elasticsearch.service

sudo firewall-cmd --zone=public --add-service=http --permanent

firewall-cmd --permanent --zone=public --add-rich-rule='
  rule family="ipv4"
  source address="10.99.0.1/24"
  port protocol="tcp" port="9200" accept'
firewall-cmd --permanent --zone=public --add-rich-rule='
  rule family="ipv4"
  source address="10.99.0.1/24"
  port protocol="tcp" port="9300" accept'


sudo firewall-cmd --reload
echo "installation done"
