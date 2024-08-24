#!/bin/bash
RED='\033[0;31m' 
NC='\033[0m'

echo 'Stopping apache'
sudo service apache2 stop
echo 'Stopping mysql'
sudo service mysql stop

echo -e "${RED}I killed them, my Shrimp.$NC"
echo ""
