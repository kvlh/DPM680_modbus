#!/usr/bin/env python
# This Python file uses the following encoding: utf-8
import minimalmodbus
import MySQLdb
import mysql.connector
import datetime

instrument = minimalmodbus.Instrument('/dev/ttyUSB0', 1) # port name, slave address (in decimal)
instrument.serial.baudrate =38400

def append_hex(a, b):
    sizeof_b = 0

    # get size of b in bits
    while((b >> sizeof_b) > 0):
        sizeof_b += 1

    # align answer to nearest 4 bits (hex digit)
    sizeof_b += sizeof_b % 4

    return (a << sizeof_b) | b

var1 =  instrument.read_register(4000,0) # Registernumber, number of decimals
var2 =  instrument.read_register(4001,0) # Registernumber, number of decimals
var3 =  instrument.read_register(4002,0) # Registernumber, number of decimals
var4 =  instrument.read_register(4003,0) # Registernumber, number of decimals

tmp1 =(append_hex(var1, var2))
tmp2 =(append_hex(tmp1, var3))
var =(append_hex(tmp2, var4))
var=float(var)
var=var/1000


print  var
