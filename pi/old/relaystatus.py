import minimalmodbus
import MySQLdb
import mysql.connector
import datetime
import time
import RPi.GPIO as GPIO

R1 = 26
R2 = 20
R3 = 21

GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)

GPIO.setup(R1,GPIO.OUT)
GPIO.setup(R2,GPIO.OUT)
GPIO.setup(R3,GPIO.OUT)

print GPIO.input(R1)
print GPIO.input(R2)
print GPIO.input(R3)

