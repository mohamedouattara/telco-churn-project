FROM tensorflow/tensorflow:1.12.0-py3
MAINTAINER b.guedou@kernel-ia.com
ENV DEBIAN_FRONTEND noninteractives
ADD requirements.txt /root/

RUN python -m pip install --upgrade pip && \
	python -m pip install --no-cache-dir -r /root/requirements.txt\
	&& rm -rf /var/lib/apt/lists/*

#RUN mkdir ./apps &&\
#        mkdir ./storage

EXPOSE 5000
EXPOSE 8888
VOLUME /apps
VOLUME /storage
