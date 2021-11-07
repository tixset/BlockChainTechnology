#!/usr/bin/perl
use lib $ENV{'PWD'}; # Указываем где лежит библиотека
use block; # Подключаем библиотеку

my @blockChain; # Объявляем массив блоков

for (my $i=0; $i < 5; $i++) { # Создаем 5 блоков
        @blockChain = block::addBlock("Данные $i", @blockChain); # Создаем блок
        block::printBlock($i, @blockChain); # Выводим данные
        block::printVerify(@blockChain); # Проверяем целосность цепочки
        print "\n";
}

print "Измененные данные\n";
$blockChain[2]->{data} = "Измененные данные"; # Изменяем данные
block::printBlock(2, @blockChain); # Выводим данные
block::printVerify(@blockChain); # Проверяем целосность цепочки
