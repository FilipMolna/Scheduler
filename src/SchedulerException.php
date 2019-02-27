<?php
namespace Riesenia\Scheduler;

class SchedulerException extends \Exception
{
    private $conflictingTerms = [];

    public function addConflictingTerms($terms)
    {
        $this->conflictingTerms[] = $terms;
    }

    public function getConflictingTerms(): array
    {
        return $this->conflictingTerms;
    }
}
