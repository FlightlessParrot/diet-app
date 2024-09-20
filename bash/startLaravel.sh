#!/bin/bash
COLOR='\033[0;32m'
NC='\033[0m'

echo 'Stop mysql and apache [true]? (true or 1)'
read stop;
if [ "$stop" == 'true' -o "$stop" == '1' -o "$stop" = "" ];
then bash ./bash/stopServices.sh;
fi;
sudo sysctl -w kernel.apparmor_restrict_unprivileged_userns=0;
systemctl --user start docker-desktop;
echo -e "${COLOR}I am calling on your servants, my Shrimp.${NC}"
echo 'starting sail';
./vendor/bin/sail up -d;
echo 'Starting node in the sail'
./vendor/bin/sail npm run dev;
