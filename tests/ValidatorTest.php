<?php

namespace Tests;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use TreeValidator\Exceptions\ExactlyOneRootNodeException;
use TreeValidator\Exceptions\InvalidTreeStructureException;
use TreeValidator\Node\Node;
use TreeValidator\Validator;

class ValidatorTest extends TestCase
{
    /**
     * @dataProvider provideSuccessTestData
     * @param array<Node> $nodes
     */
    public function testItCanValidatorTree(array $nodes): void
    {
        Assert::assertTrue(Validator::validate($nodes));
    }

    /**
     * @dataProvider provideFailingTestData
     * @param array<Node> $nodes
     */
    public function testItCannotValidateTree(array $nodes, \Exception $exception): void
    {
        self::expectExceptionObject($exception);

        Validator::validate($nodes);
    }

    /**
     * @return array<string, mixed>
     */
    public static function provideFailingTestData(): array
    {
        return [
            'no root node' => [
                [
                    new Node(2, 1),
                    new Node(3, 2),
                    new Node(4, 3),
                ],
                new ExactlyOneRootNodeException()
            ],
            'multiple root node' => [
                [
                    new Node(1, null),
                    new Node(2, 1),
                    new Node(3, 2),
                    new Node(4, 3),
                    new Node(5, null),
                ],
                new ExactlyOneRootNodeException()
            ],
            'not linked child node' => [
                [
                    new Node(1, null),
                    new Node(2, 1),
                    new Node(3, 2),
                    new Node(4, 3),
                    new Node(5, 6),
                ],
                new InvalidTreeStructureException()
            ],
            'self reference in tree' => [
                [
                    new Node(1, null),
                    new Node(2, 1),
                    new Node(3, 3),
                ],
                new InvalidTreeStructureException()
            ],
            'not unique ids' => [
                [
                    new Node(1, null),
                    new Node(2, 1),
                    new Node(3, 2),
                    new Node(2, 3),
                ],
                new InvalidTreeStructureException()
            ],
            'loop in tree' => [
                [
                    new Node(1, null),
                    new Node(2, 1),
                    new Node(3, 5),
                    new Node(4, 3),
                    new Node(5, 4),
                ],
                new InvalidTreeStructureException()
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function provideSuccessTestData(): array
    {
        return [
            'single branch tree' => [
                [
                    new Node(1, null),
                    new Node(2, 1),
                    new Node(3, 2),
                    new Node(4, 3),
                    new Node(5, 4),
                    new Node(6, 5),
                ]
            ],
            'multiple branch tree' => [
                [
                    new Node(1, null),
                    new Node(2, 1),
                    new Node(3, 2),
                    new Node(4, 3),
                    new Node(5, 4),
                    new Node(6, 5),
                    new Node(7, 5),
                    new Node(8, 5),
                    new Node(9, 3),
                ]
            ],
        ];
    }
}