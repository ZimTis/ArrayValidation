<?php
namespace zimtis\test;

class TestUtil {

    private static function getBaseSchemaPath(){
        return 'test' . DIRECTORY_SEPARATOR . 'schema';
    }

    public static function getPathOfSchem(){
        return self::getBaseSchemaPath();
    }

    public static function getPathAndFileNameOfSchema($filename){
        return self::getPathOfSchem() . DIRECTORY_SEPARATOR . $filename;
    }

    public static function getPathOfDevelopModeTestSchema(){
        return self::getBaseSchemaPath() . DIRECTORY_SEPARATOR . 'developModeTest';
    }

    public static function getPathAndFileNameOfDevelopModeTestSchema($filename){
        return self::getPathOfDevelopModeTestSchema() . DIRECTORY_SEPARATOR . $filename;
    }
}