<?php

namespace Violinist\CommitMessageCreator;

use eiriksm\ViolinistMessages\UpdateListItem;

class Creator
{
    private $type = 'conventional';

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
            'none',
            'conventional',
        ];
    }

    public function generateMessage(UpdateListItem $item, $is_dev = false)
    {
        $message = sprintf('build(%s): Update %s from %s to %s', $is_dev ? 'deps-dev' : 'deps', $item->getPackageName(), $item->getOldVersion(), $item->getNewVersion());
        switch ($this->type) {
            case 'none':
                $message = sprintf('Update %s', $item->getPackageName());
                break;

            case 'conventional':
            default:
                // The default was set initially.
                break;
        }

        return $message;
    }
}
