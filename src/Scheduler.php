<?php
namespace Scheduler;

class Scheduler
{
    protected $terms = [];
    protected $items = [];

    public function __construct($_items, $_terms)
    {
        $this->addItems($_items);
        $this->addTerms($_terms);
    }

    public function schedule()
    {
        //checks overlaping locked terms
        foreach ($this->terms as $key => $term) {
            if ($term->getLockedId() && $term->getItemId() === null) {
                $id = $term->getLockedId();

                //checks terms with already locked terms to item
                foreach ($this->items[$id] as $occupied_term) {
                    $e = new SchedulerException();
                    $occupied = $this->checkConflictingTerms($term, $occupied_term);

                    if ($occupied) {
                        $e->addConflictingTerms([$term, $occupied_term]);
                        //if two terms overlap, throw exception
                        throw $e;
                    }
                }
                //if no terms overlap, add term to item, set item id to this term
                $this->terms[$key]->setItemId($id);
                array_push($this->items[$id], $term);
            }
        }

        //checks not locked overlaping terms
        $e = new SchedulerException();

        foreach ($this->terms as $key => $term) {
            if ($term->getLockedId()) {
                continue;
            }
            $occupied = false;

            //for each item checks already occupied terms with term
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

    public function checkConflictingTerms($term, $occupied_term): bool
    {
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

    public function addItems($items)
    {
        foreach ($items as $id) {
            if (!array_key_exists($id, $this->items)) {
                $this->items[$id] = [];
            }
        }
    }

    public function addTerms($terms)
    {
        foreach ($terms as $term) {
            $this->terms[] = $term;
        }
    }

    public function getTerms(): array
    {
        return $this->terms;
    }
}
