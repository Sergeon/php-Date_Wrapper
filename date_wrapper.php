<?php


/**
 *
 * @author Sergeon https://github.com/Sergeon/ mauro_caffarat@gmail.com
 * version 1.0
 *
 * Wrapper class to DateTime class. Working with an internal DateTime object, it
 * has a cleaner interface with a bunch of methods that isolates user to be aware about
 * datetime formats and period time formats.
 *
 * Most functions are chainable.
 *
 * __toString method is provided based on an output format, which defaults to timestamp.
 *
 *	forge() is a chainable static constructor.
 *
 */
class Date_Wrapper{

	/**
	 * internal DateTime object
	 * @var DateTime
	 */
	private $date_time;

	/**
	 * format to manage __toString output
	 * @var string
	 */
	private $to_string_format;

	/**
	 *
	 * @param mixed $time_constructor DateTime object or string to create a DateTime
	 * @param string $to_string_format valid string passable to DateTime::format() function or 'timestamp', wich
	 * 	will make __toString() method to return the timestamp.
	 * @throws Exception
	 */
	public function __construct( $time_constructor = "now", $to_string_format = "timestamp" ){

		$type = gettype($time_constructor);

		try{
			if ($type == "string")
				$this->date_time = new DateTime($time_constructor);
			else if ($type == 'object' && get_class($time_constructor) === 'DateTime')
				$this->date_time = $time_constructor;
			else
				throw new Exception("DateWrapper constructor only admits DateTime object or string as first parameter");
		}
		catch (Exception $ex){

			throw $ex;
		}

	}//end __construct


	/**
	 * returns new static instance.
	 * @param mixed $time_constructor DateTime object or string to create a DateTime
	 * @param string $to_string_format valid string passable to DateTime::format() function or 'timestamp', wich
	 * 	will make __toString() method to return the timestamp.
	 * @throws Exception when parameter is invalid
	 */
	public static function forge($time_constructor = "now"){

		return new static($time_constructor);
	}


	/**
	 * returns internal date_time
	 * @return DateTime
	 */
	public function get_date_time(){

		return $this->date_time;
	}

	/**
	 * Outputs a result based on internal to_string_format.
	 * @return string
	 */
	public function __toString(){

		if ($this->to_string_format === "timestamp")
			return $this->date_time->getTimestamp();
		else
			return $this->date_time->format($this->to_string_format);

	}//end to string

	/**
	 * Returns date as UNIX timestamp
	 */
	public function get_timestamp(){

		return $this->date_time->getTimestamp();
	}

	/**
	 * Returns date formatted according to given format.
	 * @param string $format
	 */
	public function format( $format ){

		return $this->date_time->format($format);
	}//end format()

	/**
	 * return the year of the date with 4 digits format.
	 * @return string
	 */
	public function get_year(){

		$year = $this->date_time->format("Y");
		return $year;

	}

	/**
	 * return the months of the date with two digits format
	 * @return string
	 */
	public function get_month(){

		$month = $this->date_time->format('m');
		return $month;
	}

	/**
	 * returns the day of the date with two digits format
	 * @return string
	 */
	public function get_day(){

		$day = $this->date_time->format('d');
		return $day;

	}

	public function get_day_clean(){
		return $this->date_time->format( 'j' );
	}


	/**
	 * returns week day based on format
	 * @param  string $format format of day
	 * @return multi int|string the day of the week in different formats
	 */
	public function get_week_day( $format = 'w' ){

		return $this->date_time->format( $format );
	}




	/**
	 * returns week day in string format
	 * @return multi string the day of the week in different formats
	 */
	public function get_week_day_str(){

		return $this->date_time->format('D');
	}

	public function get_hour(){

		return $this->date_time->format('h');
	}

	public function get_hour_strict(){

		return $this->date_time->format('H');
	}


	public function get_minute(){

		return $this->date_time->format('i');
	}


	public function get_second(){

		return $this->date_time->format('s');
	}

	/**
	 * Returns wether the date is in the past.
	 * passing true as $strict will check to seconds. Check to days by default.
	 * @param boolean $strict
	 * @return boolean
	 */
	public function is_past( $strict = false ){

		if ($strict)
			return $this->date_is_past();

		return $this->time_is_past();
	}

