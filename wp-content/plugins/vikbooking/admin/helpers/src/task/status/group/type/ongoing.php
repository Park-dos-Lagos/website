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
 * Task status group implementation for type "ongoing".
 * 
 * @since   1.18.0 (J) - 1.8.0 (WP)
 */
final class VBOTaskStatusGroupTypeOngoing implements VBOTaskStatusGroupInterface
{
    /**
     * @inheritDoc
     */
    public function getEnum()
    {
        return 'ongoing';
    }

    /**
     * @inheritDoc
     */
    public function getOrdering()
    {
        return 5;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return JText::_('VBO_TASK_STATUS_GROUP_TYPE_ONGOING');
    }
}
