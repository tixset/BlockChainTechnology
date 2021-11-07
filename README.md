# Пример простой реализации технологии Блокчейн на нескольких ЯП 

*Блокчейн — непрерывная последовательная цепочка блоков (связный список), содержащих информацию. Связь между блоками обеспечивается не только нумерацией, но и тем, что каждый блок содержит свою собственную хэш-сумму и хэш-сумму предыдущего блока.*

Таким образом если изменить данные какого-либо блока в цепочке то хэш-суммы последующих блоков перестанут быть валидными, что позволяет не допустить подмену данных в цепочке.
Конечно же злоумышленник может перестроить все блоки в цепочке заново, для того чтобы этого не допустить, существуют децентрализованные базы данных в которых можно хранить копию нашей цепочки блоков и при необходимости сверять их.

Но в данном примере я рассмотрю только построение цепочки блоков и ее верификацию, а так же предусмотрю функцию сравнения двух цепочек.

Блок в нашем примере имеет следующую структуру:
```php
class block {
    public $previousHash;
    public $timestamp;
    public $data - данные ;
    public $hash;
}
```
* previousHash - это хэш предыдущего блока (в первом блоке этот элемент пустой)
* timestamp - дата и время в формате Unix timestamp
* data - данные
* hash - хэш этого блок

Хэш блока создается из конкатенации (склеивания строк) предыдущих полей и порядкового номера блока в цепочке.

При верификации цепочки блоков функция проходит в цикле по каждому элементу цепочки повторно вычисляя их хэш и сравнивает с тем хешем который записан в поле "hash" каждого блока. Если функция находит блок с несоответствующим хэшем, то выводит его порядковый номер и прерывает цикл, иначе выводит значение "0".

Пример записи пяти блоков и попытки модификации одного из них:
```php
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
```

Далее я предусмотрел функцию сравнения двух цепочек блоков необходимую если понадобится сравнивать данные хранящиеся в нескольких разных БД.
При сравнении сначала выполняется верификация двух цепочек поступающих на вход функции, а далее сравнивается количество блоков и хэши последнего блока.

Пример вызова функции сравнивания:
```php
echo chainsCompare($blockChain1, $blockChain2);
```
Если цепочки идентичны, то функция вернет значение "1", иначе "0".

---

# An example of a simple implementation of Blockchain technology in several programming languages

*Blockchain is a continuous sequential chain of blocks (a connected list) containing information. The connection between the blocks is provided not only by numbering, but also by the fact that each block contains its own hash sum and the hash sum of the previous block.*

Thus, if you change the data of any block in the chain, the hash sums of subsequent blocks will cease to be valid, which prevents the substitution of data in the chain.
Of course, an attacker can rebuild all the blocks in the chain anew, in order to prevent this, there are decentralized databases in which you can store a copy of our block chain and, if necessary, verify them.

But in this example, I will consider only the construction of a block chain and its verification, as well as provide a function for comparing two chains.

The block in our example has the following structure`
```php
class block {
public $previoushash;
public $timestamp;
public $data - data ;
public $hash;
}
```
* previousHash is the hash of the previous block (in the first block this element is empty)
* timestamp - date and time in Unix timestamp format
* data - data
* hash - hash of this block

The hash of the block is created from the concatenation (gluing strings) of the previous fields and the sequence number of the block in the chain.

When verifying the block chain, the function runs in a loop through each element of the chain, re-calculating their hash and comparing it with the hash that is written in the "hash" field of each block. If the function finds a block with an inappropriate hash, it outputs its sequence number and interrupts the loop, otherwise it outputs the value "0".

Example of recording five blocks and attempting to modify one of them:
```php
<?php
require_once(__DIR__ . '/block.php '); // Connecting the library

$blockchain = array(); // Declaring an array of blocks

for ($i = 0; $i < 5; $i++) { // Creating 5 blocks
$blockchain = AddBlock("Data $i", $blockchain); // Creating a block
printBlock($i, $blockchain); // Output
printVerify($blockchain) data; // Check the integrity of the chain
echo "\n";
}

echo "Modified data\n";
$blockchain[2]->data = "Modified data"; // Changing printBlock data
(2, $blockchain); // Output data
printVerify($blockchain); // Check the integrity of the chain

?>
```

Next, I provided a function for comparing two block chains, which is necessary if you need to compare data stored in several different databases.
When comparing, two chains of incoming functions are verified first, and then the number of blocks and the hashes of the last block are compared.

Example of calling the comparison function:
```php
echo chainsCompare($blockChain1, $blockChain2);
```
If the chains are identical, the function will return the value "1", otherwise "0".
