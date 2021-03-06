<?php

namespace zimtis\arrayvalidation;

use MyCLabs\Enum\Enum;

/**
 *
 * "Enum" of every possible Property
 *
 * @author ZimTis
 *
 * @since 0.0.1 added
 * @since 0.0.6 rewritten
 * @since 0.0.71 renamed to Properties
 * @since 0.0.8 add oneOf
 * @since 0.0.9 add callable
 * @since 0.0.95 change type to '__type__', uses MyCLabs Enums
 *
 * @method static TYPE()
 * @method static REQUIRED()
 * @method static NULLABLE()
 * @method static MIN_LENGTH()
 * @method static MAX_LENGTH();
 * @method static LENGTH()
 * @method static TRIMMED()
 * @method static MIN()
 * @method static MAX()
 * @method static ITEM()
 * @method static START_WIDTH()
 * @method static END_WITH()
 * @method static ONE_OF()
 * @method static CALL_ABLE()
 */
class Properties extends Enum
{

    /**
     * Required type if the value, must be set
     * must be string
     *
     * @var string
     */
    const TYPE = '__type__';

    /**
     * Is the value required, default is false
     * must be boolean
     *
     * @var string
     */
    const REQUIRED = 'required';

    /**
     * Can the value be NULL, default is true
     * must be boolean
     *
     * @var string
     */
    const NULLABLE = 'nullable';

    /**
     * Available for string
     * Minimal length of the value.
     * Must be smaller than maxLength
     * Must be integer
     * can not be set if length is set
     *
     * @var string
     */
    const MIN_LENGTH = "minLength";

    /**
     * Available for string
     * Maximal length of a value
     * Must be bigger than minLength
     * Must be integer
     * can not be set if length is set
     *
     * @var string
     */
    const MAX_LENGTH = "maxLength";

    /**
     * Available for string
     * length of the value
     * must be integer
     * can not be set if minLength or maxLength is set
     *
     * @var string
     */
    const LENGTH = "length";

    /**
     * available for string
     * must the value be trimmed?
     * must be boolean
     * default false
     *
     * @var string
     */
    const TRIMMED = "trimmed";

    /**
     * available for integer and float
     * minimal accepted value
     * must be smaller than max
     * if used with int : must be int
     * if used with float : must be int or float
     *
     * @var string
     */
    const MIN = "min";

    /**
     * available for integer and float
     * maximal accepted value
     * must be bigger than min
     * if used with int : must be int
     * if used with float : must be int or float
     *
     * @var string
     */
    const MAX = 'max';

    /**
     * available for array
     *
     * @var string
     */
    const ITEM = 'item';

    /**
     * available for string
     *
     * @var string
     */
    const START_WIDTH = 'startWith';

    /**
     * available for string
     *
     * @var string
     */
    const END_WITH = 'endWith';

    /**
     * available for string, integer, float
     * sets excepted values
     * must be a array of strings, integer or flaots
     *
     * @var string
     */
    const ONE_OF = 'oneOf';

    /**
     * sets a callable function, for custom validation by the user
     *
     * @var string
     */
    const CALL_ABLE = 'callable';
}