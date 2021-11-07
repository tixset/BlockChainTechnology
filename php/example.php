<?php
require_once(__DIR__ . '/block.php'); // Подключаем библиотеку

$blockChain = array(); // Объявляем массив блоков

for ($i = 0; $i < 5; $i++) { // Создаем 5 блоков
	$blockChain = addBlock("Данные $i", $blockChain); // Создаем блок
	printBlock($i, $blockChain); // Выводим данные
	printVerify($blockChain); // Проверяем целостность цепочки
	echo "\n";
}

echo "Измененные данные\n";
$blockChain[2]->data = "Измененные данные"; // Изменяем данные
printBlock(2, $blockChain); // Выводим данные
printVerify($blockChain); // Проверяем целостность цепочки

?>
