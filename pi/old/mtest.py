#!/usr/bin/env python
# This Python file uses the following encoding: utf-8
import minimalmodbus
import MySQLdb
import mysql.connector
import datetime
import numpy as np
x=1
reg=17
mydb = mysql.connector.connect(host="localhost",user="mdata",passwd="modbus2018",database="modbus")
mycursor = mydb.cursor()
sql = "UPDATE mdata SET m3='6' WHERE id=17"
mycursor.execute(sql)
mydb.commit()
