#!/usr/bin/env python
# This Python file uses the following encoding: utf-8
import minimalmodbus
import MySQLdb
import mysql.connector
import datetime
import numpy as np
mydb = mysql.connector.connect(host="localhost",user="mdata",passwd="modbus2018",database="modbus")
mycursor = mydb.cursor()
mycursor.execute( """select m2 from mdata where id=17;""")
m1relay =bool(mycursor.fetchone()[0])

if m1relay:
	sql = "UPDATE mdata SET m2=0 WHERE id=17;"
	mycursor.execute(sql)
	mydb.commit()
else :
	sql = "UPDATE mdata SET m2=1 WHERE id=17"
        mycursor.execute(sql)
        mydb.commit()

