#!/usr/bin/env python
# coding: utf-8
"""
Use three client to auto split and insert data
Test the performance with split and safe in multiple client environment
"""
import sys
from time import sleep
import salt.client
client = salt.client.LocalClient()


def _max(result):
    m = 0
    for value in result:
        if float(result[value]) > m:
            m = float(result[value])
    return m


def main():
    cmd = 'cd /var/www; php /var/www/multiprocess.php '
    for i in range(0, 10):
        for j in range(0, 5):
            result = client.cmd('web-mongo*.hsng.org',
                                'cmd.run',
                                [cmd + str(i + 1)],
                                20 * (i + 1))
            if j != 0:
                sys.stdout.write(',')
            sys.stdout.write(str(_max(result)))
            # print(result)
            sleep(5)
        print('')
    print('')

    for i in range(0, 10):
        for j in range(0, 5):
            result = client.cmd('web-mysql*.hsng.org',
                                'cmd.run',
                                [cmd + str(i + 1)],
                                40 * (i + 1))
            if j != 0:
                sys.stdout.write(',')
            sys.stdout.write(str(_max(result)))
            # print(result)
            sleep(5)
        print('')

if __name__ == '__main__':
    main()
