<?php
namespace spec\Scheduler;

use PhpSpec\ObjectBehavior;
use Scheduler\SchedulerException;
use Scheduler\TermInterface;

class SchedulerSpec extends ObjectBehavior
{
    public function let(TermInterface $term1, TermInterface $term2, TermInterface $term3, TermInterface $term4)
    {
        $items = [1, 2];

        $term1->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 07:00:00'));
        $term1->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 12:00:00'));
        $term1->getLockedId()->willReturn(null);
        $term1->getItemId()->willReturn(null);

        $term2->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 13:00:00'));
        $term2->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 16:00:00'));
        $term2->getLockedId()->willReturn(1);
        $term2->getItemId()->willReturn(null);

        $term3->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 08:00:00'));
        $term3->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 14:00:00'));
        $term3->getLockedId()->willReturn(null);
        $term3->getItemId()->willReturn(null);

        $term4->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 17:00:00'));
        $term4->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 20:00:00'));
        $term4->getLockedId()->willReturn(2);
        $term4->getItemId()->willReturn(null);

        $this->beConstructedWith($items, [$term1, $term2, $term3, $term4]);
    }

    public function it_checks_more_overlaping_terms_than_items($term1, $term2, $term3, $term4, TermInterface $term5)
    {
        $term5->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 09:00:00'));
        $term5->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 15:00:00'));
        $term5->getLockedId()->willReturn(null);
        $term5->getItemId()->willReturn(null);

        $term1->setItemId(1)->shouldBeCalled();
        $term2->setItemId(1)->shouldBeCalled();
        $term3->setItemId(2)->shouldBeCalled();
        $term4->setItemId(2)->shouldBeCalled();

        $this->addTerm($term5);

        $this->shouldThrow(SchedulerException::class)->duringSchedule();
    }

    public function it_checks_two_overlaping_terms_locked_to_same_item($term1, $term2, $term3, $term4, TermInterface $term5)
    {
        $term5->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 19:00:00'));
        $term5->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 21:00:00'));
        $term5->getLockedId()->willReturn(2);
        $term5->getItemId()->willReturn(null);

        $term2->setItemId(1)->shouldBeCalled();
        $term4->setItemId(2)->shouldBeCalled();

        $this->addTerm($term5);

        $this->shouldThrow(SchedulerException::class)->duringSchedule();
    }

    public function it_checks_solvable_schedule($term1, $term2, $term3, $term4, TermInterface $term5)
    {
        $term5->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 21:00:00'));
        $term5->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 23:00:00'));
        $term5->getLockedId()->willReturn(null);
        $term5->getItemId()->willReturn(null);
        $this->addTerm($term5);

        $term1->setItemId(1)->shouldBeCalled();
        $term2->setItemId(1)->shouldBeCalled();
        $term3->setItemId(2)->shouldBeCalled();
        $term4->setItemId(2)->shouldBeCalled();
        $term5->setItemId(1)->shouldBeCalled();

        $this->schedule();
    }

