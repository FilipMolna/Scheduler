# Scheduler
PHP script providing basic scheduling functionality.

## Usage

Constructor may take two parameters:

* items
* terms that are passed to scheduler method

```php
use Scheduler\Scheduler;

$items = [1, 2];
$terms = [$term1, $term2, $term3, $term4];

$scheduler = new Scheduler($items, $terms);
```

## Manipulating Terms and Items
Items and Terms can be also added separately. All added terms have to implement *TermInterface*.

```php
$scheduler->addItems([1, 2, 3, 4]);
//adding terms (terms have to implement TermInterface)
$scheduler->addTerms([$term1, $term2, $term3, $term4]);
```

## Schedule method
Schedule method schedules terms to items corectly. If it is not possible, scheduler will throw exception and tell you where two terms overlap.

```php
$scheduler->schedule();
//getTerms method will return an array of terms with ItemIds
$scheduler->getTerms();
```