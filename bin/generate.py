#!/usr/bin/env python3

############################################
# File Name : generate2.py
# Purpose : generate fake database for test the project
# Creation Date : 21-03-2019
# Last Modified : Tue 8 Dec 2020 23:04:12
# Created By : Andrei Prokopenko, BMSTU
############################################

import mysql.connector
import json
import ast
import random
import time

from datetime import datetime

def strTimeProp(start, end, format, prop):
    stime = time.mktime(time.strptime(start, format))
    etime = time.mktime(time.strptime(end, format))

    ptime = stime + prop * (etime - stime)

    return time.strftime(format, time.localtime(ptime))


def randomDate(start, end, prop):
    return strTimeProp(start, end, '%Y/%m/%d %H:%M:%S', prop)


path = ['./data/persons.json', './data/tickets.json', './data/flights.json', './data/details.json'];

mydb = mysql.connector.connect(
  host='localhost',
  user=os.environ.get('COURSE_DB_USER'),
  passwd=os.environ.get('COURSE_DB_PWD'),
  database=os.environ.get('COURSE_DB_NAME'),
)
mycursor = mydb.cursor()
def insertIntoProfile(value):
    sql = 'INSERT INTO profile (firstName, lastName, votes) VALUES (%s, %s, %s)'
    for i in range(100):
        insertion = []
        insertion.append(value[i]['firstName'])
        insertion.append(value[i]['lastName'])
        insertion.append(value[i]['votes'])
        req = tuple(insertion)
        mycursor.execute(sql, req);
        mydb.commit()
    print(mycursor.rowcount, 'was inserted.')

def initTickets(value):
    ts = int(value)
    val = datetime.utcfromtimestamp(ts).strftime('%Y-%m-%d %H-%M-%S')
    return val

def insertIntoTickets(value):
    sql = 'INSERT INTO ticket (uid, user_id, flight_id, class, price) VALUES (default, %s, %s, %s, %s)'
    for i in range(100):
        insertion = []
        insertion.append(value[i]['user_id'])
        insertion.append(value[i]['flight_id'])
        insertion.append(value[i]['class'])
        insertion.append(value[i]['price'])
        req = tuple(insertion)
        mycursor.execute(sql, req);
        mydb.commit()

    print(mycursor.rowcount, 'was inserted.')

def insertIntoFlight(value):
    sql = 'INSERT INTO flight (dep_airport, arr_airport, dep_date) VALUES (%s, %s, %s)'
    for i in range(100):
        insertion = []
        insertion.append(value[i]['dep_airport'])
        insertion.append(value[i]['arr_airport'])
        insertion.append(randomDate('2010/01/01 01:01:01', '2018/01/01 01:01:01', random.random()))#initTickets(int(value[i]['dep_date'])))
        req = tuple(insertion)
        mycursor.execute(sql, req);
        mydb.commit()

    print(mycursor.rowcount, 'was inserted.')

def insertIntoDetail(value):
    sql = 'INSERT INTO detail (profile_id, ticket_id, cur_value, bonus_date) VALUES (%s, %s, %s, %s)'
    for i in range(100):
        insertion = []
        insertion.append(3 + value[i]['profile_id'])
        insertion.append(6 + value[i]['ticket_id'])
        insertion.append(value[i]['cur_value'])
        insertion.append(randomDate('2010/01/01 01:01:01', '2018/01/01 01:01:01', random.random()))#initTickets(int(value[i]['bonus_date'])))
        req = tuple(insertion)
        print(req)
        mycursor.execute(sql, req);
        mydb.commit()
    print(mycursor.rowcount, 'was inserted.')

with open(path[0], 'r', encoding='utf-8') as f:
    data = json.loads(f.read())
    insertIntoProfile(data)
with open(path[2], 'r', encoding='utf-8') as f:
    data = json.loads(f.read())
    insertIntoFlight(data)
with open(path[1], 'r', encoding='utf-8') as f:
    data = json.loads(f.read())
    insertIntoTickets(data)

with open(path[3], 'r', encoding='utf-8') as f:
    data = json.loads(f.read())
    insertIntoDetail(data)

print(mycursor.rowcount, 'was inserted.')
