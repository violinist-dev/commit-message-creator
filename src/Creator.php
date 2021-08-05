<?php

namespace Violinist\CommitMessageCreator;

use eiriksm\ViolinistMessages\UpdateListItem;
use Violinist\CommitMessageCreator\Constant\Type;

class Creator
{
    private $type = Type::CONVENTIONAL;

    public function setType($type)
    {
        if (!in_array($type, self::getValidTypes())) {
            throw new \InvalidArgumentException(sprintf('The type %s is not a valid commit message type', $type));
        }
        $this->type = $type;
    }

    public static function getValidTypes()
    {
        return [
            Type::NONE,
            Type::CONVENTIONAL,
        ];
    }

    public function generateMessage(UpdateListItem $item, $is_dev = false)
    {
        $message = sprintf('build(%s): Update %s from %s to %s', $is_dev ? 'deps-dev' : 'deps', $item->getPackageName(), $item->getOldVersion(), $item->getNewVersion());
        switch ($this->type) {
            case Type::NONE:
                $message = sprintf('Update %s', $item->getPackageName());
                break;

            case Type::CONVENTIONAL:
            default:
                // The default was set initially.
                break;
        }

        return $message;
    }
}
