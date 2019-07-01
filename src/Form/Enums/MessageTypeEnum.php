<?php

namespace App\Form\Enums;

abstract class MessageTypeEnum {
    const TYPE_INFO    = "info";
    const TYPE_WARNING = "warning";
    const TYPE_SUCCESS = "success";
    const TYPE_DANGER  = "danger";

    /** @var array user friendly named type */
    protected static $typeName = [
        self::TYPE_INFO    => 'Information',
        self::TYPE_WARNING => 'Attention',
        self::TYPE_SUCCESS => 'Succès',
        self::TYPE_DANGER  => 'Danger',
    ];

    /**
     * @param  string $typeShortName
     * @return string
     */
    public static function getTypeName($typeShortName)
    {
        if (!isset(static::$typeName[$typeShortName])) {
            return "Unknown type ($typeShortName)";
        }

        return static::$typeName[$typeShortName];
    }

    /**
     * @return array<string>
     */
    public static function getAvailableTypes()
    {
        return [
            self::TYPE_INFO,
            self::TYPE_WARNING,
            self::TYPE_SUCCESS,
            self::TYPE_DANGER
        ];
    }


}