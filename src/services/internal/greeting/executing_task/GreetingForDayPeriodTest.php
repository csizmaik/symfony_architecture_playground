<?php
/**
 * Created by PhpStorm.
 * User: Norbi
 * Date: 2017. 03. 15.
 * Time: 6:43
 */

namespace services\internal\greeting\executing_task;

use PHPUnit\Framework\TestCase;
use services\internal\day_period\executing_task\DayPeriod;

class GreetingForDayPeriodTest extends TestCase
{
    /**
     * @var GreetingForDayPeriod
     */
    private $greetingForDayPeriod;

    public function setUp()
    {
        $this->greetingForDayPeriod = new GreetingForDayPeriod();
    }

	/**
	 * @test
	 */
    public function shouldSayMorningGreeting() {
        $greeting = $this->greetingForDayPeriod
                                ->greetinForDayPeriod(DayPeriod::MORNING);
        $this->assertEquals("Good Morning!",$greeting);
    }

	/**
	 * @test
	 */
    public function shouldSayDuringDayGreeting() {
        $greeting = $this->greetingForDayPeriod
                                ->greetinForDayPeriod(DayPeriod::DAY);
        $this->assertEquals("Hello!",$greeting);
    }

	/**
	 * @test
	 */
    public function shouldSayEveningGreeting() {
        $greeting = $this->greetingForDayPeriod
            ->greetinForDayPeriod(DayPeriod::EVENING);
        $this->assertEquals("Good Evening!",$greeting);
    }
}
