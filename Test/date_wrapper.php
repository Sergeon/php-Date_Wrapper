
<?php

require(__DIR__ . '/../date_wrapper.php');

class Date_Wrapper_Test extends \PHPUnit_Framework_TestCase{


    public function testBasicDateMethods(){

        $date_wrapper = Date_Wrapper::forge('2016-05-09');

        $this->assertEquals('2016' , $date_wrapper->get_year() );

        $this->assertEquals('05' , $date_wrapper->get_month() );

        $this->assertEquals('09' , $date_wrapper->get_day() );

        $this->assertEquals('9' , $date_wrapper->get_day_clean() );

        $this->assertEquals(1 , $date_wrapper->get_week_day() );

        $this->assertEquals('Mon' , $date_wrapper->get_week_day_str() );



        $a_date = new Date_Wrapper('2008:08:07 18:11:31');

        $this->assertEquals('06' , $a_date->get_hour() );
        $this->assertEquals('18' , $a_date->get_hour_strict() );

        $this->assertEquals('11' , $a_date->get_minute() );

        $this->assertEquals('31' , $a_date->get_second() );

    }


    public function testPastAndFutureMethods(){

        $past = new Date_Wrapper('1980-10-10');

        $this->assertTrue( $past->is_past() );
        $this->assertFalse( $past->is_future() );

        $future = Date_Wrapper::forge()->add_days(23);

        $this->assertTrue($future->is_future() );
        $this->assertFalse($future->is_past() );

        $now = new Date_Wrapper();

        $after = Date_Wrapper::forge()->add_seconds(8);

        $this->assertTrue($after->is_future(true));


    }


    public function testAddAndSubMethods(){


        $a_date = Date_Wrapper::forge('2012/12/20')->add_days(5);

        $this->assertEquals( 25 , $a_date->get_day());

        $a_date->add_days(10);

        $this->assertEquals( 4 , $a_date->get_day());

        $a_date->add_months(3);

        $this->assertEquals(4 , $a_date->get_month() );

        $a_date->sub_months(6);

        $this->assertEquals(10 , $a_date->get_month() );

        $a_date->add_years(16);

        $this->assertEquals(2028 , $a_date->get_year() );

        $a_date->sub_years(100);

        $this->assertEquals(1928 , $a_date->get_year() );

    }



    public function testIterate(){

        $date = Date_wrapper::forge('1920-10-10');

        $second = Date_wrapper::forge('1920-10-20');

        $i = 0;

        $result = array();

        $date->iterate( $second , $result , function( $k , $the_date , &$result ){
            $result[$k] = $the_date->format('Y/m/d');
        } );


        $this->assertEquals($result[3] , '1920/10/13' );


        $now = new Date_Wrapper();

        $after =  Date_Wrapper::forge()->add_days(30);

        $days = -9;

        $now->iterate($after , $days , function( $k , $the_date , &$days ){

            $days = $k;
        });

        $this->assertEquals('29' , $days );



    }

}


?>
