<?php

namespace InfluxDB2Test;


use GuzzleHttp\Psr7\Response;

require_once('BasicTest.php');

class QueryApiTest extends BasicTest
{
    private const SUCCESS_DATA =
        "#datatype,string,long,dateTime:RFC3339,dateTime:RFC3339,dateTime:RFC3339,long,string,string,string,string\n"
        . "#group,false,false,false,false,false,false,false,false,false,true\n" . "#default,_result,,,,,,,,,\n"
        . ",result,table,_start,_stop,_time,_value,_field,_measurement,host,region\n"
        . ",,0,1970-01-01T00:00:10Z,1970-01-01T00:00:20Z,1970-01-01T00:00:10Z,10,free,mem,A,west\n"
        . ",,0,1970-01-01T00:00:10Z,1970-01-01T00:00:20Z,1970-01-01T00:00:10Z,20,free,mem,B,west\n"
        . ",,0,1970-01-01T00:00:20Z,1970-01-01T00:00:30Z,1970-01-01T00:00:20Z,11,free,mem,A,west\n"
        . ",,0,1970-01-01T00:00:20Z,1970-01-01T00:00:30Z,1970-01-01T00:00:20Z,22,free,mem,B,west";

    public function testQueryRaw()
    {
        $this->mockHandler->append(new Response(204, [], QueryApiTest::SUCCESS_DATA));

        $result = $this->queryApi->queryRaw(
            'from(bucket:"my-bucket") |> range(start: 1970-01-01T00:00:00.000000001Z) |> last()');

        $this->assertEquals(QueryApiTest::SUCCESS_DATA, $result);
    }
}