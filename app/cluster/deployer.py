import fileinput
import os

files = ['/apps/jpgateway/current/app/cluster/cluster.yml','/apps/jpgateway/current/app/cluster/cluster.php']

for f in files:
	for line in fileinput.input(f, inplace=True):
		print line.replace('{{CLUSTER_URL}}', os.environ['CLUSTER_URL'])
