#!/usr/bin/perl
package block; {

	sub new {
		my($class) = @_;
		my $self = {
		previousHash =>,
		timestamp =>,
		data =>,
		hash =>,
		};
		bless $self, $class;
		return $self;
	}
}

use strict;
use warnings;
use Time::Piece;
use Digest::MD5 qw(md5_hex);

sub addBlock {
	my ($data, @blockChain) = @_;
	my $count = scalar(@blockChain);
	$blockChain[$count] = block->new();
	my $block = $blockChain[$count];
	$block->{previousHash} = $count == 0 ? "" : $blockChain[$count - 1]->{hash};
	$block->{timestamp} = time();
	$block->{data} = $data;
	$block->{hash} = md5_hex($count . $block->{previousHash} . $block->{timestamp} . $data);
	return @blockChain;	
}

sub chainVerify {
	my @blockChain = @_;
	my $res = 0;
	for (my $i = 0; $i <= scalar(@blockChain) - 1; $i++) {
		my $block = $blockChain[$i];
		my $previousHash = $i == 0 ? "" : $blockChain[$i - 1]->{hash};
		my $timestamp = $block->{timestamp};
		my $data = $block->{data};
		if ($block->{hash} ne md5_hex($i . $previousHash . $timestamp . $data)) {
			$res = $i;
			last;
		}
	}
	return $res;
}

sub chainsCompare(\@\@) {
	my ($blockChain1, $blockChain2) = @_;
	return 0 if chainVerify(@$blockChain1) != 0;
	return 0 if chainVerify(@$blockChain2) != 0;
	if (scalar(@$blockChain1) != scalar(@$blockChain2)) {return 0;}
	return $$blockChain1[scalar(@$blockChain1) - 1]->{hash} eq $$blockChain2[scalar(@$blockChain2) - 1]->{hash} ? 1 : 0;
}

sub printBlock {
	my ($id, @blockChain) = @_;
	my $block = $blockChain[$id];
	print "ID: $id\n";
	print "Предыдущий хэш: $block->{previousHash}\n";
	print "Дата/время: ", localtime($block->{timestamp})->strftime('%Y-%m-%d/%H:%M:%S'), "\n";
	print "Данные: $block->{data}\n";
	print "Хэш: $block->{hash}\n";
}

sub printVerify {
	my @blockChain = @_;
	my $res = chainVerify(@blockChain);
	print $res == 0 ? "Верификация цепочки: ok\n" : "Верификация цепочки: ошибка в блоке #$res\n";
}

1;
