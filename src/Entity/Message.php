<?php
namespace App\Entity;

use App\Form\Enums\MessageTypeEnum;
use Doctrine\ORM\Mapping as ORM;

class Message
{
    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    //...

    /**
     * @param string $type
     * @return Message
     */

    public function getType(){
        return $this->type;
    }
    public function setType($type)
    {
        if (!in_array($type, MessageTypeEnum::getAvailableTypes())) {
            throw new \InvalidArgumentException("Invalid type");
        }

        $this->type = $type;

        return $this;
    }
}