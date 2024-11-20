<?php

declare(strict_types=1);

namespace ZxcvbnPhp\Matchers;

class FrenchDictionaryMatch extends CustomDictionaryMatch {

    /**
     * The JSON file path from where to load dictionaries
     * @var string|null
     */
    protected static $filepath = __DIR__."/french_frequency_lists.json";

    /**
     * A cache of the dictionaries loaded from the JSON file
     * @var array<string, array<string, int>>
     */
    protected static $rankedDictionaries = [];

}
