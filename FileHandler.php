<?php

/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 7/1/2015
 * Time: 1:49 PM
 */
class FileHandler
{
    public function getValue($file, $value)
    {
        $my_file = fopen($file, "r") or die("Unable to open file!");
        $text = fread($my_file, filesize($file));
        $split = explode(':', $text);
        $i = 0;

        if (is_array($split)) {
            foreach ($split as $values) {
                if ($values == $value) {
                    $i++;
                    $v = $split[$i];
                }

                $i++;
            }
        }

        fclose($my_file);
        return $v;
    }
}

