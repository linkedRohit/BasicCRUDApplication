FROM docker.infoedge.com:5000/infra/php-builder7 as devicedetectorsource
RUN mkdir -p /apps/DeviceDetector && \
   cd /apps/DeviceDetector && \
   git clone http://gitdeployer:gitdeployer@gitlab.infoedge.com/naukrilibs/devicedetectorserver.git current
RUN mkdir -p /apps/CentralConfig && \
   cd /apps/CentralConfig && \
   git clone http://gitdeployer:gitdeployer@gitlab.infoedge.com/naukrilibs/centralconfig.git current

FROM docker.infoedge.com:5000/infra/symfonysource as symfony

FROM docker.infoedge.com:5000/infra/php-builder7 as deployersource
COPY --from=symfony /usr/local/Symfony2.8.26.1 /usr/local/symfony

ADD . /apps/jpgateway/current
WORKDIR /apps/jpgateway/current
RUN php composer.phar dump-autoload -o

FROM docker.infoedge.com:5000/infra/sourcecode
COPY --from=deployersource /apps/jpgateway/ /apps/jpgateway/
COPY --from=devicedetectorsource /apps/DeviceDetector/ /apps/DeviceDetector/
COPY --from=devicedetectorsource /apps/CentralConfig /apps/CentralConfig
COPY --from=deployersource /usr/local/symfony /usr/local/symfony
WORKDIR /apps/jpgateway/current
ADD app/cluster/deployer.sh /docker/execs/3_url.sh
RUN chmod +x /docker/execs
