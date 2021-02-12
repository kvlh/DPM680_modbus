import minimalmodbus
import MySQLdb
import mysql.connector
import datetime
import time
import RPi.GPIO as GPIO

R1 = 26
R2 = 21
R3 = 20

GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)

GPIO.setup(R1,GPIO.OUT)
GPIO.setup(R2,GPIO.OUT)
GPIO.setup(R3,GPIO.OUT)

mydb = mysql.connector.connect(host="localhost",user="mdata",passwd="modbus2018",database="modbus")
mycursor = mydb.cursor()

mycursor.execute( """select m1 from mdata where id=17;""")
m1relay =bool(mycursor.fetchone()[0])
mycursor.execute( """select m2 from mdata where id=17;""")
m2relay =bool(mycursor.fetchone()[0])
mycursor.execute( """select m3 from mdata where id=17;""")
m3relay =bool(mycursor.fetchone()[0])

if m1relay==1:
	GPIO.output(R1,0)
else :
	GPIO.output(R1,1)

if m2relay==1:
	GPIO.output(R2,0)
else :
        GPIO.output(R2,1)

if m3relay==1:
        GPIO.output(R3,0)
else :
        GPIO.output(R3,1)



#if m1relay=GPIO.input(R1):
#	GPIO.output(R1,m1relay)

#if m2relay=GPIO.input(R2):
 #       GPIO.output(R2,m2relay)

#if m3relay=GPIO.input(R3):
 #       GPIO.output(R3,m3relay)

print GPIO.input(R1)
print GPIO.input(R2)
print GPIO.input(R3)


mydb.close()

