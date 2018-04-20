import socket
import sqlite3
import re
import ipaddress
import sys
import multiprocessing
from optparse import OptionParser
import net_list

for item in net_list.net_list:
    print(net_list.net_list[item])

sys.exit()

manager6=multiprocessing.Manager().list()

def parse_options():
    usage = "usage: %prog [options]"
    parser = OptionParser(usage)
    parser.add_option('-n', '--network', dest='network',
                      help="""The scan network or host
                            192.168.0.100 for single host
                            192.168.0.100/24 for a network""")
    options = parser.parse_args()[0]
    return options


def sock(address):
    global manager6
    address=address.exploded
    try:
        a=socket.create_connection((address, 445),timeout=1)
        manager6.append(address)
    except:
        pass

def tr01(hosts):
    # print(addresses)

    # print(dir(manager))
    pool=multiprocessing.Pool(processes=255)
    pool.map(sock,hosts)
    pool.close()
    pool.join()




network=ipaddress.ip_network(parse_options().network)

tr01(network)
print(manager6)
# print(addresses)
