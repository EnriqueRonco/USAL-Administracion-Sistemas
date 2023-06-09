#!/bin/bash

sa -nac | head -15 | tail +2 > comandos.txt

/usr/bin/perl /root/acct/acct.pl
