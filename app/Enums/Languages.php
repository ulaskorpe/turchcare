<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Languages extends Enum
{
    const TR = ['Türkçe','tr'];
    const EN = ['English','en'];
   // const DE = ['Deutsch','DE'];
}
