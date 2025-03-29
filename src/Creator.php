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

    public function generateMessageFromString(string $message)
    {
        $generated_message = sprintf('build(deps): %s', $message);
        switch ($this->type) {
            case Type::NONE:
                $generated_message = $message;
                break;

            case Type::CONVENTIONAL:
            default:
                // The default is right up there, so the default is now set for the variable generated_message.
                break;
        }

        return $generated_message;
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

    public function generateMessageForGroup(string $group_name)
    {
        $message = sprintf('build(deps): Update dependency group %s', $group_name);
        switch ($this->type) {
            case Type::NONE:
                $message = sprintf('Update dependency group %s', $group_name);
                break;

            case Type::CONVENTIONAL:
            default:
                // The default was set initially.
                break;
        }

        return $message;
    }
}
