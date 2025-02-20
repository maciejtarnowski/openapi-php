<?php declare(strict_types=1);

/**
 * @license Apache 2.0
 */

namespace OpenApi\Processors;

use OpenApi\Analysis;
use OpenApi\Annotations\Schema;
use OpenApi\Annotations\Property;

/**
 * Use the Schema context to extract useful information and inject that into the annotation.
 * Merges properties
 */
class AugmentSchemas
{
    public function __invoke(Analysis $analysis)
    {
        $schemas = $analysis->getAnnotationsOfType(Schema::class);
        // Use the class names for @OA\Schema()
        foreach ($schemas as $schema) {
            if ($schema->schema === null) {
                if ($schema->_context->is('class')) {
                    $schema->schema = $schema->_context->class;
                } elseif ($schema->_context->is('trait')) {
                    $schema->schema = $schema->_context->trait;
                }
                // if ($schema->type === null) {
                //     $schema->type = 'object';
                // }
            }
        }
        // Merge unmerged @OA\Property annotations into the @OA\Schema of the class
        $unmergedProperties = $analysis->unmerged()->getAnnotationsOfType(Property::class);
        foreach ($unmergedProperties as $property) {
            if ($property->_context->nested) {
                continue;
            }
            $schemaContext = $property->_context->with('class') ?: $property->_context->with('trait');
            if ($schemaContext->annotations) {
                foreach ($schemaContext->annotations as $annotation) {
                    if ($annotation instanceof Schema) {
                        if ($annotation->_context->nested) {
                            //we should'not merge property into nested schemas
                            continue;
                        }

                        if ($annotation->allOf) {
                            $schema = null;
                            foreach ($annotation->allOf as $nestedSchema) {
                                if ($nestedSchema->ref) {
                                    continue;
                                }

                                $schema = $nestedSchema;
                            }

                            if (null === $schema) {
                                $schema = new Schema(['_context' => $annotation->_context]);
                                $annotation->allOf[] = $schema;
                            }

                            $schema->merge([$property], true);
                            break;
                        }

                        $annotation->merge([$property], true);
                        break;
                    }
                }
            }
        }
    }
}
