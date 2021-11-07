#!/usr/bin/env python3
# -*- coding: utf-8 -*-
# encoding=utf8

from block import *

blockChain = [] # Объявляем массив блоков

for i in range(0, 5): # Создаем 5 блоков
    blockChain = addBlock("Данные " + str(i), blockChain) # Создаем блок
    printBlock(i, blockChain) # Выводим данные
    printVerify(blockChain) # Проверяем целосность цепочки
    print ""

print "Измененные данные"
blockChain[2].data = "Измененные данные" # Изменяем данные
printBlock(2, blockChain) # Выводим данные
printVerify(blockChain) # Проверяем целосность цепочки