FROM webdevops/php-nginx:8.2-alpine

# Variáveis de ambiente
ENV NODE_VERSION=22.13.1
ENV NPM_VERSION=10.9.1

# Instalar NodeJs, NPM e dependências
RUN apk add --no-cache bash curl sqlite-dev \
    && curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION} | bash - \
    && apk add --no-cache nodejs npm

# Permissões
RUN chmod +x /opt/docker/bin/entrypoint.sh

# Porta do PHP-FPM
EXPOSE 9000

ENTRYPOINT ["/opt/docker/bin/entrypoint.sh"]