	/**
	 * Returns wether the date is in the future.
	 * passing true as $strict will check to seconds. Check to days by default.
	 * @param boolean $strict
	 * @return boolean
	 */
	public function is_future( $strict = false ){

		return ! $this->is_past( $strict );
	}


	/**
	 * return if the date is in the past at level of days.
	 * @return boolean
	 */
	private function date_is_past(){

		$now = new DateTime();
		return $this->date_time->diff($now)->invert === 0;
	}

	/**
	 * return if the date is in the future at level of days.
	 * @return boolean
	 */
	private function date_is_future(){

		$now = new DateTime();
		return ! $this->date_is_past();
	}

	/**
	 * return if the date is in the past at level of timestamp.
	 * @return boolean
	 */
	private function time_is_past(){

		$this_timestamp = $this->get_timestamp();

		$now = new DateTime();

		$now_timestamp = $now->getTimestamp();

		return $now_timestamp > $this_timestamp;

	}

	/**
	 * return if the date is in the future at level of timestamp.
	 * @return boolean
	 */
	private function time_is_future(){
		return ! $this->time_is_past();
	}

	/**
	 * add days to this. To pass negative amount of days is available.
	 * @param integer $days
	 */
	public function add_days( $days){

		if ($days > 0)
			$this->date_time->add( new DateInterval("P" . $days . "D") );
		else
			$this->date_time->sub( new DateInterval("P" . -$days . "D") );

		return $this;
	}

	/**
	 * Substracts an amount of days to this.
	 * @param integer $days
	 * @throws Exception when param is < 1
	 */
	public function sub_days( $days ){

		$this->date_time->sub( new DateInterval("P" . $days . "D") );
		return $this;
	}


	public function add_months( $months ){

		if ($months > 0)
			$this->date_time->add( new DateInterval("P" . $months . "M") );
		else
			$this->date_time->sub( new DateInterval("P" . -$months . "M") );

		return $this;
	}

	/**
	 * susbtracts an amount of months to this.
	 * chainable.
	 * @param int $months
	 * @return Date_Wrapper
	 */
	public function sub_months( $months){
		$this->date_time->sub( new DateInterval("P" . $months . "M") );
		return $this;

	}

	public function add_years( $years ){

		if ($years > 0)
			$this->date_time->add( new DateInterval("P" . $years . "Y") );
		else
			$this->date_time->sub( new DateInterval("P" . -$years . "Y") );

		return $this;
	}

	/**
	 * substracts an amount of years to this.
	 * chainable.
	 * @param unknown $years
	 * @return Date_Wrapper
	 */
	public function sub_years( $years ){

		$this->date_time->sub( new DateInterval("P" . $years . "Y") );
		return $this;
	}


	public function add_hours( $hours){

		if ($hours > 0)
			$this->date_time->add( new DateInterval("PT" . $hours . "H") );
		else
			$this->date_time->sub( new DateInterval("PT" . -$hours . "H") );

		return $this;
	}


	/**
	 * susbtracts an amount of hours to this.
	 * chainable.
	 * @param int $hours
	 * @return Date_Wrapper
	 */
	public function sub_hours( $hours ){

		$this->date_time->sub( new DateInterval("PT" . $hours . "H") );
		return $this;
	}

	/**
	 * adds a positive or negative amount of minutes to this.
	 * chainable.
	 * @param int $minutes
	 * @return Date_Wrapper
	 */
	public function add_minutes( $minutes ){

		if ($minutes > 0)
			$this->date_time->add( new DateInterval("PT" . $minutes . "M") );
		else
			$this->date_time->sub( new DateInterval("PT" . -$minutes . "M") );

		return $this;
	}

	/**
	 * susbtracts an amount of minutes to this.
	 * chainable.
	 * @param int $minutes
	 * @return Date_Wrapper
	 */
	public function sub_minutes( $minutes ){
		$this->date_time->sub( new DateInterval("PT" . $minutes . "M") );
		return $this;
	}


