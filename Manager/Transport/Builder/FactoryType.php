<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport\Builder;

use Gos\Bundle\MailerBundle\Manager\Transport\Builder\Type\FromType;
use Gos\Bundle\MailerBundle\Manager\Transport\Builder\Type\SubjectType;
use Gos\Bundle\MailerBundle\Manager\Transport\Builder\Type\ToType;

class FactoryType
{
    protected $builderOptions;

    public function __construct(array $builderOptions)
    {
        $this->builderOptions = $builderOptions;
    }

    /**
     * @param string $type
     */
    public function createType($type, array $options = [])
    {
        switch ($type) {
            case 'from' :
                $type = new FromType();
                break;
            case 'to' :
                $type = new ToType();
                break;
            case 'subject' :
                $type = new SubjectType();
                break;
            default:
                throw new \Exception('Undefined type');
        }

        $type->setOptions($options);

        return $type;
    }
}
