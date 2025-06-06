<?php

declare(strict_types=1);


final class AttributeHelper
{
    /**
     * Return instances of an attribute on a reflector.
     *
     * @template T of object
     * @param \ReflectionClass|\ReflectionFunction|\ReflectionMethod|\ReflectionParameter|\ReflectionProperty|\ReflectionClassConstant $reflector
     * @param class-string<T> $attributeClass
     * @return list<T>
     */
    public static function getInstances(\Reflector $reflector, string $attributeClass): array
    {
        return array_map(
            static fn (\ReflectionAttribute $attribute) => $attribute->newInstance(),
            $reflector->getAttributes($attributeClass)
        );
    }

    /**
     * Retrieve attribute instances from a function or method and its parameters.
     *
     * @template T of object
     * @param \ReflectionFunction|\ReflectionMethod $reflector
     * @param class-string<T> $attributeClass
     * @return array{function: list<T>, parameters: array<string, list<T>>}
     */
    public static function getFunctionInstances(\ReflectionFunctionAbstract $reflector, string $attributeClass): array
    {
        $function = self::getInstances($reflector, $attributeClass);
        $parameters = [];
        foreach ($reflector->getParameters() as $parameter) {
            $parameters[$parameter->name] = self::getInstances($parameter, $attributeClass);
        }
        return ['function' => $function, 'parameters' => $parameters];
    }
}