	/**
	 * adds a positive or negative amount of seconds to this.
	 * chainable.
	 * @param int $seconds
	 * @return Date_Wrapper
	 */
	public function add_seconds( $seconds ){

		if ( $seconds > 0)
			$this->date_time->add( new DateInterval( "PT" . $seconds . "S" ) );
		else
			$this->date_time->sub( new DateInterval( "PT" . -$seconds . "S" ) );

		return $this;
	}

	/**
	 * Substracts an amount of seconds.
	 * chainable.
	 * @param int $seconds
	 * @return Date_Wrapper
	 */
	public function sub_seconds( $seconds){
		$this->date_time->sub( new DateInterval( "PT" . $seconds . "S" ) );
		return $this;
	}


	/**
	 * substracts a period of time to this.
	 * delegates to internal DateTime object sub() function. String DateInterval builder can be passed
	 * chainable
	 * @param mixed $period DateInterval object or string DateInterval builder
	 * @throws Exception
	 */
	public function sub( $period ){

		if (gettype( $period ) === 'string' ){
			$this->date_time->sub(new DateInterval($period) );
			return $this;
		}
		else if ( gettype($period) === 'object' && get_class('period') === 'DateInterval' ){
			$this->date_time->sub( $period );
			return $this;
		}


		throw new Exception("function DateWrapper::sub only expects DateInterval objects or period time string builders");

	}


	/**
	 * adds a period of time to this.
	 * delegates to internal DateTime object add() function. String DateInterval builder can be passed
	 * chainable
	 * @param mixed $period DateInterval object or string DateInterval builder
	 * @throws Exception
	 */
	public function add($period){

		if (gettype( $period ) === 'string' ){
			$this->date_time->add(new DateInterval($period) );
			return $this;
		}
		else if ( gettype($period) === 'object' && get_class('period') === 'DateInterval' ){
			$this->date_time->add( $period );
			return $this;
		}

		throw new Exception("function DateWrapper::add only expects DateInterval objects or period time string builders");

	}


	/**
	 * asserts $this equals to target
	 * @param mixed $date_object DateTime or Date_Wrapper object
	 * @param string $granularity Level of granularity to do the comparison.
	 * @throws Exception when not valid parameters are provided
	 * @return boolean
	 */
	public function equal( $date_object , $granularity = 'd' ){

		switch( $granularity ){

			case 'y' : return $this->equal_year($date_object);
			case 'm' : return $this->equal_month($date_object);
			case 'd' : return $this->equal_day($date_object);
			case 'h' : return $this->equal_hour($date_object);
			case 'i' : return $this->equal_minute($date_object);
			case 's' : return $this->equal_second($date_object);

			default :
					throw new Exception( '$granularity parameter was not valid. Only "y", "m","d","h","i","s" are valid values.');

		}
	}



	/**
	 * Ultility function to construct equal functions, by receiving proper functions as callbacks.
	 * @param mixed $date_object DateTime or Date_Wrapper objects
	 * @param callable $date_object_callback method of the Date_Wrapper object to be called
	 * @param string $date_time_callback_parameter param to format() DateTime method.
	 * @param callable $date_time_callback DateTime method to get date, format() by default
	 * @throws Exception When no DateTime or Date_Wrapper objects are passed as $date_object
	 * @return boolean
	 */
	private function equal_builder( $date_object , $date_object_callback  , $date_time_callback_parameter , $date_time_callback = 'format' ){

		if (get_class($date_object) === 'Date_Wrapper' )
			return call_user_func_array( array( $date_object, $date_object_callback) , array() ) === call_user_func_array( array($this , $date_object_callback ) , array()  );
		else if (get_class($date_object) === 'DateTime')
			return (string )   call_user_func_array( array( $date_object, $date_time_callback) , array( $date_time_callback_parameter ) ) === call_user_func_array( array($this , $date_object_callback ) , array()  );

		throw new Exception("Only Date_Wrapper and DateTime objects can be passed to Date_Wrapper::" . __METHOD__ );

	}

	/**
	 * states if $this share year with target
	 * @param mixed $date_object DateTime or Date_Wrapper object
	 * @throws Exception if parameter has not the correct type
	 * @return boolean
	 */
	public function equal_year( $date_object ){

		return $this->equal_builder( $date_object , "get_year" ,  'Y' );
	}

