#!/usr/bin/python3
import json, psutil
storage = psutil.disk_usage('/')
data = {
    "storage": {
        "root": {
            "total": int(storage.total / 1000000),
            "used": int(storage.used / 1000000),
            "free": int(storage.free / 1000000),
            "percent": storage.percent
        }
    }
}
print(json.dumps(data, sort_keys=True, indent=4))
