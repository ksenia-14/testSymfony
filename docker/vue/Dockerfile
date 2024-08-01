FROM node:18.12.1

# External user id
ARG uid

ENV GOSU_VERSION 1.10

#RUN npm install http-server -g

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +sx /usr/local/bin/entrypoint.sh
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

WORKDIR /var/www/html