<?php
/**
 * Created by PhpStorm.
 * User: TyckoFranklin
 * Date: 9/27/2018
 * Time: 9:17 PM
 */
namespace src\util\html\ElementBuilder;
class ElementBuilder
{
    /********** Variables  *************/
    /** @var string */
    private $tagType = "";
    /** @var array */
    private $attributes = [];
    /** @var string */
    private $textContent = "";

    /********** Variables  *************/
    /**
     * ElementBuilder constructor.
     * Is private do to how we want people to use it.
     * @param string $tagType
     */
    public function __construct($tagType)
    {
        $this->tagType = $tagType;
    }

    /********** Fluent interfaces  *************/
    /**
     * Builder pattern starter.
     * @param string $tagType
     * @return ElementBuilder
     */
    public static function create($tagType)
    {
        return new self($tagType);
    }

    /**
     * Adds an attribute
     * @param string $name
     * @param string $value
     * @return ElementBuilder
     */
    public function withAttribute($name, $value)
    {
        array_push($this->attributes,[
            "name" => $name,
            "value" => $value
        ]);
        return $this;
    }

    /**
     * Adds an attribute
     * @param array $namesValues
     * @return ElementBuilder
     */
    public function withAttributes($namesValues)
    {
        array_merge ($this->attributes, $namesValues);
        return $this;
    }

    /**
     * Adds an attribute
     * @param string $textContent
     * @return ElementBuilder
     */
    public function withTextContent($textContent)
    {
        $this->textContent = $textContent;
        return $this;
    }

    /********** Actions *************/


    /**
     * Builds the complete element with closing tag
     * @return ElementBuilder
     */
    public function buildSelfClosingTag()
    {
        print("<$this->tagType");
        $this->printAttributes();
        print(" />\r\n");
        return $this;
    }

    /**
     * Builds the complete element with closing tag
     * @return ElementBuilder
     */
    public function buildLeaveTagOpen()
    {
        print("<$this->tagType ");
        $this->printAttributes();
        print(" >\r\n");
        return $this;
    }


    /**
     * Builds the complete element with closing tag
     * @return ElementBuilder
     */
    public function buildCloseOpenTag()
    {
        print("</$this->tagType>\r\n");
        return self;
    }

    /********** Printing *************/


    private function printAttributes(){
        print(" ");
        foreach($this->attributes as $attribute){
            print("${attribute["name"]}='${attribute["value"]}'");
        }
    }

    private function printTextContent(){
        print($this->textContent);
    }

}