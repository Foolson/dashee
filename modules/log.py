#!/usr/bin/python3
import json, subprocess
log = subprocess.Popen(['journalctl', '--no-pager', '-n 10', '-q'])
print (
    log
)
