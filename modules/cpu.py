#!/usr/bin/python3
import json, psutil
percentPerCpu = psutil.cpu_percent(interval=1, percpu=True)
percentTotal = 0
for cpu in percentPerCpu:
    percentTotal = percentTotal + cpu
percentTotal = percentTotal / len(percentPerCpu)
data = {
    "cpu": {
        "total": percentTotal,
        "core": {
        }
    }
}
count=0
for cpu in percentPerCpu:
    data["cpu"]["core"]["cpu"+str(count)]=cpu
    count=count+1
print(json.dumps(data, sort_keys=True, indent=4))
