FROM webdevops/php-nginx:8.2-alpine

# Permissões
RUN chmod +x /opt/docker/bin/entrypoint.sh

# Porta do PHP-FPM
EXPOSE 9000

ENTRYPOINT ["/opt/docker/bin/entrypoint.sh"]
