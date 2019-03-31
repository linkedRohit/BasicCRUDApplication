#!/bin/bash
python /apps/jpgateway/current/app/cluster/deployer.py
#mkdir -p /apps/recruiterGNB && ln -s /apps/jpgateway/current/vendor/recruiterGnb /apps/recruiterGNB/current
mkdir -p /apps/jpgateway/current/app/logs/
mkdir -p /apps/jpgateway/current/app/cache/
chmod -R 777 /apps/jpgateway/current/app/cache/ /apps/jpgateway/current/app/logs/
