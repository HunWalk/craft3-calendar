<?php

namespace Solspace\Calendar\Elements\Actions;

use craft\base\ElementAction;
use craft\elements\db\ElementQueryInterface;
use Solspace\Calendar\Calendar;
use Solspace\Calendar\Elements\Event;
use Solspace\Calendar\Library\CalendarPermissionHelper;

class DeleteEventAction extends ElementAction
{
    /** @var string */
    public $confirmationMessage;

    /** @var string */
    public $successMessage;

    /**
     * @inheritdoc
     */
    public function getTriggerLabel(): string
    {
        return Calendar::t('Delete…');
    }

    /**
     * @inheritdoc
     */
    public static function isDestructive(): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getConfirmationMessage()
    {
        return $this->confirmationMessage;
    }

    /**
     * Performs the action on any elements that match the given criteria.
     *
     * @param ElementQueryInterface $query
     *
     * @return bool
     */
    public function performAction(ElementQueryInterface $query): bool
    {
        /** @var Event $element */
        foreach ($query->all() as $element) {
            if (CalendarPermissionHelper::canEditCalendar($element->getCalendar())) {
                \Craft::$app->getElements()->deleteElement($element);
            }
        }

        $this->setMessage($this->successMessage);

        return true;
    }
}