	/**
	 * states if $this share both year and month with target
	 * @param mixed $date_object $date_object DateTime or Date_Wrapper object
	 * @throws Exception if parameter has not the correct type
	 * @return boolean
	 */
	public function equal_month( $date_object ){

		$months_are_equal = $this->equal_builder($date_object, 'get_month' ,  'm' );

		return $this->equal_year($date_object) && $months_are_equal;
	}


	/**
	 * states if $this shares year, month and day with target
	 * @param mixed $date_object DateTime or Date_Wrapper object
	 * @throws Exception if parameter has not the correct type
	 * @return boolean
	 */
	public function equal_day( $date_object ){
		$days_are_equal = $this->equal_builder($date_object, 'get_day' ,  'd' );

		return $days_are_equal && $this->equal_month($date_object) ;
	}


	/**
	 * states if $this shares year, month, day and hour with target
	 * @param mixed $date_object  DateTime or Date_Wrapper object
	 * @throws Exception if parameter has not the correct type
	 * @return boolean
	 */
	public function equal_hour( $date_object){
		$hours_are_equal = $this->equal_builder( $date_object , 'get_hour' , 'h');

		return $hours_are_equal && $this->equal_day( $date_object );
	}


	/**
	 * states if $this shares year, month, day, hour and minute with target
	 * @param mixed $date_object  DateTime or Date_Wrapper object
	 * @throws Exception if parameter has not the correct type
	 * @return boolean
	 */
	public function equal_minute( $date_object ){

		$minutes_are_equal = $this->equal_builder( $date_object , 'get_minute' , 'i' );

		return $minutes_are_equal && $this->equal_hour($date_object);
	}


	/**
	 * states if $this shares year, month, day, hour, minute and second with target
	 * @param mixed $date_object DateTime or Date_Wrapper object
	 * @throws Exception if parameter has not the correct type
	 * @return boolean
	 */
	public function equal_second( $date_object ){

		$seconds_are_equal = $this->equal_builder($date_object, 'get_second' , 's');

		return $seconds_are_equal && $this->equal_minute($date_object);
	}


	/**
	 * states if $this timestamp equals with target's
	 * @param mixed $date_object DateTime or Date_Wrapper object
	 * @throws Exception if parameter has not the correct type
	 * @return boolean
	 */
	public function equal_timestamp( $date_object){

		if (get_class($date_object) === 'Date_Wrapper')
			return $this->get_timestamp() === $date_object->get_timestamp();

		else if ( get_class($date_object) === 'DateTime' )
			return $this->get_timestamp() === $date_object->getTimestamp();

		throw new Exception(" Date_Wrapper::equal_timestamp only accepts DateTime or Date_Wrapper objects as parameter");

	}



	/**
	*Iterates from $this to current date, calling a $do function in every iteration
	*Warning: $params paremeter must be passed by reference to the $do function to be actually touched by this method.
	*@param mixed $date a Date object
	*@param mixed $params parameter to be passed to the $do function
	*@param function $do function( $key , $date_time , $begin , $end ), where $key is the DatePeriod used to iterate,
	*$date_time is the DatePeriod DateTime in every iteration, $begin is the older of the two Date_Wrapper passed to iterate, and
	*$end the future Date_Wrapper
	*TODO add DateInterval paramenter an allow any kind of interval iteration
	*
	*/
	public function iterate( $date , &$params ,  $do  ){

		$this_ts = $this->get_timestamp();
		$date_ts = $date->get_timestamp();



		if($date->get_timestamp() > $this->get_timestamp()){
			$begin = $this;
			$end = $date;
		}
		else{
			$begin = $date;
			$end = $this;
		}

		$interval = new DateInterval('P1D');
		$period = new DatePeriod($begin->get_date_time(), $interval, $end->get_date_time() );

		$i = 0;

		foreach ( $period as $key =>  $dt ){
			$i++;
			if ($i > 20)
				break;
			$do( $key , $dt ,  $params , $this , $date  );
		}
	}

}//end class
