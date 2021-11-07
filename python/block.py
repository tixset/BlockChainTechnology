#!/usr/bin/env python3
# -*- coding: utf-8 -*-
# encoding=utf8

import sys  
import time
from datetime import datetime
import hashlib

reload(sys)  
sys.setdefaultencoding('utf8')

class block:
    def __init__(self, previousHash, timestamp, data, hash):  
        self.previousHash = previousHash
        self.timestamp = timestamp
        self.data = data
        self.hash = hash

def addBlock(data, blockChain):
    count = len(blockChain)
    previousHash = "" if count == 0 else blockChain[count - 1].hash
    timestamp = int(time.time())
    hash = hashlib.md5((str(count) + previousHash + str(timestamp) + data).encode()).hexdigest()
    blockChain.append(block(previousHash, timestamp, data, hash))
    return blockChain

def chainVerify(blockChain):
    res = 0
    for i in range(0, len(blockChain)):
        block = blockChain[i]
        previousHash = ""
        if (i != 0):
            previousHash = blockChain[i - 1].hash
        timestamp = block.timestamp
        data = block.data
        if (block.hash != hashlib.md5(str(i) + previousHash + str(timestamp) + data).hexdigest()):
            res = i
            break
    return res

def chainsCompare(blockChain1, blockChain2):
    if (not chainVerify(blockChain1)):
        return 0
    if (not chainVerify(blockChain2)):
        return 0
    if (len(blockChain1) != len(blockChain2)):
        return 0
    return 1 if blockChain1[len(blockChain1) - 1].hash == blockChain2[len(blockChain2) - 1].hash else 0

def printBlock(id, blockChain):
    block = blockChain[id]
    print "ID: " + str(id)
    print "Предыдущий хэш: " + block.previousHash
    print "Дата/время: " + datetime.utcfromtimestamp(block.timestamp).strftime('%Y-%m-%d %H:%M:%S')
    print "Данные: " + block.data
    print "Хэш: " + block.hash

def printVerify(blockChain):
    res = chainVerify(blockChain)
    print "Верификация цепочки: ok" if res == 0 else "Верификация цепочки: ошибка в блоке #" + str(res)