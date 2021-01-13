<?php

namespace Tests\Unit;

use App\Models\TeHelper;
use Carbon\Carbon;
use Tests\TestCase;

class WillExpireAtTest extends TestCase
{


    /**
     * A basic unit test example.
     * @runInSeparateProcess
     * @return void
     */
    public function testWillExpireAt()
    {
        $days = rand(2, 5);

        $dueTime = Carbon::now()->addDays($days);
        $createAt = Carbon::now();

        $difference = $dueTime->diffInHours($createAt);

        $teHelper = new TeHelper();
        $response = $teHelper->willExpireAt($dueTime, $createAt);

        if ($difference <= 90)
            $this->assertEquals($dueTime, $response);
        elseif ($difference <= 24) {
            $this->assertEquals($createAt->addMinutes(90), $response);
        } elseif ($difference > 24 && $difference <= 72) {
            $this->assertEquals($createAt->addHours(16), $response);
        } else {
            $this->assertEquals($dueTime->subHours(48), $response);
        }

    }

}
