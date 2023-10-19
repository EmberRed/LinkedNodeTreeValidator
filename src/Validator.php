<?php
namespace TreeValidator;

use TreeValidator\Exceptions\ExactlyOneRootNodeException;
use TreeValidator\Exceptions\InvalidTreeStructureException;
use TreeValidator\Node\Node;

final class Validator
{

    /**
     * @param array<Node> $nodes
     */
    public static function validate(array $nodes): bool
    {
        $nodeMap = [];

        /** @var Node $node */
        foreach ($nodes as $node) {
            $nodeMap[$node->getId()] = $node;
        }

        // Check that there is exactly one root node (parent is null)
        $rootCount = 0;
        foreach ($nodes as $node) {
            if ($node->getParent() === null) {
                $rootCount++;
            }
        }

        if ($rootCount !== 1) {
            throw new ExactlyOneRootNodeException();
        }

        // Recursively validate the tree
        foreach ($nodes as $node) {
            if (!self::validateSubtree($node, $nodeMap)) {
                throw new InvalidTreeStructureException();
            }
        }

        return true;
    }

    /**
     * @param Node $node
     * @param array<int, Node> $nodeMap
     * @return bool
     */
    private static function validateSubTree(Node $node, array $nodeMap): bool
    {
        // Check it's the root node
        if ($node->getParent() === null) {
            return true;
        }

        // Check if the parent node exists
        if (!isset($nodeMap[$node->getParent()])) {
            return false;
        }

        // Recursively validate the parent node
        return self::validateSubtree($nodeMap[$node->getParent()], $nodeMap);
    }

}