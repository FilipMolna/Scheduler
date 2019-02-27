<?php
namespace Scheduler;

interface TermInterface
{
    public function getFrom(): \DateTimeImmutable;

    public function getTo(): \DateTimeImmutable;

    public function getLockedId(): ?int;

    public function setItemId(?int $id);

    public function getItemId(): ?int;
}
