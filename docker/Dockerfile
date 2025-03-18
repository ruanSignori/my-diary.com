FROM webdevops/php-nginx:8.2-alpine

# Variáveis de ambiente
ENV NODE_VERSION=22.13.1
ENV NPM_VERSION=10.9.1

# Utilitários
RUN apk add --no-cache curl

# Permissões
RUN chmod +x /opt/docker/bin/entrypoint.sh

# Instalação do NodeJS e NPM
RUN curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION} | bash - \
    apk add --no-cache nodejs \
    curl -L https://www.npmjs.com/install.sh | VERSION=${NPM_VERSION} sh

#Porta do PHP-FPM
EXPOSE 9000

ENTRYPOINT ["/opt/docker/bin/entrypoint.sh"]