#!/usr/bin/perl
use DBI;

my $db=DBI->connect('dbi:mysql:database=eladminDB;host=localhost','admin','admin');
my $q = $db->prepare("delete from eladminDB.users where state=1");
$q->execute();
$q->finish();

