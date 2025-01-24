<?php

namespace App\DataFixtures;

use Doctrine\Common\Collections\ArrayCollection;

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
                if (\is_string($v) && \str_starts_with($v, 'ref/')) {
                    $v = \preg_replace('~^ref/~', '', $v);
                    $values[$k] = $this->getReference($v);
                } elseif (\is_array($v)) {
                    $hasRef = false;
                    foreach ($v as $w => $x) {
                        if (\str_starts_with($x, 'ref/')) {
                            $x = \preg_replace('~^ref/~', '', $x);
                            $v[$w] = $this->getReference($x);
                            $hasRef = true;
                        }
                    }
                    $values[$k] = $hasRef ? new ArrayCollection($v) : $v;
                }
            }
            yield $id => $values;
        }
    }
}
