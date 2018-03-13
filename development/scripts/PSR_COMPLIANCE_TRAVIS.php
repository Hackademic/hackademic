#!/usr/bin/php
<?php
/**
* .git/hooks/pre-commit
*
* This pre-commit hooks will check for PHP error (lint), and make sure the code
* is PSR compliant.
*
* Dependecy: PHP-CS-Fixer (https://github.com/fabpot/PHP-CS-Fixer)
*
* @author Mardix  http://github.com/mardix
* @since  Sept 4 2012
*/

/**
* Collect all files in the project outside the vendor folder
*/
exec('find . ! -path "*/vendor/*"  ! -path "*/esapi/*" ! -path "*/extlib/*" -type f -name "*.php"', $output);

foreach ($output as $file) {
    $fileName = $file;
    /**
    * Only PHP file
    */

    /**
    * Lint check
    */
    $lint_output = array();
    exec("php -l " . escapeshellarg($fileName), $lint_output, $return);

    if ($return === 0) {

        exec("./vendor/squizlabs/php_codesniffer/scripts/phpcs --colors {$fileName} ", $fix_output, $ret_val);
        if (0 !== $ret_val) {
            var_dump($fix_output);
            exit(1);
        }
    } else {
        echo implode("\n", $lint_output), "\n";
        exit(1);
    }
}

  exit(0);
