#!/usr/bin/python3
import json, psutil
mem = psutil.virtual_memory()
swap = psutil.swap_memory()
print(
    json.dumps(
        {
            "ram": {
                "total": int(mem.free/1000000),
                "available": int(mem.available/1000000),
                "percent": mem.percent,
                "used": int(mem.used/1000000),
                "free": int(mem.free/1000000)
            },
            "swap": {
                "total": int(swap.total/1000000),
                "used": int(swap.used/1000000),
                "free": int(swap.free/1000000),
                "percent": swap.percent,
                "sin": int(swap.sin/1000000),
                "sout": int(swap.sout/1000000)
            }
        },
        sort_keys=True,
        indent=4
    )
)
