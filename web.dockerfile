FROM nginx:1.10

ADD config/vhost.conf /etc/nginx/conf.d/default.conf
