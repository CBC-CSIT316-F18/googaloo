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

    /**
     * @return ElementBuilder
     */
    public function printTextContent(){
        print($this->textContent);
        return $this;
    }

    /********** Actions *************/

    /**
     * Builds the complete element with closing tag and text content
     * @return ElementBuilder
     */
    public function buildCompleteTagWithTextContent()
    {
        print("<$this->tagType ");
        $this->printAttributes();
        print(" >\r\n");
        $this->printTextContent();
        print("</$this->tagType>\r\n");
        return $this;
    }

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
        return $this;
    }

    /********** Printing *************/


    /**
     * Prints the attributes
     */
    private function printAttributes(){
        print(" ");
        foreach($this->attributes as $attribute){
            print("${attribute["name"]}='${attribute["value"]}'");
        }
    }

    /**
     * prints the textcontent.
     */
    private function printTextContentNoReturn(){
        print($this->textContent);
    }

}