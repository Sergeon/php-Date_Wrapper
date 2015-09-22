Date_Wrapper
==========================================
A wrapper class to php DateTime class wich aims to simplify lots of common operations with dates and isolates   programmers to be aware of time formats and php date and time internals. 

[![License](https://poser.pugx.org/leaphly/cart-bundle/license.png)](https://packagist.org/packages/leaphly/cart-bundle)

## Author
Mauro Caffaratto

## License
licensed under the MIT and GPL licenses


	Working with an internal DateTime object, Date_Wrapper
	has a cleaner interface with a bunch of methods that isolates user to be aware about
	datetime formats and period time formats.

	Most functions are chainable.

	__toString method is provided based on an output format, which defaults to timestamp.
 
	forge() is a chainable static constructor.
 
### Api

forge( $time_constructor = 'now' , $to_string_format='timestamp');
-----
	returns a new static instance
 
get_date_time();
-----
	returns an internal DateTime object, which is commonly used to make all the date and time operations.
 
get_timestamp();
-----
	returns the object timestamp.
 
format($format);
-----
	Delegates on inner DateTime format() method.
 
get_year();
-----
	Returns the year with 4 digit format.
 
get_month();
-----
	Returns the month as 2 digit format.
 
get_day();
-----
	Returns the day as 2 digits day.
 
get_week_day();
-----
	Returns the day of the week, sunday beign 0 and saturday 6.
 
get_week_day_str();
-----
	Returns the day of the week with a simple string format, like 'SUN' or 'MON'
 
get_hour();
-----
	Returns the hour from 00 to 23
 
get_minute();
-----
	Returns the minute from 00 to 59
 
get_second();
-----
	Returns the second from 00 to 59
 
 
is_past( $strict = false );
-----
	Returns if the date is past. If $strict, returns if the time is past, with a resolution of seconds. 
 
is_future($strict = false);
-----
	Returns if the date is future. If $strict, returns if the time is past, with a resolution of seconds.
 
add_days($days);
-----
	Adds $days days to the date internally.
 
sub_days($days);
-----
	Substracts $days days form the date internally.
 
add_months($months);
-----
	Adds $months months to the date internally.
 
sub_months($months);
-----
	Substracts $months months form the date internally.
 
 
add_years($years);
-----
	Adds $years years to the date internally.
 
sub_years($years);
-----
	Substracts $years years form the date internally.


add_hours($hours);
-----
	Adds $hours hours to the date internally.
 
sub_hours($hours);
-----
	Substracts $hours hours form the date internally.
 
 
add_minutes($minutes);
-----
	Adds $minutes minutes to the date internally.
 
sub_minutes($minutes);
-----
	Substracts $minutes minutes form the date internally.


add_seconds($seconds);
-----
	Adds $seconds seconds to the date internally.
 
sub_seconds($seconds);
-----
	Substracts $seconds seconds form the date internally.


sub( $period );
-----
	Delegates to inner DateTime sub() method. Both a DateInterval or a string to construct a DateInterval can be passed 	as paramenter.


add( $period );
-----
	Delegates to inner DateTime add() method. Both a DateInterval or a string to construct a DateInterval can be passed 	as paramenter.


equal_year( $date );
-----
	Returns wether $this->get_year() and provided Date year are equals. Both DateTime and Date-Wrapper can be passed as 	parameter.
 

equal_month( $date );
-----
	Returns wether $this->get_month() and provided Date month are equals. Both DateTime and Date-Wrapper can be passed 		as parameter. 
 

equal_day( $date );
-----
	Returns wether $this->get_day() and provided Date day are equals. Both DateTime and Date-Wrapper can be passed as 		parameter. 
 
equal_hour( $date );
-----
	Returns wether $this->get_hour and provided Date hour are equals. Both DateTime and Date-Wrapper can be passed as 		parameter.


equal_minute( $date );
-----
	Returns wether $this->get_minute and provided Date minute are equals. Both DateTime and Date-Wrapper can be passed 		as parameter.



equal_second( $date );
-----
	Returns wether $this->get_second and provided Date second are equals. Both DateTime and Date-Wrapper can be passed 		as parameter.


equal_timestamp( $date );
-----
	Returns wether $this->get_timestamp and provided Date timestamp are equals. Both DateTime and Date-Wrapper can be 		passed as parameter.


equal( $date , $granularity='d');
-----
	Returns wether $this is equal to $date until certain $granularity. Both DateTime and Date-Wrapper can be passed as 		parameter.

iterate($date , $do);
-----
	Performs a $do function iterating between $this and $date. 
	$do function has a ( $key , $date_time , $begin , $end ) signature, where $key is the DatePeriod used to iterate
	key, $dt is the DatePeriod DateTime in every iteration, $begin is the older of the two Date_Wrapper passed to 		iterate, and
	$end is  the future Date_Wrapper object.
	Only Date_Wrapper can be passed as $date.
	Method is not chainable.

