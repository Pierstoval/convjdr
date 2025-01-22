<?php

namespace App\DataFixtures;

trait GetObjectsFromData
{
    public static function getIdFromName(string $name): string
    {
        if (!\defined(self::class.'::DATA')) {
            throw new \RuntimeException('');
        }

        foreach (self::DATA as $id => $values) {
            if ($values['name'] === $name) {
                return $id;
            }
        }

        throw new \RuntimeException(\sprintf(
            'No fixture object with name "%s" in class "%s".',
            $name,
            static::class
        ));
    }

    protected function getObjects(): iterable
    {
        if (!\defined(self::class.'::DATA')) {
            throw new \RuntimeException('');
        }

        foreach (self::DATA as $id => $values) {
            foreach ($values as $k => $v) {
                $values['id'] = $id;
                if (\str_starts_with($v, 'ref/')) {
                    $v = \preg_replace('~^ref/~', '', $v);
                    $values[$k] = $this->getReference($v);
                }
            }
            yield $id => $values;
        }
    }
}
