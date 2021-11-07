var CLASSES = {};
CLASSES.block = class block {
    constructor(previousHash, timestamp, data, hash) {
        this.previousHash = previousHash;
        this.timestamp = timestamp;
        this.data = data;
        this.hash = hash;
    }
}

function timestampToDate(ts) {
    var d = new Date();
    d.setTime(ts);
    return  d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2) + " " + ('0' + d.getHours()).slice(-2) + ':' + ('0' + d.getMinutes()).slice(-2) + ':' + ('0' + d.getSeconds()).slice(-2);
}

function addBlock(data, blockChain) {
	count = blockChain.length;
	previousHash = count == 0 ? "" : blockChain[count - 1].hash;
	timestamp = Date.now();
	hash = md5((count) + previousHash + timestamp + data);
	blockChain[count] = new CLASSES.block(previousHash, timestamp, data, hash);
	return blockChain;
}

function chainVerify(blockChain) {
	res = 0;
	for (let i = 0; i <= blockChain.length - 1; i++) {
		block = blockChain[i];
		previousHash = "";
		if (i != 0) previousHash = blockChain[i - 1].hash;
		timestamp = block.timestamp;
		data = block.data;
		if (block.hash != md5((i) + previousHash + timestamp + data)) {
			res = i;
			break;
		}
	}
	return res;
}

function chainsCompare(blockChain1, blockChain2) {
	if (!chainVerify(blockChain1)) return 0;
	if (!chainVerify(blockChain2)) return 0;
	if (blockChain1.length != blockChain2.length) return 0;
	return blockChain1[blockChain1.length - 1].hash == blockChain2[blockChain2.length - 1].hash ? 1 : 0;
}

function printBlock(id, blockChain) {
	block = blockChain[id];
	console.log("ID: " + id);
	console.log("Предыдущий хэш: " + block.previousHash);
	console.log("Дата/время: " + timestampToDate(block.timestamp));
	console.log("Данные: " + block.data);
	console.log("Хэш: " + block.hash);
}

function printVerify(blockChain) {
	res = chainVerify(blockChain);
	console.log(res == 0 ? "Верификация цепочки: ok" : "Верификация цепочки: ошибка в блоке #" + res);
}