<?php
namespace zimtis\test;

class TestUtil {

    public static function getPathOfSchem($filename){
        return 'test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . $filename;
    }
}