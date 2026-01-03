<?php
/**
 * Hash Password Generator for Sample Data
 * Run this file once to generate hashed passwords for sample users
 */

// Password hashes for sample data (generated using password_hash)
$passwords = array(
    'admin123' => password_hash('admin123', PASSWORD_DEFAULT),
    'laboran123' => password_hash('laboran123', PASSWORD_DEFAULT),
    'mhs123' => password_hash('mhs123', PASSWORD_DEFAULT)
);

echo "Generated Password Hashes:\n";
echo "==========================\n\n";

foreach ($passwords as $plain => $hash) {
    echo "Plain: {$plain}\n";
    echo "Hash: {$hash}\n\n";
}

echo "\nUse these hashes in your database INSERT statements.\n";
