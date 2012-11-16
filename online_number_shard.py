#!/usr/bin/env python
# coding: utf-8
"""
Use three client to auto split and insert data
Test the performance with split and safe in multiple client environment
"""
from time import sleep
import salt.client
client = salt.client.LocalClient()


def main():
    for i in xrange(0, 20):
        print('Without presplit, safe')
        split(False)
        insert(False)
        sleep(20)
        # print('')

        print('Presplit without safe')
        split(True)
        insert(False)
        sleep(20)

        print('Safe without presplit')
        split(False)
        insert(True)
        sleep(20)

        print('Presplit with safe')
        split(True)
        insert(True)
        sleep(20)


def split(cut):
    if cut:
        cmd = 'php /var/www/random_split.php -c'
    else:
        cmd = 'php /var/www/random_split.php'
    result = client.cmd('web-mongo.hsng.org', 'cmd.run', [cmd], 20)
    print(result)


def insert(safe):
    if safe:
        cmd = 'php /var/www/online_number_shard.php -s'
    else:
        cmd = 'php /var/www/online_number_shard.php'
    result = client.cmd('web-mongo*', 'cmd.run', [cmd], 1000)
    for key in result:
        print(result[key])

if __name__ == '__main__':
    main()
