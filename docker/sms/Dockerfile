FROM ubuntu:18.04

LABEL maintainer="Samson Endale"

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get -y upgrade \
    && apt-get install -y kannel supervisor

RUN mkdir -p /var/spool/kannel /var/log/kannel \
    && rm -rf /etc/init.d/kannel

ADD kannel.conf /etc/kannel/kannel.conf
ADD supervisord.conf /etc/supervisor/conf.d/supervisord.conf
ADD start-container.sh /usr/bin/start-container
RUN chmod +x /usr/bin/start-container

ENTRYPOINT ["start-container"]
