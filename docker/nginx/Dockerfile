FROM nginx

RUN apt-get update
RUN apt-get install -y \
    iputils-ping \
    nano

ADD nginx.conf /etc/nginx/
ADD server.conf /etc/nginx/
