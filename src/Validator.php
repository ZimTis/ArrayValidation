<?php
namespace zimtis\arrayvalidation;

/**
 * Manage every SchemaValidation a user loads.
 *
 * @author ZimTis
 *        
 * @since 0.0.1 added
 * @since 0.0.6 completely rewritten
 *       
 *       
 */
class Validator
{

    /**
     * Every SchemaValidation beloging to this Validator
     *
     * @var array
     */
    private $schemaValidations = array();

    public function __construct()
    {}

    /**
     * This function adds a schema.json to this Validator.
     * If no name is supplied, it will use the name of the schema file
     *
     * @param string $schemaFile
     *            path to the file rooting from root of the project
     * @param string|null $name            
     */
    public function addSchemaValidation($schemaFile, $name = NULL)
    {
        $realName = $this->generateName($schemaFile, $name);
        $realpath = getcwd() . DIRECTORY_SEPARATOR . $schemaFile;
        
        if (file_exists($realpath)) {
            if (! key_exists($realName, $this->schemaValidations)) {
                $json = json_decode(file_get_contents($realpath), true);
                if (is_null($json)) {
                    trigger_error($schemaFile . ' is not a valid json file', E_USER_ERROR);
                }
                $this->schemaValidations[$realName] = ValidationBuilder::buildValidation($json);
            } else {
                trigger_error('Schema with the name ' . $realName . ' already exist.', E_USER_ERROR);
            }
        } else {
            trigger_error($schemaFile . ' could not be found', E_USER_ERROR);
        }
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
     * Removes all SchemValidation belonging to this Validator
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
     * @return SchemaValidatio
     */
    public function getSchemaValidationByName($name)
    {
        if (key_exists($name, $this->schemaValidations)) {
            return $this->schemaValidations[$name];
        }
        
        trigger_error('No Validatino with the name ' . $name . ' could be found.', E_USER_ERROR);
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
        return ! is_null($name) && is_string($name) ? $name : $pathInfo['filename'];
    }

    public function validate($name, array $aray)
    {
        $this->getSchemaValidationByName($name)->validate($aray);
    }
}