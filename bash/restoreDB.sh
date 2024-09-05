#!/bin/bash
RED='\033[0;31m' 
NC='\033[0m'

echo 'Fresh migrations'
./vendor/bin/sail artisan migrate:fresh
echo 'Seeding';
./vendor/bin/sail artisan db:seed
echo 'new DB created'

echo -e "${RED}Your servants are waiting for your orders, my Shrimp.$NC"
echo ''