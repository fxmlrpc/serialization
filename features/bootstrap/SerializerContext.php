<?php

use Behat\Gherkin\Node\PyStringNode;
use Fxmlrpc\Serialization\Serializer;
use Fxmlrpc\Serialization\Value\Base64Value;
use Webmozart\Assert\Assert;

/**
 * Defines serializer features.
 */
trait SerializerContext
{
    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var string
     */
    protected $request;

    /**
     * @Given I have a call :method
     */
    public function iHaveACall($method)
    {
        $this->method = $method;
    }

    /**
     * @Given I have a parameter :param
     */
    public function iHaveAParameter($param)
    {
        $this->params[] = $param;
    }

    /**
     * @Given I have parameters
     */
    public function iHaveParameters(PyStringNode $json)
    {
        $this->params = json_decode($json, true);
    }

    /**
     * @Given I have an object parameter
     */
    public function iHaveAnObjectParameter(PyStringNode $json)
    {
        $this->iHaveAParameter((object) json_decode($json, true));
    }

    /**
     * @Given I have a class parameter
     */
    public function iHaveAClassParameter()
    {
        $this->iHaveAParameter(new SerializationTestStub());
    }

    /**
     * @Given I have a resource parameter
     */
    public function iHaveAResourceParameter()
    {
        $this->iHaveAParameter(stream_context_create());
    }

    /**
     * @Given I have a parameter :param of type :type
     */
    public function iHaveAParameterOfType($param, $type)
    {
        if ('bool' === $type) {
            $param = $param === 'true';
        } else {
            $param = call_user_func($type.'val', $param);
        }

        $this->iHaveAParameter($param);
    }

    /**
     * @Given I have a datetime parameter :param
     */
    public function iHaveADatetimeParameter($param)
    {
        $param = \DateTime::createFromFormat('Y-m-d H:i:s', $param, new \DateTimeZone('UTC'));

        $this->iHaveAParameter($param);
    }

    /**
     * @Given I have a base64 parameter :param
     */
    public function iHaveABaseParameter($param)
    {
        $this->iHaveAParameter(Base64Value::serialize($param));
    }

    /**
     * @When I serialize the call
     */
    public function iSerializeTheCall()
    {
        try {
            $this->request = $this->serializer->serialize($this->method, $this->params);
        } catch (\Exception $e) {
            $this->request = $e;
        }
    }

    /**
     * @Then I should see a request
     */
    public function iShouldSeeARequest(PyStringNode $request)
    {
        PHPUnit\Framework\Assert::assertXmlStringEqualsXmlString((string) $request, $this->request);
    }

    /**
     * @Then the request should start with XML declaration
     */
    public function theRequestShouldStartWithXmlDeclaration()
    {
        Assert::startsWith($this->request, '<?xml version="1.0" encoding="UTF-8"?>');
    }

    /**
     * @Then I should see an error
     */
    public function iShouldSeeAnError()
    {
        Assert::isInstanceOf($this->request, 'Fxmlrpc\Serialization\Exception\SerializerException');
    }

    /**
     * @Then I should see a request with the parameter :param of type :type
     */
    public function iShouldSeeARequestWithTheParameterOfType($param, $type)
    {
        $value = sprintf(
            '<param>
                <value>
                    <%1$s>%2$s</%1$s>
                </value>
            </param>',
            $type,
            $param
        );
        $value = str_repeat($value."\n", count($this->params));

        $request = sprintf(
            '<?xml version="1.0" encoding="UTF-8"?>
                <methodCall>
                    <methodName>method</methodName>
                    <params>
                        %s
                    </params>
                </methodCall>',
            $value
        );

        PHPUnit\Framework\Assert::assertXmlStringEqualsXmlString($request, $this->request);
    }
}

class SerializationTestStub
{
    public $publicProperty = 'PUBLIC';
    protected $protectedProperty = 'PROTECTED';
    private $privateProperty = 'PRIVATE';

    public static $publicStatic = 'PUBLIC STATIC';
    protected static $protectedStatic = 'PROTECTED STATIC';
    private static $privateStatic = 'PRIVATE STATIC';
}
