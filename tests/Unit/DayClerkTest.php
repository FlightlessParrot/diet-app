<?php

namespace Tests\Unit;

use App\Enums\DaysOfWeek;
use App\Supports\DayClerk\DayClerk;
use App\Supports\FindBookings\FindBookings;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class DayClerkTest extends TestCase
{
    
    public function test_Day_Clerk_gives_array_of_dates(): void
    {
        $time=time();
        $mock = $this->createMock('\App\Supports\FindBookings\FindBookings');
        $mock->method('byDays')->willReturn(new Collection);
        $clerk = new DayClerk(date('c',$time),date('c',$time+(86400*7)+60*30*2),$mock);
        $array=$clerk->getAllDates();

        $this->assertCount(16,$array);
        $this->assertEquals($array[0][1],$array[1][0]);
        $this->assertEquals($array[2][1],$array[3][0]);

        foreach($array as $dateArray)
        {
            $this->assertEquals(strtotime($dateArray[0])+$clerk->duration,strtotime($dateArray[1]));
        }

    }

    public function test_Day_Clerk_gives_array_of_dates_by_day_of_week(): void
    {
        $time=time();
        $day=(int)date('N',$time);
        $weekDay=DaysOfWeek::from($day);
        $mock = $this->createMock('\App\Supports\FindBookings\FindBookings');
        $mock->method('byDays')->willReturn(new Collection);
        $clerk = new DayClerk(date('c',$time),date('c',$time+86400*7+60*30*2),$mock);

        $array=$clerk->getByDayOfWeek($weekDay);

        $this->assertCount(4,$array);
        $this->assertEquals($array[0][1],$array[1][0]);
        $this->assertEquals($array[2][1],$array[3][0]);

        foreach($array as $dateArray)
        {
            $this->assertEquals(strtotime($dateArray[0])+$clerk->duration,strtotime($dateArray[1]));
        }

    }
}
