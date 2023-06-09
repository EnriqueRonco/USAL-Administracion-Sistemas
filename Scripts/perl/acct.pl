#!/usr/bin/perl

use strict;
use warnings;
use DBI;
use Excel::Writer::XLSX;
use Email::Sender::Simple qw(sendmail);
use Email::Sender::Transport::SMTP::TLS;
use MIME::Base64;
use File::Slurp;
use MIME::Lite;

my $f2 = "comandos.txt";

my $excel = Excel::Writer::XLSX->new('stats.xlsx');

my $ws = $excel->add_worksheet();
open my $info, $f2 or die "Could not open $f2: $!";

my @veces;
my @comandos;

while (my $line = <$info>) {
    chomp $line;
    my @data = split / /, $line;
    @data = grep($_, @data);
    $data[8] =~ s/\s+//g;
    push(@comandos, $data[8]);
    $data[0] =~ s/\s+//g;
    chop($data[0]);
    push(@veces, $data[0]);
}

close $info;

# Add the worksheet data the chart refers to.
my $datosFichero = [
    ['Comandos', @comandos],
    ['Veces',    @veces]
];

$ws->write('A1', $datosFichero);

my $chart = $excel->add_chart(type => 'pie', embedded => 1);

# Configure the chart.
$chart->add_series(
    categories => ['Sheet1', 1, 60, 0, 0],
    values     => ['Sheet1', 1, 60, 1, 1],
);

$chart->set_title(name => '10 comandos mas veces llamados');
$chart->set_style(10);
$chart->set_size(width => 800, height => 600);

$ws->insert_chart('C2', $chart, 20, 20);

$excel->close();

my $db = DBI->connect('dbi:mysql:database=eladminDB;host=localhost', 'admin', 'admin')
  or die "Error al conectarse a la base de datos: $DBI::errstr";
my $sth = $db->prepare('SELECT correo FROM users WHERE is_admin=1')
  or warn "Error al preparar la consulta: $db->errstr";
$sth->execute() or die "Error al ejecutar la consulta: $sth->errstr";

my ($email) = $sth->fetchrow_array;
$sth->finish();

my $body = "Daily report from the server eladmin";
my $attachment = 'stats.xlsx';

# Email configuration
my $smtp_host     = 'smtp.gmail.com';
my $smtp_port     = 587;
my $smtp_user     = 'nofuncionaelcorreo777@gmail.com';
my $smtp_password = 'upzcumpzlublkwre';

my $transport = Email::Sender::Transport::SMTP::TLS->new(
    host     => $smtp_host,
    port     => $smtp_port,
    username => $smtp_user,
    password => $smtp_password,
);

my $file_content = read_file($attachment, binmode => ':raw');
my $encoded_content = encode_base64($file_content);

my $email_message = MIME::Lite->new(
    From    => $smtp_user,
    To      => $email,
    Subject => 'daily report',
);

$email_message->attach(
    Type        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    Encoding    => 'base64',
    Disposition => 'attachment',
    Filename    => $attachment,
    Data        => $encoded_content,
);

sendmail($email_message->as_string, { transport => $transport }) or die "Error sending email: $!";

