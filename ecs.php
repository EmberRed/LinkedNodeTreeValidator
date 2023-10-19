<?php

use PHP_CodeSniffer\Standards\Generic\Sniffs\ControlStructures\DisallowYodaConditionsSniff;
use SlevomatCodingStandard\Sniffs\Arrays\TrailingArrayCommaSniff;
use SlevomatCodingStandard\Sniffs\Classes\EmptyLinesAroundClassBracesSniff;
use SlevomatCodingStandard\Sniffs\Classes\RequireAbstractOrFinalSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowYodaComparisonSniff;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->parallel();
    $ecsConfig->indentation(Option::INDENTATION_SPACES);
    $ecsConfig->rule(DisallowYodaConditionsSniff::class);
    $ecsConfig->rule(DisallowYodaComparisonSniff::class);
    $ecsConfig->rule(RequireAbstractOrFinalSniff::class);
    $ecsConfig->rule(TrailingArrayCommaSniff::class);
    $ecsConfig->rule(EmptyLinesAroundClassBracesSniff::class);
    $ecsConfig->paths(
        [
            __FILE__,
            __DIR__.'/src',
        ],
    );
};