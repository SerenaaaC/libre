ip=$(hostname -I | xargs)
php -S $ip:8000
# php -S no hace falta que cambie el IP todos los días ya lo hace solo
# el puerto es :9000
