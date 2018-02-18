#!/bin/bash

url=''
token=jUvYtJTTwcBRFfqR
route=ip
response=$(curl -s GET "${url}?route=ip&token=${token}")
echo $response
response1=$(curl -s GET "?route=put&token=${token}")
echo $response1