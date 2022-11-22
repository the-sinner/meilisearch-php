<?php

declare(strict_types=1);

namespace Tests\Contracts;

use MeiliSearch\Contracts\TasksQuery;
use PHPUnit\Framework\TestCase;

class CancelTasksQueryTest extends TestCase
{
    public function testSetTypes(): void
    {
        $data = (new TasksQuery())->setTypes(['abc', 'xyz']);

        $this->assertEquals($data->toArray(), ['types' => 'abc,xyz']);
    }

    public function testSetNext(): void
    {
        $data = (new TasksQuery())->setNext(99);

        $this->assertEquals($data->toArray(), ['next' => 99]);
    }

    public function testSetAnyDateFilter(): void
    {
        $date = new \DateTime();
        $data = (new TasksQuery())->setBeforeEnqueuedAt($date);

        $this->assertEquals($data->toArray(), ['beforeEnqueuedAt' => $date->format(\DateTime::RFC3339)]);
    }

    public function testToArrayWithSetNextWithZero(): void
    {
        $data = (new TasksQuery())->setNext(0);

        $this->assertEquals($data->toArray(), ['next' => 0]);
    }

    public function testToArrayWithDifferentSets(): void
    {
        $data = (new TasksQuery())->setFrom(10)->setLimit(9)->setNext(99)->setStatuses(['enqueued']);

        $this->assertEquals($data->toArray(), [
            'limit' => 9, 'next' => 99, 'from' => 10, 'statuses' => 'enqueued',
        ]);
    }
}
