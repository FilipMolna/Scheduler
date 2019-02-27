<?php
namespace Scheduler;

class Scheduler
{
    protected $terms = [];
    protected $items = [];

    public function __construct($_items, $_terms)
    {
        foreach ($_items as $item) {
            $this->addItem($item);
        }

        foreach ($_terms as $term) {
            $this->addTerm($term);
        }
    }
    
    public function schedule()
    {
        //check overlaping locked terms
        foreach ($this->terms as $key => $term) {
            if ($term->getLockedId() && $term->getItemId() === null) {
                $id = $term->getLockedId();
                foreach ($this->items[$id] as $occupied_term) {
                    $e = new SchedulerException();
                    $occupied = $this->checkConflictingTerms($term, $occupied_term);
                    if($occupied){
                        $e->addConflictingTerms([$term, $occupied_term]);
                        throw $e;
                    }
                }
                $this->terms[$key]->setItemId($id);
                array_push($this->items[$id], $term);
            }
        }

        $e = new SchedulerException();
        //check overlaping terms
        foreach ($this->terms as $key => $term) {
            if ($term->getLockedId()) {
                continue;
            }
            $occupied = false;
            foreach ($this->items as $k => $item) {
                $occupied = false;
                foreach ($this->items[$k] as $occupied_term) {
                    $occupied = $this->checkConflictingTerms($term, $occupied_term);
                    if ($occupied) {
                        break;
                    }
                }
                if (!$occupied) {
                    $this->terms[$key]->setItemId($k);
                    array_push($this->items[$k], $term);
                    break;
                }
            }
            if ($occupied) {
                throw $e;
            }
        }
    }

    public function checkConflictingTerms($term, $occupied_term){
        if ($term->getFrom() <= $occupied_term->getFrom() && $term->getTo() >= $occupied_term->getTo()) {
            return true;
        } elseif ($term->getTo() >= $occupied_term->getFrom() && $term->getTo() <= $occupied_term->getTo()) {
            return true;
        } elseif ($term->getFrom() <= $occupied_term->getTo() && $term->getFrom() >= $occupied_term->getFrom()) {
            return true;
        } else {
            return false;
        }
    }

    public function addItem(int $id)
    {
        if (!array_key_exists($id, $this->items)) {
            $this->items[$id] = [];
        }
    }

    public function addTerm(TermInterface $term)
    {
        array_push($this->terms, $term);
    }
}