    public function it_checks_complex_solvable_schedule($term1, $term2, $term3, $term4, TermInterface $term5, TermInterface $term6, TermInterface $term7, TermInterface $term8, TermInterface $term9, TermInterface $term10, TermInterface $term11, TermInterface $term12, TermInterface $term13, TermInterface $term14, TermInterface $term15, TermInterface $term16, TermInterface $term17, TermInterface $term18, TermInterface $term19){
        $items = [1, 2, 3, 4];

        $term1->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 01:00:00'));
        $term1->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 03:00:00'));
        $term1->getLockedId()->willReturn(null);
        $term1->getItemId()->willReturn(null);

        $term2->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 01:00:00'));
        $term2->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 03:00:00'));
        $term2->getLockedId()->willReturn(null);
        $term2->getItemId()->willReturn(null);

        $term3->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 01:00:00'));
        $term3->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 04:00:00'));
        $term3->getLockedId()->willReturn(null);
        $term3->getItemId()->willReturn(null);

        $term4->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 01:00:00'));
        $term4->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 05:00:00'));
        $term4->getLockedId()->willReturn(null);
        $term4->getItemId()->willReturn(null);

        $term5->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 07:00:00'));
        $term5->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 12:00:00'));
        $term5->getLockedId()->willReturn(null);
        $term5->getItemId()->willReturn(null);

        $term6->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 04:00:00'));
        $term6->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 06:00:00'));
        $term6->getLockedId()->willReturn(null);
        $term6->getItemId()->willReturn(null);

        $term7->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 04:00:00'));
        $term7->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 11:00:00'));
        $term7->getLockedId()->willReturn(null);
        $term7->getItemId()->willReturn(null);

        $term8->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 13:00:00'));
        $term8->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 18:00:00'));
        $term8->getLockedId()->willReturn(null);
        $term8->getItemId()->willReturn(null);

        $term9->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 13:00:00'));
        $term9->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 14:00:00'));
        $term9->getLockedId()->willReturn(null);
        $term9->getItemId()->willReturn(null);

        $term10->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 08:00:00'));
        $term10->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 10:00:00'));
        $term10->getLockedId()->willReturn(null);
        $term10->getItemId()->willReturn(null);

        $term11->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 11:00:00'));
        $term11->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 18:00:00'));
        $term11->getLockedId()->willReturn(null);
        $term11->getItemId()->willReturn(null);

        $term12->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 06:00:00'));
        $term12->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 08:00:00'));
        $term12->getLockedId()->willReturn(null);
        $term12->getItemId()->willReturn(null);

        $term13->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 05:00:00'));
        $term13->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 07:00:00'));
        $term13->getLockedId()->willReturn(null);
        $term13->getItemId()->willReturn(null);

        $term14->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 16:00:00'));
        $term14->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 23:00:00'));
        $term14->getLockedId()->willReturn(null);
        $term14->getItemId()->willReturn(null);

        $term15->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 16:00:00'));
        $term15->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 18:00:00'));
        $term15->getLockedId()->willReturn(null);
        $term15->getItemId()->willReturn(null);

        $term16->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 20:00:00'));
        $term16->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 23:00:00'));
        $term16->getLockedId()->willReturn(null);
        $term16->getItemId()->willReturn(null);

        $term17->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 19:00:00'));
        $term17->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 21:00:00'));
        $term17->getLockedId()->willReturn(null);
        $term17->getItemId()->willReturn(null);

        $term18->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 22:00:00'));
        $term18->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 23:00:00'));
        $term18->getLockedId()->willReturn(null);
        $term18->getItemId()->willReturn(null);

        $term19->getFrom()->willReturn(new \DateTimeImmutable('2019-01-01 21:00:00'));
        $term19->getTo()->willReturn(new \DateTimeImmutable('2019-01-01 22:00:00'));
        $term19->getLockedId()->willReturn(null);
        $term19->getItemId()->willReturn(null);
        
        $this->addTerm($term5);
        $this->addTerm($term6);
        $this->addTerm($term7);
        $this->addTerm($term8);
        $this->addTerm($term9);
        $this->addTerm($term10);
        $this->addTerm($term11);
        $this->addTerm($term12);
        $this->addTerm($term13);
        $this->addTerm($term14);
        $this->addTerm($term15);
        $this->addTerm($term16);
        $this->addTerm($term17);
        $this->addTerm($term18);
        $this->addTerm($term19);

        $this->addItem(3);
        $this->addItem(4);

        $term1->setItemId(1)->shouldBeCalled();
        $term2->setItemId(2)->shouldBeCalled();
        $term3->setItemId(3)->shouldBeCalled();
        $term4->setItemId(4)->shouldBeCalled();
        $term5->setItemId(1)->shouldBeCalled();
        $term6->setItemId(1)->shouldBeCalled();
        $term7->setItemId(2)->shouldBeCalled();
        $term8->setItemId(1)->shouldBeCalled();
        $term9->setItemId(2)->shouldBeCalled();
        $term10->setItemId(3)->shouldBeCalled();
        $term11->setItemId(3)->shouldBeCalled();
        $term12->setItemId(4)->shouldBeCalled();
        $term13->setItemId(3)->shouldBeCalled();
        $term14->setItemId(2)->shouldBeCalled();
        $term15->setItemId(4)->shouldBeCalled();
        $term16->setItemId(1)->shouldBeCalled();
        $term17->setItemId(3)->shouldBeCalled();
        $term18->setItemId(3)->shouldBeCalled();
        $term19->setItemId(4)->shouldBeCalled();

        $this->schedule();
    }
}
