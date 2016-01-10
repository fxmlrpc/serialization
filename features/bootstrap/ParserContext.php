<?php

use Behat\Gherkin\Node\PyStringNode;
use Fxmlrpc\Serialization\Parser;
use Fxmlrpc\Serialization\Value\Base64Value;
use Webmozart\Assert\Assert;

/**
 * Defines parser features.
 */
trait ParserContext
{
    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var string
     */
    protected $response;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var bool
     */
    protected $isFault;

    /**
     * @Given I have a response
     */
    public function iHaveAResponse(PyStringNode $response)
    {
        $this->response = (string) $response;
    }

    /**
     * @Given I have a response with a value :value
     */
    public function iHaveAResponseWithAValue($value)
    {
        $this->response = sprintf(
            '<?xml version="1.0" encoding="UTF-8"?>
                <methodResponse>
                <params>
                    <param>
                        <value>%s</value>
                    </param>
                </params>
                </methodResponse>',
            $value
        );
    }

    /**
     * @Given I have a response with a value :value of type :type
     */
    public function iHaveAResponseWithAValueOfType($value, $type)
    {
        $this->iHaveAResponseWithAValue(
            sprintf(
                '<%1$s>%2$s</%1$s>',
                $type,
                $value
            )
        );
    }

    /**
     * @Given I have a response with an empty tag of type :type
     */
    public function iHaveAResponseWithAnEmptyTagOfType($type)
    {
        $this->iHaveAResponseWithAValueOfType('', $type);
    }

    /**
     * @Given I have a response with an empty value of type :type
     */
    public function iHaveAResponseWithAnEmptyValueOfType($type)
    {
        $this->iHaveAResponseWithAValue(sprintf('<%s/>', $type));
    }

    /**
     * @When I parse the response
     */
    public function iParseTheResponse()
    {
        $this->value = $this->parser->parse($this->response, $this->isFault);
    }

    /**
     * @Then I should see a structure matching JSON
     */
    public function iShouldSeeAStructureMatchingJson(PyStringNode $json)
    {
        $struct = json_decode($json, true);

        Assert::eq($struct, $this->value);
    }

    /**
     * @Then I should see the value :value
     */
    public function iShouldSeeTheValueValue($value)
    {
        if (in_array($value, ['true', 'false'])) {
            $value = $value === 'true';
        }

        Assert::eq($value, $this->value);
    }

    /**
     * @Then I should see a datetime value :value
     */
    public function iShouldSeeADatetimeValue($value)
    {
        $value = \DateTime::createFromFormat('Y-m-d H:i:s', $value, new \DateTimeZone('UTC'));

        Assert::eq($value, $this->value);
    }

    /**
     * @Then I should see a base64 value :value
     */
    public function iShouldSeeABase64Value($value)
    {
        $value = Base64Value::serialize($value);

        Assert::eq($value->getEncoded(), $this->value->getEncoded());
        Assert::eq($value->getDecoded(), $this->value->getDecoded());
    }

    /**
     * @Then I should see an empty value
     */
    public function iShouldSeeAnEmptyValue()
    {
        Assert::isEmpty($this->value);
    }

    /**
     * @Then I should see a null value
     */
    public function iShouldSeeANullValue()
    {
        Assert::null($this->value);
    }

    /**
     * @Then there should be no fault
     */
    public function thereShouldBeNoFault()
    {
        Assert::false($this->isFault, 'This response should not be a fault');
    }

    /**
     * @Then there should be a fault
     */
    public function thereShouldBeAFault()
    {
        Assert::true($this->isFault, 'This response should be a fault');
    }
}
