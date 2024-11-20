<?php

declare(strict_types=1);

namespace ZxcvbnPhp\Matchers;

class CustomDictionaryMatch extends DictionaryMatch {

    /**
     * The JSON file path from where to load dictionaries
     * @var string|null
     */
    protected static $filepath = null;

    /**
     * A cache of the dictionaries loaded from the JSON file
     * @var array<string, array<string, int>>
     */
    protected static $rankedDictionaries = [];

    /**
     * Load ranked frequency dictionaries.
     *
     * @return array<string, array<string, int>>
     */
    protected static function getRankedDictionaries(): array
    {
        if (empty(static::$rankedDictionaries)) {
            if (!static::$filepath)
                throw new \UnexpectedValueException(
                    'You must set the $filepath property of your CustomDictionaryMatch '.
                    'child class!'
                );
            $json = file_get_contents(static :: $filepath);
            $data = json_decode($json, true);
            
            $rankedLists = [];
            foreach ($data as $name => $words) {
                $rankedLists[$name] = array_combine($words, range(1, count($words)));
            }
            static::$rankedDictionaries = $rankedLists;
        }
        
        return static::$rankedDictionaries;
    }

    /**
     * Create a custom dictionary matcher class
     * 
     * @param string $name The name of this custom dictionary matcher
     * @param string $filepath The JSON file path from where to load your dictionaries
     * 
     * @return string The name of the created dictionary matcher class
     */
    public static function create($name, $filepath) {
        $name = preg_replace("/[^A-Za-z0-9]/", "", ucwords($name));
        $class_name = "${name}DictionaryMatch";
        if (class_exists($class_name)) {
            $x = 2;
            while(class_exists("${name}${x}DictionaryMatch")) $x++;
            $class_name = "${name}${x}DictionaryMatch";
        }
        eval(
            "class $class_name extends \ZxcvbnPhp\Matchers\CustomDictionaryMatch {
                protected static \$filepath = '$filepath';
                protected static \$rankedDictionaries = [];
            }"
        );
        return $class_name;
    }
}
