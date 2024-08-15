<?php
    namespace App\Supports\DayClerk;

use App\Enums\DaysOfWeek;
use App\Supports\FindBookings\FindBookingInterface;
use App\Supports\FindBookings\FindBookings;
use Exception;
use Illuminate\Support\Collection;

 class DayClerk implements DayClerkInterface
{
    /**
     * Start day as unix timestamp.
     * @var string
     */
    protected $startUnixTimestamp;

    /**
     * End day as unix timestamp.
     * @var string
     */
    protected $endUnixTimestamp;

    /**
     * Diffrence between the timestamps
     * @var int
     */
    protected $diff;
    /**
     * Diffrence in days between the timestamps.
     * @var int
     */
    protected $diffInDays;
    /**
     * Time of the start day.
     * @var int
     */
    protected $startTime;
    /**
     * Time of the end day.
     * @var int
     */
    protected $endTime;
    /**
     * Diffrence in miliseconds between start day time and end day time
     * @var int
     */
    protected $diffStartEndTime;
    /**
     * Unix timestamp of the start day.
     * @var int
     */
    protected $startDay;

    /**
     * Unix timestamp of the end day.
     * @var int
     */
    protected $endDay;
    /**
     * Duration of booking
     * @var int
     */
    public $duration;

    /**
     * Class to find bookings
     * @var FindBookingInterface
     */
    protected $findBookings;
    public function __construct(string $startDate, string $endDate, FindBookingInterface $findBookings)
    {
   
        $this->startUnixTimestamp=strtotime($startDate);
        $this->endUnixTimestamp=strtotime($endDate);
        $this->diff=$this->endUnixTimestamp-$this->startUnixTimestamp;
        $this->diffInDays=abs(floor($this->diff / 86400));
        $this->endTime = $this->endUnixTimestamp % 86400;
        $this->startTime = $this->startUnixTimestamp % 86400;
        $this->diffStartEndTime = $this->endTime - $this->startTime;

        $this->startDay = floor($this->startUnixTimestamp / 86400) * 86400;
        $this->endDay= floor($this->endUnixTimestamp / 86400) * 86400;

        $this->duration = 30 * 60;

        $this->findBookings=$findBookings;

        // Check if there is at least one Booking model can be created. If not send error message.
        if ($this->diffStartEndTime < $this->duration) {
           throw new Exception('Cannot construct the object. Wrong dates.');
        }
    }

    /**
     * Get an array of dates
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllDates() : Collection
    {
        $dateArray = new Collection();
   
        for ($i = 0; $i <= $this->diffInDays; $i++) {
            $dayArray=$this->startAndEndDateArray(86400 * $i)->toArray();
            $dateArray->push(...$dayArray);
        }

        return $dateArray;
    }

    public function getByDayOfWeek(DaysOfWeek $daysOfWeek) : Collection
    {
        $dateArray = new Collection();
        for ($i = 0; $i <= $this->diffInDays; $i++) {
            $miliday=86400 * $i;
            $dayOfWeek=(int)date('N',$this->startDay+$miliday);
            if($dayOfWeek === $daysOfWeek->value)
            {
            $dayArray=$this->startAndEndDateArray($miliday)->toArray();
            $dateArray->push(...$dayArray);
            }
        }
        return $dateArray;
    } 
    
    /**
     * Return a collection of start and end date for a day
     * @return void
     */
    protected function startAndEndDateArray($daysInMili) : Collection
    {
        // For every day create time variable which is set every 30 min since start time
        $controlTime = $this->startTime;

        // Collection of the dates
        $dateArray = new Collection();
        
        while($controlTime+$this->duration <= $this->endTime) {
          
        

            //Var for model creation.
            $startDateTimestamp = $this->startDay + $daysInMili + $controlTime;
            $startDate = date('Y-m-d H:i:s', $startDateTimestamp);
            $endDateTimestamp = $startDateTimestamp + $this->duration;
            $endDate = date('Y-m-d H:i:s', $endDateTimestamp);
            //Find booking in conflict with creating model.
            $conflicts = $this->findBookings->byDays($startDate, $endDate);
           
            if(count($conflicts)===0)
            {
                
                $dateArray->push([$startDate,$endDate]);
            }
            
            $controlTime += $this->duration;
           
        } 
        return $dateArray;
    }

    

}