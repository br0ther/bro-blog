<?php
namespace Bro\BlogBundle\Service;

class SplitFile
{
    private $path;
    private $producer;

    public function __construct($path, $producer)
    {
        $this->path = $path;
        $this->producer = $producer;
    }

    public function process()
    {
        $xmlReader = new \XMLReader();
        $xmlReader->open($this->path);

        while ($xmlReader->read()) {
            if ((\XMLReader::ELEMENT === $xmlReader->nodeType) && ($xmlReader->name === 'item')) {
                $xml = '<?xml version="1.0"?>';
                $xml .= '<item>';
                $xml .= $xmlReader->readInnerXML();
                $xml .= '</item>';

                $this->producer->publish($xml);
            }
        }

        $xmlReader->close();
    }
}