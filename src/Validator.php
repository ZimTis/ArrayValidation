<?php

namespace zimtis\arrayvalidation;

use zimtis\arrayvalidation\validations\Validation;
use zimtis\arrayvalidation\validations\NestedValidation;

/**
 * Manage every SchemaValidation a user loads.
 *
 * @author ZimTis
 *
 * @since 0.0.1 added
 * @since 0.0.6 completely rewritten
 * @since 0.0.7 add developer mode
 * @since 0.0.94 add schema via string
 *
 */
class Validator
{

    /**
     * Every SchemaValidation belonging to this Validator
     *
     * @var array
     */
    private $schemaValidations = array();

    /**
     *
     * @var boolean
     */
    private $devMode = false;

    /**
     * Validator constructor.
     * @param bool $devMode
     */
    public function __construct($devMode = false)
    {
        $this->devMode = $devMode;
    }

    /**
     * This function adds a schema.json to this Validator.
     * If no name is supplied, it will use the name of the schema file.
     * If the Validator is not in developer mode, the Validator will loock for a serialised version of the schema file to save time for instanziating.
     * If in developer mode, the Validator will read the schema file, regardless of any serialized file
     *
     * @param string $schemaFile
     *            path to the file rooting from root of the project
     * @param string|null $name
     */
    public function addSchemaValidation($schemaFile, $name = null)
    {
        $realName = $this->generateName($schemaFile, $name);
        $realPath = getcwd() . DIRECTORY_SEPARATOR . $schemaFile;

        if (file_exists($realPath)) {
            if (!key_exists($realName, $this->schemaValidations)) {
                // TODO can we do it better?
                if ($this->devMode || (!$this->isSerialized($realPath) && !$this->devMode)) {
                    $json = json_decode(file_get_contents($realPath), true);
                    if (is_null($json)) {
                        trigger_error($schemaFile . ' is not a valid json file', E_USER_ERROR);
                    }

                    $validation = $this->createValidation($json);

                    if (!$this->devMode) {
                        file_put_contents($realPath . '.ser', serialize($validation));
                    }

                    $this->schemaValidations[$realName] = $validation;
                } else {
                    $this->schemaValidations[$realName] = unserialize(file_get_contents($realPath . '.ser'));
                }
            } else {
                trigger_error('Schema with the name ' . $realName . ' already exist.', E_USER_ERROR);
            }
        } else {
            trigger_error($schemaFile . ' could not be found', E_USER_ERROR);
        }
    }

    /**
     * This method creates a Validation object from string
     * this validation will not get a name or will be stored inside the validator
     *
     * @param string $string
     *
     * @return NestedValidation
     */
    public function addSchemaFromString($string)
    {
        $json = json_decode($string, true);
        if (is_null($json)) {
            trigger_error('not a valid json');
        }

        return $this->createValidation($json);
    }

    /**
     * @param array $json
     * @return NestedValidation
     */
    public function createValidation(array $json)
    {
        return ValidationBuilder::buildValidation($json);
    }

    /**
     * Removes the SchemaValidation with the given name
     *
     * @param string $name
     */
    public function removeSchema($name)
    {
        if (key_exists($name, $this->schemaValidations)) {
            unset($this->schemaValidations[$name]);
        }
    }

    /**
     * Removes all SchemaValidation belonging to this Validator
     */
    public function clearValidations()
    {
        $this->schemaValidations = array();
    }

    /**
     *
     * @return array all SchemaValidations of this Validation
     */
    public function getSchemaValidations()
    {
        return $this->schemaValidations;
    }

    /**
     *
     * @param string $name
     *
     * @return Validation
     * @throws \Error
     */
    public function getSchemaValidationByName($name)
    {
        if (!key_exists($name, $this->schemaValidations)) {
            trigger_error('No Validation with the name ' . $name . ' could be found.', E_USER_ERROR);
        }
        return $this->schemaValidations[$name];

    }

    /**
     *
     * @param string $path
     * @param string $name
     * @return string
     */
    private function generateName($path, $name)
    {
        $pathInfo = pathinfo($path);
        return !is_null($name) && is_string($name) ? $name : $pathInfo['filename'];
    }

    public function validate($name, array $array)
    {
        $this->getSchemaValidationByName($name)->validate($array);
    }

    /**
     * Checks if a serialized version of the schema file exist
     *
     * @param $schemaFile
     * @return bool true if a serialized file exist, false if not
     * @internal param string $schemaFile
     *
     */
    private function isSerialized($schemaFile)
    {
        return file_exists($schemaFile . '.ser');
    }
}