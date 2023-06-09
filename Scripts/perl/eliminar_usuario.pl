#!/usr/bin/perl

use strict;
use warnings;

my $username = shift;

# Comando para eliminar el usuario en el servidor
my $command = "sudo userdel -r $username";

# Ejecutar el comando para eliminar el usuario
my $output = `$command`;

# Verificar si se eliminó el usuario exitosamente
if ($? == 0) {
    print "El usuario $username se eliminó correctamente.";
} else {
    print "Hubo un error al eliminar el usuario $username.";
}

