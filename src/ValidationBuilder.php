<?php
namespace zimtis\arrayvalidation;

use zimtis\arrayvalidation\validations\NestedValidation;
use zimtis\arrayvalidation\validations\keyValidations\StringValidation;
use zimtis\arrayvalidation\validations\KeyValidation;
use zimtis\arrayvalidation\validations\keyValidations\IntegerValidation;
use zimtis\arrayvalidation\validations\keyValidations\FloatValidation;
use zimtis\arrayvalidation\validations\keyValidations\BooleanValidation;
use zimtis\arrayvalidation\validations\keyValidations\ArrayValidation;

/**
 *
 * @author ZimTis
 *
 * @since 0.0.6
 */
class ValidationBuilder {

    /**
     * This function builds a validation acording to the specifgications of the json file
     *
     * @param array $schema
     */
    public static function buildValidation(array $schema, $name = null){
        $validation = new NestedValidation($name);

        foreach ($schema as $key => $value ) {

            if (self::isNestedValidation($value)) {
                $validation->addValidation(self::buildValidation($value, $key));
            } else {
                $validation->addValidation(self::buildKeyValidation($value, $key));
            }
        }
        return $validation;
    }

    /**
     * Check if the found value is a nestedValidation
     *
     * @param array $value
     * @return boolean
     *
     * @see NestedValidation
     */
    private static function isNestedValidation(array $value){
        return !(key_exists(Properties::TYPE, $value) && !is_array($value[Properties::TYPE]));
    }

    /**
     * Builds a KeyValidation
     *
     * @param array $options
     * @param string $name
     * @return \zimtis\arrayvalidation\validations\keyValidations\StringValidation
     *
     * @see KeyValidation
     */
    public static function buildKeyValidation(array $options, $name){
        if (!key_exists(Properties::TYPE, $options)) {
            trigger_error($name . ' must have a type');
        }

        switch ($options[Properties::TYPE]) {
            case Types::STR :
            case Types::STRING :
                return new StringValidation($name, $options);
            case Types::INT :
            case Types::INTEGER :
                return new IntegerValidation($name, $options);
            case Types::FLOAT :
                return new FloatValidation($name, $options);
            case Types::BOOLEAN :
                return new BooleanValidation($name, $options);
            case Types::ARRY :
                return new ArrayValidation($name, $options);
            default :
                trigger_error(sprintf('%s is unknown', $options[Properties::TYPE]), E_USER_ERROR);
        }
    }
}