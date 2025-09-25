<?php
/** 
 * @package     VikBooking
 * @subpackage  core
 * @author      E4J s.r.l.
 * @copyright   Copyright (C) 2025 E4J s.r.l. All Rights Reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @link        https://vikwp.com
 */

// No direct access
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Task status implementation for type "pending".
 * 
 * @since   1.18.0 (J) - 1.8.0 (WP)
 */
class VBOTaskStatusTypePending extends VBOTaskStatusAware
{
    use VBOTaskStatusHelperAssigner;
    use VBOTaskStatusHelperChatter;

    /**
     * @inheritDoc
     */
    public function getEnum()
    {
        return 'pending';
    }

    /**
     * @inheritDoc
     */
    public function getGroupEnum()
    {
        return 'scheduled';
    }

    /**
     * @inheritDoc
     */
    public function getColor()
    {
        return 'orange';
    }

    /**
     * @inheritDoc
     */
    public function getOrdering()
    {
        return 2;
    }

    /**
     * @inheritDoc
     */
    public function apply(int $taskId)
    {
        $unassigned = $this->unassignUser(VBOTaskTaskregistry::getRecordInstance((int) $taskId));

        if ($unassigned) {
            // the user is no longer assigned, notify the administrator
            $this->sendMessage($taskId, JText::_('VBO_TASK_STATUS_UNASSIGNED_MESSAGE'));
        }
    }

    /**
     * @inheritDoc
     */
    public function display(VBOTaskTaskregistry $task)
    {
        return $this->displayAssignable($task);
    }
}
