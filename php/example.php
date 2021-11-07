<?php
require_once(__DIR__.'/block.php'); // Подключаем библиотеку
$BlockChain = array(); // Объявляем массив блоков

for ($i = 0; $i < 5; $i++) { // Создаем 5 блоков
	$BlockChain = addBlock($BlockChain, "Данные " . $i); // Создаем блок
	printBlock($BlockChain, $i); // Выводим данные
	printVerify($BlockChain); // Проверяем целосность цепочки
	echo "\n";
}

echo "Измененные данные\n";
$BlockChain[2]->data = "Измененные данные"; // Изменяем данные
printBlock($BlockChain, 2); // Выводим данные
printVerify($BlockChain); // Проверяем целосность цепочки

?>