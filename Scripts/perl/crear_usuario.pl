#!/usr/bin/perl

use strict;
use warnings;

my $username = shift;

# Comando para crear el usuario en el servidor
my $command = "sudo useradd -m -p `perl -e 'print crypt(\$ARGV[0], \"password\")' \$ARGV[0]` $username";

# Ejecutar el comando para crear el usuario
my $output = `$command`;

# Verificar si se creó el usuario exitosamente
if ($? == 0) {
    print "El usuario $username se creó correctamente.";
} else {
    print "Hubo un error al crear el usuario $username.";
}

