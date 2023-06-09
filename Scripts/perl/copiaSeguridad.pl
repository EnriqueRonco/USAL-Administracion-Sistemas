#!/usr/bin/perl

use File::Copy;
use File::Rotate::Backup;

my $params = { archive_copies => 2,
               dir_copies => 1,
               backup_dir => '/var/backup',
               file_prefix => 'backup_',
               secondary_backup_dir => '/var/backup',
               secondary_archive_copies => 2,
               verbose => 1,
               use_flock => 1,
             };
 
my $backup = File::Rotate::Backup->new($params);
 
$backup->backup([ [ '/home/' => 'home' ],
                   ['/sbin/' => 'sbin' ],
                    ['/var/www/' => 'var/www' ],
                     ['/var/lib/mysql/' => 'var/lib/mysql' ],
                  ]);
 
$backup->rotate;
