<?php

return [
    /** Connection settings for the database */
    "credentials" => [
        "driver"        => "pdo_mysql",
        "path"          => "localhost",
        "user"          => "root",
        "password"      => '',
        "dbname"        => "test",
        "charset"       => "utf8",
    ],
    /** Settings for mapping. Only xml is implemented right now */
    "mapping" => [
        "type" => "xml",
        //"extension"   => ".dcm.xml", // This is an optional attribute and is set to default
        "path" => [
            realpath(APPPATH.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR."xml"),
        ],
        "namingStrategy" => [
            "strategy" => "default",
            "case" => CASE_LOWER
        ],
        'useSimpleAnnotationReader' => true,
    ],
    /** Cache settings */
    "cache" => [
        "type" => "array",
        // "host" => "hostname",
        // "port" => "11211",
    ],
    /** Proxy settings */
    "proxy" => [
        "path"         => realpath(APPPATH.DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR."proxies"),
        "namespace"    => "Proxies",
        "generate"     => true,
    ],
    /** Define namespaces */
    "namespaces" => [],
    /** Set production flag */
    "onProduction" => false,
    /** Set events */
    "events" => [
        "listeners" => [
            "class" => [], // Formated like "ClassnameOfListener" => "arrayWithEvents"
        ],
        "subscribers" => [
            "class" // EventSubscriberClass
        ],
    ],
];
