#!/usr/bin/perl

use strict;
use warnings;
use DBI;
use Net::SMTP;

my $db = DBI->connect('dbi:mysql:database=eladminDB;host=localhost', 'admin', 'admin') or die "Error al conectarse a la base de datos: $DBI::errstr";
my $sth = $db->prepare('SELECT correo FROM users WHERE is_admin = 1') or die "Error al preparar la consulta: $db->errstr";
$sth->execute() or die "Error al ejecutar la consulta: $sth->errstr";

my ($email) = $sth->fetchrow_array;
$sth->finish();

my $smtp_host = 'smtp.gmail.com';
my $smtp_port = 587;
my $smtp_user = 'nofuncionaelcorreo777@gmail.com';
my $smtp_password = 'upzcumpzlublkwre';

my $to = 'nofuncionaelcorreo777@gmail.com';
my $subject = 'WARNING ROOT SESSION';
my $body = 'Se ha iniciado sesión con el root';

my $smtp = Net::SMTP->new(
    $smtp_host,
    Port    => $smtp_port,
    Timeout => 30,
    Debug   => 1,
) or die "Error al conectarse al servidor SMTP: $!";

$smtp->starttls() or die "Error al iniciar TLS: $!";
$smtp->auth($smtp_user, $smtp_password) or die "Error de autenticación: $!";
$smtp->mail($smtp_user) or die "Error al configurar el remitente: $!";
$smtp->to($to) or die "Error al configurar el destinatario: $!";
$smtp->data() or die "Error al iniciar la sección de datos: $!";
$smtp->datasend("From: $smtp_user\n") or die "Error al enviar el remitente: $!";
$smtp->datasend("To: $to\n") or die "Error al enviar el destinatario: $!";
$smtp->datasend("Subject: $subject\n") or die "Error al enviar el asunto: $!";
$smtp->datasend("\n") or die "Error al enviar una línea en blanco: $!";
$smtp->datasend("$body\n") or die "Error al enviar el cuerpo del correo: $!";
$smtp->dataend() or die "Error al finalizar la sección de datos: $!";
$smtp->quit or die "Error al desconectarse del servidor SMTP: $!";
