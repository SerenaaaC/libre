ip=$(hostname -I | xargs)
echo $ip
php -S $ip:9000
#php -S 192.168.1.115:9000
