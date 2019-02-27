<?php
namespace Scheduler;

class SchedulerException extends \Exception
{
    private $conflictingTerms = [];

    public function addConflictingTerms($terms)
    {
        array_push($this->conflictingTerms, $terms);
    }

    public function getConflictingTerms()
    {
        return $this->conflictingTerms;
    }
}
