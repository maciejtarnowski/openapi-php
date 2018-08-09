<?php declare(strict_types=1);

/**
 * @license Apache 2.0
 */

namespace OpenApiTests;

class AugmentHeaderTest extends OpenApiTestCase
{
    public function testAugmentHeader()
    {
        $openapi = \OpenApi\scan(__DIR__ . '/Fixtures/UsingRefs.php');
        $this->assertCount(1, $openapi->components->headers, 'OpenApi contains 1 reusable header specification');
        $this->assertCount(1, $openapi->components->responses[0]->headers, 'Response contains 1 header');
        $this->assertEquals('#/components/headers/HeaderName', $openapi->components->responses[0]->headers[0]->ref, 'Response references reusable `HeaderName` header');
    }
}
