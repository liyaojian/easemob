<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/13
 * Time: 22:44
 */
function ungz($file_name)
{
    $buffer_size = 4096; // read 4kb at a time
    $out_file_name = str_replace('.gz', '', $file_name);

// Open our files (in binary mode)
    $file = gzopen($file_name, 'rb');
    $out_file = fopen($out_file_name, 'wb');

// Keep repeating until the end of the input file
    while (!gzeof($file)) {
        // Read buffer-size bytes
        // Both fwrite and gzread and binary-safe
        fwrite($out_file, gzread($file, $buffer_size));
    }

// Files are done, close files
    fclose($out_file);
    gzclose($file);
}