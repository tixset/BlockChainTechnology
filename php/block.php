<?php

class BlockChain
{
    public $previousHash;
    public $timestamp;
    public $data;
    public $hash;
}

function addBlock($BlockChain, $data) {
	$BlockChain[] = new BlockChain();
	$count = count($BlockChain);
	$Block = $BlockChain[$count - 1];
	if ($count != 1) $Block->previousHash = $BlockChain[$count - 2]->hash;
	$Block->timestamp = time();
	$Block->data = $data;
	$Block->hash = md5(($count - 1) . $Block->previousHash . $Block->timestamp . $data);
	return $BlockChain;
}

function chainVerify($BlockChain) {
	$res = 0;
	for ($i = 0; $i <= count($BlockChain) - 1; $i++) {
		$Block = $BlockChain[$i];
		$previousHash = "";
		if ($i != 0) $previousHash = $BlockChain[$i - 1]->hash;
		$timestamp = $Block->timestamp;
		$data = $Block->data;
		if ($Block->hash != md5(($i) . $previousHash . $timestamp . $data)) {
			$res = $i;
			break;
		}
	}
	return $res;
}

function chainsСompare($BlockChain1, $BlockChain2) {
	if (!chainVerify($BlockChain1)) return 0;
	if (!chainVerify($BlockChain2)) return 0;
	if (count($BlockChain1) != count($BlockChain2)) return 0;
	return $BlockChain1[count($BlockChain1) - 1]->hash == $BlockChain2[count($BlockChain2) - 1]->hash ? 1 : 0;
}

function printBlock($BlockChain, $id) {
	$Block = $BlockChain[$id];
	echo "ID: " . $id . "\n";
	echo "Предыдущий хэш: " . $Block->previousHash . "\n";
	echo "Время: " . date('Y-m-d H:i:s', $Block->timestamp) . "\n";
	echo "Данные: " . $Block->data . "\n";
	echo "Хэш: " . $Block->hash . "\n";
}

function printVerify($BlockChain) {
	$res = chainVerify($BlockChain);
	echo $res == 0 ? "Верификация: ok\n" : "Верификация: ошибка в записи #". $res . "\n";
}

?>
