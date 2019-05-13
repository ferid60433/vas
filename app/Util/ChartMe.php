<?php

namespace Vas\Util;

use Carbon\Carbon;
use Vas\ReceivedMessage;
use Vas\SentMessage;

class ChartMe
{
    public function lastDaysWeekdays()
    {
        return collect(range(6, 0))
            ->map(function (int $number) {
                return Carbon::now()->subDay($number)->format('l');
            })
            ->values();
    }

    public function sentStat()
    {
        $lastWeek = $this->lastWeek();

        $sent = SentMessage::where('created_at', '>', $lastWeek)->latest()->get()
            ->groupBy(function (SentMessage $message) {
                return $message->created_at->toDateString();
            })
            ->map(function ($collection) {
                return $collection->count();
            });

        $this->lastDayDateString()->each(function ($day) use ($sent) {
            if (!$sent->has($day)) {
                $sent->put($day, 0);
            }
        });

        return $sent->sortKeys()->values();
    }

    public function lastWeek()
    {
        return Carbon::now()->subWeek()->setTime(23, 59, 59);
    }

    public function lastDayDateString()
    {
        return collect(range(6, 0))
            ->map(function (int $number) {
                return Carbon::now()->subDay($number)->toDateString();
            })
            ->values();
    }

    public function deliveredStat()
    {
        $lastWeek = $this->lastWeek();

        $delivered = SentMessage::where('created_at', '>=', $lastWeek)
            ->whereDeliveryStatus(1)->latest()->get()
            ->groupBy(function (SentMessage $message) {
                return $message->created_at->toDateString();
            })
            ->map(function ($collection) {
                return $collection->count();
            });

        $this->lastDayDateString()->each(function ($day) use ($delivered) {
            if (!$delivered->has($day)) {
                $delivered->put($day, 0);
            }
        });

        return $delivered->sortKeys()->values();
    }

    public function mtStat()
    {
        $lastWeek = $this->lastWeek();

        $delivered = SentMessage::where('created_at', '>=', $lastWeek)
            ->whereNotNull('service_id')->latest()->get()
            ->groupBy(function (SentMessage $message) {
                return $message->created_at->toDateString();
            })
            ->map(function ($collection) {
                return $collection->count();
            });

        $this->lastDayDateString()->each(function ($day) use ($delivered) {
            if (!$delivered->has($day)) {
                $delivered->put($day, 0);
            }
        });

        return $delivered->sortKeys()->values();
    }

    public function receivedStat()
    {
        $lastWeek = $this->lastWeek();

        $received = ReceivedMessage::where('created_at', '>=', $lastWeek)->latest()->get()
            ->groupBy(function (ReceivedMessage $message) {
                return $message->created_at->toDateString();
            })
            ->map(function ($collection) {
                return $collection->count();
            });

        $this->lastDayDateString()->each(function ($day) use ($received) {
            if (!$received->has($day)) {
                $received->put($day, 0);
            }
        });

        return $received->sortKeys()->values();
    }

}
