<?php

namespace zimtis\arrayvalidation;

use MyCLabs\Enum\Enum;

/**
 *
 * Enum of every possible type
 *
 * @author ZimTis
 *
 * @since 0.0.1 added
 * @since 0.0.6 rewritten
 * @since 0.0.95 use MyCLabs Enums
 *
 * @method static STRING()
 * @method static STR()
 * @method static INTEGER()
 * @method static INT()
 * @method static FLOAT()
 * @method static DOUBLE()
 * @method static BOOLEAN()
 * @method static ARRY()
 * @method static NUMBER()
 */
class Types extends Enum
{
    const STRING = "string";

    const STR = "str";

    const INTEGER = "integer";

    const INT = "int";

    const FLOAT = "float";

    const DOUBLE = "double";

    const BOOLEAN = "boolean";

    const ARRY = 'array';

    const NUMBER = 'integerOrFloat';
}