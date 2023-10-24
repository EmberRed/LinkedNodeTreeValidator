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
        $seenIds = [];

        /** @var Node $node */
        foreach ($nodes as $node) {
            if (in_array($node->getId(), $seenIds)) {
                throw new InvalidTreeStructureException();
            }
            $nodeMap[$node->getId()] = $node;
            $seenIds[] = $node->getId();
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
            if (!self::validateSubtree($node, $nodeMap, [])) {
                throw new InvalidTreeStructureException();
            }
        }

        return true;
    }

    /**
     * @param Node $node
     * @param array<int, Node> $nodeMap
     * @param array<int> $visitedNodes
     * @return bool
     */
    private static function validateSubTree(Node $node, array $nodeMap, array $visitedNodes): bool
    {
        // Check it's the root node
        if ($node->getParent() === null) {
            return true;
        }

        // Check if the node has been visited before, indicating a loop
        if (in_array($node->getId(), $visitedNodes)) {
            return false;
        }

        // Add the node to the list of visited nodes
        $visitedNodes[] = $node->getId();

        // Check if the parent node exists
        if (!isset($nodeMap[$node->getParent()])) {
            return false;
        }

        // Recursively validate the parent node
        return self::validateSubtree($nodeMap[$node->getParent()], $nodeMap, $visitedNodes);
    }

}