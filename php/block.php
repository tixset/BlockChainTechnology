<?php

class block
{
    public $previousHash;
    public $timestamp;
    public $data;
    public $hash;
}

function addBlock($data, $blockChain) {
	$blockChain[] = new block();
	$count = count($blockChain);
	$block = $blockChain[$count - 1];
	if ($count != 1) $block->previousHash = $blockChain[$count - 2]->hash;
	$block->timestamp = time();
	$block->data = $data;
	$block->hash = md5(($count - 1) . $block->previousHash . $block->timestamp . $data);
	return $blockChain;
}

function chainVerify($blockChain) {
	$res = 0;
	for ($i = 0; $i <= count($blockChain) - 1; $i++) {
		$block = $blockChain[$i];
		$previousHash = "";
		if ($i != 0) $previousHash = $blockChain[$i - 1]->hash;
		$timestamp = $block->timestamp;
		$data = $block->data;
		if ($block->hash != md5(($i) . $previousHash . $timestamp . $data)) {
			$res = $i;
			break;
		}
	}
	return $res;
}

function chainsCompare($blockChain1, $blockChain2) {
	if (!chainVerify($blockChain1)) return 0;
	if (!chainVerify($blockChain2)) return 0;
	if (count($blockChain1) != count($blockChain2)) return 0;
	return $blockChain1[count($blockChain1) - 1]->hash == $blockChain2[count($blockChain2) - 1]->hash ? 1 : 0;
}

function printBlock($id, $blockChain) {
	$block = $blockChain[$id];
	echo "ID: $id\n";
	echo "Предыдущий хэш: $block->previousHash\n";
	echo "Дата/время: " . date('Y-m-d/H:i:s', $block->timestamp) . "\n";
	echo "Данные: $block->data\n";
	echo "Хэш: $block->hash\n";
}

function printVerify($blockChain) {
	$res = chainVerify($blockChain);
	echo $res == 0 ? "Верификация цепочки: ok\n" : "Верификация цепочки: ошибка в блоке #$res\n";
}

?>