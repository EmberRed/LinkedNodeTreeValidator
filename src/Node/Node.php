<?php
namespace TreeValidator\Node;

final class Node
{

    public function __construct(
        private int $id,
        private ?int $parent
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getParent(): ?int
    {
        return $this->parent;
    }

}