<?php declare(strict_types=1);

/**
 * @license Apache 2.0
 */

namespace OpenApi\Annotations;

/**
 * @Annotation
 * A Components Object: https://github.com/OAI/OpenAPI-Specification/blob/master/versions/3.0.0.md#components-object
 *
 * Holds a set of reusable objects for different aspects of the OA.
 * All objects defined within the components object will have no effect on the API unless they are explicitly referenced from properties outside the components object.
 */
class Components extends AbstractAnnotation
{
    /**
     * Schema reference
     *
     * @var string
     */
    const SCHEMA_REF = '#/components/schemas/';

    /**
     * Reusable Schemas.
     *
     * @var Schema[]
     */
    public $schemas;

    /**
     * Reusable Responses.
     *
     * @var Response[]
     */
    public $responses;

    /**
     * Reusable Parameters.
     *
     * @var Parameter[]
     */
    public $parameters;

    /**
     * Reusable Examples.
     *
     * @var Examples[]
     */
    public $examples;

    /**
     * Reusable Request Bodys.
     *
     * @var RequestBody[]
     */
    public $requestBodies;

    /**
     * Reusable Headers.
     *
     * @var Header[]
     */
    public $headers;

    /**
     * Reusable Security Schemes.
     *
     * @var SecurityScheme[]
     */
    public $securitySchemes;

    /**
     * Reusable Links.
     *
     * @var Link[]
     */
    public $links;

    /**
     * Reusable Callbacks.
     *
     * @var Callback[]
     */
    public $callbacks;

    /** @inheritdoc */
    public static $_parents = [
        'OpenApi\Annotations\OpenApi'
    ];

    /** @inheritdoc */
    public static $_nested = [
        'OpenApi\Annotations\Schema' => ['schemas', 'schema'],
        'OpenApi\Annotations\Response' => ['responses', 'response'],
        'OpenApi\Annotations\Parameter' => ['parameters', 'parameter'],
        'OpenApi\Annotations\RequestBody' => ['requestBodies', 'request'],
        'OpenApi\Annotations\Examples' => ['examples'],
        'OpenApi\Annotations\Header' => ['headers', 'header'],
        'OpenApi\Annotations\SecurityScheme' => ['securitySchemes', 'securityScheme'],
        'OpenApi\Annotations\Link' => ['links', 'link'],
    ];
}
