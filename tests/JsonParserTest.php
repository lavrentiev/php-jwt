<?php
/**
 * Created by PhpStorm.
 * User: Milad Rahimi <info@miladrahimi.com>
 * Date: 5/20/2018 AD
 * Time: 00:34
 */

namespace MiladRahimi\Jwt\Tests;

use MiladRahimi\Jwt\Exceptions\InvalidJsonException;
use MiladRahimi\Jwt\Json\JsonParser;
use MiladRahimi\Jwt\Json\JsonParserInterface;

class JsonParserTest extends TestCase
{
    /**
     * @var JsonParserInterface
     */
    private $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = new JsonParser();
    }

    /**
     * @throws \MiladRahimi\Jwt\Exceptions\InvalidJsonException
     */
    public function test_encoding_and_decoding_it_should_get_done_successfully()
    {
        $array = [
            'string' => md5(mt_rand(1, 100)),
            'integer' => mt_rand(1, 100),
            'true' => true,
            'false' => false,
        ];

        $encoded = $this->service->encode($array);

        $decoded = $this->service->decode($encoded);

        $this->assertSame($array['string'], $decoded['string']);
        $this->assertSame($array['integer'], $decoded['integer']);
        $this->assertSame($array['true'], $decoded['true']);
        $this->assertSame($array['false'], $decoded['false']);
    }

    /**
     * @throws InvalidJsonException
     */
    public function test_decoding_it_should_throw_an_exception_when_json_is_invalid()
    {
        $this->expectException(InvalidJsonException::class);

        $this->service->decode('Invalid JSON');
    }

    /**
     * @throws InvalidJsonException
     */
    public function test_decoding_it_should_throw_an_exception_when_json_is_invalid_2()
    {
        $this->expectException(InvalidJsonException::class);

        $this->service->decode(json_encode('String...'));
    }
}