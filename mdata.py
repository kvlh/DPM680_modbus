#!/usr/bin/env python
# This Python file uses the following encoding: utf-8
import minimalmodbus
import MySQLdb
import mysql.connector
import datetime
import numpy as np
instrument1 = minimalmodbus.Instrument('/dev/ttyUSB0', 1) # port name, slave address (in decimal)
instrument1.serial.baudrate =38400
instrument2 = minimalmodbus.Instrument('/dev/ttyUSB0', 2) # port name, slave address (in decimal)
instrument2.serial.baudrate =38400
instrument3 = minimalmodbus.Instrument('/dev/ttyUSB0', 3) # port name, slave address (in decimal)
instrument3.serial.baudrate =38400

def append_hex(a, b):
    sizeof_b = 0

    # get size of b in bits
    while((b >> sizeof_b) > 0):
        sizeof_b += 1

    # align answer to nearest 4 bits (hex digit)
    sizeof_b += sizeof_b % 4

    return (a << sizeof_b) | b

mydb = mysql.connector.connect(host="localhost",user="mdata",passwd="modbus2018",database="modbus")
addr = np.matrix([
[4013,4019,4021,4023,4025,4027,4029,4031,4033,4035,4037,4039,4041,4043,4045],
[0.0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]])


#Odczyt modbus
dim = addr.shape
for j in range(0,dim[1]):
	address=int(addr.item((0,j)))
	x =  instrument1.read_register(address,0)
	addr.itemset((1,j),x)

for j in range(0,dim[1]):
	address=int(addr.item((0,j)))
	x = instrument2.read_register(address,0)
	addr.itemset((2,j),x)

for j in range(0,dim[1]):
        address=int(addr.item((0,j)))
        x = instrument3.read_register(address,0)
        addr.itemset((3,j),x)

#Konwersja wartości - Częstotliwość
for j in range(1,dim[0]):
	x=float(addr.item((j,1)))
	x=x/100
	addr.itemset((j,1),x)
#Konwertsja wartości - prąd chwilowy
for i in range(2,6):
	for j in range(1,dim[0]):
		x=float(addr.item((j,i)))
		x=x/1000
		addr.itemset((j,i),x)
#Konwersja wartości - napięcie miedzyfazowe i fazowe
for i in range(6,12):
        for j in range(1,dim[0]):
                x=float(addr.item((j,i)))
                x=x/10
                addr.itemset((j,i),x)
#zapis do bazy danych
for j in range(0,dim[1]):
	x=float(addr.item((1,j)))
	reg=addr.item((0,j))
	mycursor = mydb.cursor()
	sql = """UPDATE mdata SET m1='%s' WHERE register ='%s'"""
	val = (x,reg)
	mycursor.execute(sql,val)

for j in range(0,dim[1]):
        x=float(addr.item((2,j)))
        reg=addr.item((0,j))
        mycursor = mydb.cursor()
        sql = """UPDATE mdata SET m2='%s' WHERE register ='%s'"""
        val = (x,reg)
        mycursor.execute(sql,val)

for j in range(0,dim[1]):
        x=float(addr.item((3,j)))
        reg=addr.item((0,j))
        mycursor = mydb.cursor()
        sql = """UPDATE mdata SET m3='%s' WHERE register ='%s'"""
        val = (x,reg)
        mycursor.execute(sql,val)


mydb.commit()
print(mycursor.rowcount, "record inserted.")




#print(addr)
## 4012-13 Całkowita moc rzeczywista
## 4019 Częstotliwość
## 4020-21 Prąd chwilowy A
## 4022-23 Prąd chwilowy B
## 4024-25 Prąd chwilowy C
## 4026-27 Prąd chwilowy N
## 4028-29 Napięcie miedzyfacowe AB
## 4030-31 Napięcie miedzyfazowe BC
## 4032-33 Napięcie miedzyfazowe AC
## 4034-35 Napięcie fazowe AN
## 4036-37 Napięcie fazowe BN
## 4038-39 Napięcie fazowe CN
## 4040-41 Moc rzeczywista A
## 4042-43 Moc rzeczywista B
## 4044-45 Moc rzeczywista C

