<?php
namespace zimtis\arrayvalidation;

use zimtis\arrayvalidation\keyValidation\StringValidation;
use zimtis\arrayvalidation\keyValidation\IntegerValidation;
use zimtis\arrayvalidation\keyValidation\KeyValidation;
use zimtis\arrayvalidation\keyValidation\FloatValidation;
use zimtis\arrayvalidation\keyValidation\BooleanValidation;

/**
 *
 * @author ZimTis
 *        
 */
class Validation
{

    /**
     *
     * @var string
     */
    private $validationFile;

    /**
     *
     * @var array
     */
    private $keyValidations = array();

    /**
     *
     * @param string $validationFile
     *            path to the json schema, relative from the working directory
     * @param string $name            
     */
    public function __construct($validationFile)
    {
        $this->validationFile = $validationFile;
        $this->parseSchema();
    }

    /**
     * This function parses the file and creates the KeyValidation classes, acording to the schema
     */
    private function parseSchema()
    {
        $json = json_decode(file_get_contents(getcwd() . DIRECTORY_SEPARATOR . $this->validationFile), true);
        if (is_null($json)) {
            throw new \Exception("Invalid json: " . getcwd() . DIRECTORY_SEPARATOR . $this->validationFile);
        }
        
        foreach ($json as $key => $value) {
            if (isset($value['type'])) {
                switch ($value['type']) {
                    case Types::STR:
                    case Types::STRING:
                        array_push($this->keyValidations, new StringValidation($value, $key));
                        break;
                    case Types::INT:
                    case Types::INTEGER:
                        array_push($this->keyValidations, new IntegerValidation($value, $key));
                        break;
                    case Types::FLOAT:
                        array_push($this->keyValidations, new FloatValidation($value, $key));
                        break;
                    case Types::BOOLEAN:
                        array_push($this->keyValidations, new BooleanValidation($value, $key));
                        break;
                    default:
                        throw new \Exception('type: ' . $value['type'] . ' does not exist');
                }
            } else {
                throw new \Exception("Key: " . $key . ' does not contain a type');
            }
        }
    }

    /**
     * This starts the validation process
     *
     * @param array $values            
     */
    public function validate(array &$values)
    {
        /**
         *
         * @var KeyValidation $validation
         */
        foreach ($this->keyValidations as $validation) {
            $validation->validate($values);
        }
    }
}