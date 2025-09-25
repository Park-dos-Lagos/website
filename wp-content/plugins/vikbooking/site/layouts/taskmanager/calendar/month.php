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
 * Obtain vars from arguments received in the layout file.
 * 
 * @var string $tool         The operator tool identifier calling this layout file.
 * @var array  $operator     The operator record accessing the tool.
 * @var object $permissions  The operator-tool permissions registry.
 * @var string $tool_uri     The base URI for rendering this tool.
 * @var array  $data         The data for rendering the tasks of a given month within a calendar.
 * @var int    $no_tasks     True for just displaying the month with no tasks, can be undefined.
 */
extract($displayData);

if (!$operator || empty($operator['id'])) {
    throw new Exception('Missing operator details', 400);
}

// check no-loading flag
$no_loading = (bool) ($no_tasks ?? 0);

// access the task manager object
$taskManager = VBOFactory::getTaskManager();

// get the filters for rendering the calendar tasks
$filters = (array) ($data['filters'] ?? []);

// get the current operator permissions
$accept_tasks = (bool) ($permissions ? $permissions->get('accept_tasks', 0) : 0);

// determine the month to load
$fromYmd = $filters['calendar_month'] ?? date('Y-m-01');
$toYmd = date('Y-m-t', strtotime($fromYmd));
if (($filters['dates'] ?? null) && !($filters['calendar_month'] ?? null)) {
    // when no calendar month filter set, use the current dates filter
    list($fromDt, $toDt) = VBOTaskModelTask::getInstance()->getFilterDatesInterval((string) $filters['dates'], $local = true, $sql = false);
    if ($fromDt && $toDt) {
        $fromYmd = date('Y-m-01', strtotime($fromDt));
        $toYmd = date('Y-m-t', strtotime($toDt));
    }
}

// build the pool of month tasks
$monthTasks = [];

if (!$no_loading) {
    // save current filters in the user state
    JFactory::getApplication()->setUserState('vbo.tm.filters', $filters);

    // check from the permissions whether tasks can be accepted by the operator,
    // hence null assigness should be included - use a different filter otherwise
    $operatorTasksFilterName = $accept_tasks ? 'operator' : 'assignee';

    // build filter options for fetching the tasks
    $fetchOptions = array_merge($filters, [
        $operatorTasksFilterName => $operator['id'],
        'dates' => $fromYmd . ':' . $toYmd,
    ]);

    // load tasks according to filters, by always forcing/injecting the dates and the assignee/operator filter
    foreach (VBOTaskModelTask::getInstance()->filterItems($fetchOptions, 0, 0) as $taskRecord) {
        // wrap task record into a registry
        $task = VBOTaskTaskregistry::getInstance((array) $taskRecord);

        // get task due date in Y-m-d format
        $due_date_key = $task->getDueDate($local = true, $format = 'Y-m-d');

        if ($due_date_key) {
            // start a container for this date
            $monthTasks[$due_date_key] = $monthTasks[$due_date_key] ?? [];

            // push task registry for this day
            $monthTasks[$due_date_key][] = $task;
        }
    }
}

// obtain the current month information
$monthDate = getdate(strtotime($fromYmd));
$monthIter = $monthDate;

// get navigation dates
$todayYmd   = date('Y-m-d');
$monthBack  = date('Y-m-01', strtotime('-1 month', $monthDate[0]));
$monthNext  = date('Y-m-01', strtotime('+1 month', $monthDate[0]));
$monthToday = date('Y-m-01');

// build week-day indexes
$firstwday    = (int) VikBooking::getFirstWeekDay();
$days_indexes = [];
$wday_labels  = [
    JText::_('VBSUN'),
    JText::_('VBMON'),
    JText::_('VBTUE'),
    JText::_('VBWED'),
    JText::_('VBTHU'),
    JText::_('VBFRI'),
    JText::_('VBSAT'),
];

for ($d = 0; $d < 7; $d++) {
    $days_indexes[$d] = (6-($firstwday-$d)+1)%7;
}

?>

<div class="vbo-tm-calendar-wrap">
    <div class="vbo-tm-calendar-head">
        <div class="vbo-tm-calendar-info">
            <span class="vbo-tm-calendar-month-name"><?php echo VikBooking::sayMonth($monthDate['mon']); ?></span>
            <span class="vbo-tm-calendar-month-year"><?php echo $monthDate['year']; ?></span>
        </div>

        <div class="vbo-tm-calendar-nav">
            <div class="vbo-tm-calendar-nav-btns">
                <span class="vbo-tm-calendar-nav-btn vbo-tm-calendar-nav-back" data-month="<?php echo $monthBack; ?>"><?php VikBookingIcons::e('chevron-left'); ?></span>
                <span class="vbo-tm-calendar-nav-btn vbo-tm-calendar-nav-today" data-month="<?php echo $monthToday; ?>"><?php echo JText::_('VBTODAY'); ?></span>
                <span class="vbo-tm-calendar-nav-btn vbo-tm-calendar-nav-next" data-month="<?php echo $monthNext; ?>"><?php VikBookingIcons::e('chevron-right'); ?></span>
            </div>
        </div>
    </div>

    <div class="vbo-tm-calendar-month-container">

        <div class="vbo-tm-calendar-month-row vbo-tm-calendar-month-weekdays">
        <?php
        // display days of week
        for ($d = 0; $d < 7; $d++) {
            $d_ind = ($d + $firstwday) < 7 ? ($d + $firstwday) : ($d + $firstwday - 7);
            ?>
            <div class="vbo-tm-calendar-month-day vbo-tm-calendar-month-weekday">
                <span><?php echo $wday_labels[$d_ind]; ?></span>
            </div>
            <?php
        }
        ?>
        </div>

        <div class="vbo-tm-calendar-month-row">
        <?php
        // start month-day counter
        $d_count = 0;

        // display the initial empty week-days, if any
        for ($i = 0, $n = $days_indexes[$monthDate['wday']]; $i < $n; $i++, $d_count++) {
            ?>
            <div class="vbo-tm-calendar-month-day vbo-tm-calendar-month-day-empty"></div>
            <?php
        }

        // loop through all dates of the current month
        while ($monthIter['mon'] == $monthDate['mon']) {
            if ($d_count > 6) {
                // week is over, reset counter and start a new row
                $d_count = 0;
                echo '</div>' . "\n" . '<div class="vbo-tm-calendar-month-row">' . "\n";
            }

            // build date key
            $date_key = date('Y-m-d', $monthIter[0]);

            ?>
            <div class="vbo-tm-calendar-month-day<?php echo $date_key == $todayYmd ? ' vbo-tm-calendar-month-today' : ''; ?>" data-date="<?php echo $date_key; ?>">
                <span class="vbo-tm-calendar-mday"><?php echo $monthIter['mday']; ?></span>
            <?php
            if ($monthTasks[$date_key] ?? []) {
                ?>
                <div class="vbo-tm-calendar-month-day-tasks">
                <?php
                foreach ($monthTasks[$date_key] as $taskIndex => $task) {
                    // get task status
                    $statusColor = '';
                    $statusName = '';
                    if ($taskManager->statusTypeExists($task->getStatus())) {
                        $status = $taskManager->getStatusTypeInstance($task->getStatus());
                        $statusColor = $status->getColor();
                        $statusName = $status->getName();
                    }

                    // get task assignee details
                    $assignees = $task->getAssigneeDetails();
                    ?>
                    <div class="vbo-tm-calendar-month-day-task vbo-tm-color <?php echo $statusColor ?: 'gray'; ?> <?php echo $statusName ? 'vbo-tooltip vbo-tooltip-top' : ''; ?>" data-task-id="<?php echo $task->getID(); ?>" data-area-id="<?php echo $task->getAreaID(); ?>" data-tooltiptext="<?php echo JHtml::_('esc_attr', $statusName); ?>">
                        <div class="vbo-tm-calendar-month-day-task-wrap">
                            <div class="vbo-tm-calendar-task-title">
                                <?php echo $task->getTitle(); ?>

                                <?php if ($task->get('hasUnreadMessages', false)): ?>
                                    <span class="unread-message-dot">
                                        <?php VikBookingIcons::e('comment'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php
                        if ($assignees) {
                            ?>
                            <span class="vbo-tm-calendar-task-assignees">
                            <?php
                            foreach ($assignees as $operator) {
                                ?>
                                <span class="vbo-tm-calendar-task-assignee vbo-tm-task-assignee">
                                    <span class="vbo-tm-calendar-task-assignee-avatar vbo-tm-task-assignee-avatar" title="<?php echo JHtml::_('esc_attr', $operator['name']); ?>">
                                    <?php
                                    if (!empty($operator['img_uri'])) {
                                        ?>
                                        <img src="<?php echo $operator['img_uri']; ?>" alt="<?php echo JHtml::_('esc_attr', $operator['initials']); ?>" decoding="async" loading="lazy" />
                                        <?php
                                    } else {
                                        ?>
                                        <span><?php echo $operator['initials']; ?></span>
                                        <?php
                                    }
                                    ?>
                                    </span>
                                </span>
                                <?php
                            }
                            ?>
                            </span>
                            <?php
                        }
                        ?>
                        </div>
                    </div>
                    <?php
                    if ($taskIndex > 1 && $exceeding = (count($monthTasks[$date_key]) - ++$taskIndex)) {
                        // we display at most 3 tasks per day
                        ?>
                    <div class="vbo-tm-calendar-month-day-task vbo-tm-calendar-month-day-more" data-date="<?php echo $date_key; ?>">
                        <span><?php echo sprintf('+%d %s', $exceeding, strtolower($exceeding > 1 ? JText::_('VBO_TASKS') : JText::_('VBO_TASK'))); ?></span>
                    </div>
                        <?php

                        // break the execution of the tasks for this day
                        break;
                    }
                }
                ?>
                </div>
                <?php
            }
            ?>
            </div>
            <?php
            // increase month-day counter
            $d_count++;

            // go to next day
            $monthIter = getdate(mktime(0, 0, 0, $monthIter['mon'], $monthIter['mday'] + 1, $monthIter['year']));
        }

        // display the ending empty week-days, if any
        for ($i = $d_count; $i <= 6; $i++) {
            ?>
            <div class="vbo-tm-calendar-month-day vbo-tm-calendar-month-day-empty"></div>
            <?php
        }
        ?>
        </div>

    </div>
</div>

<script type="text/javascript">
    jQuery(function($) {

        /**
         * Register listeners for month navigation buttons.
         */
        document
            .querySelectorAll('.vbo-tm-calendar-nav-btn')
            .forEach((nav) => {
                // get the navigation month
                const month = nav.getAttribute('data-month');

                nav.addEventListener('click', () => {
                    VBOCore.emitEvent('vbo-tm-apply-filters', {
                        filters: {
                            calendar_month: month,
                        },
                    });
                });
            });

        /**
         * Register listeners for day calendar type.
         */
        document
            .querySelectorAll('.vbo-tm-calendar-month-day[data-date]')
            .forEach((day) => {
                // get the navigation month
                const ymd = day.getAttribute('data-date');

                day
                    .querySelector('.vbo-tm-calendar-mday')
                    .addEventListener('click', (event) => {
                        event.preventDefault();
                        event.stopPropagation();

                        VBOCore.emitEvent('vbo-tm-apply-filters', {
                            filters: {
                                calendar_type: 'day',
                                calendar_day: ymd,
                            },
                        });
                    });
            });

        /**
         * Register listeners for viewing an existing task.
         */
        document
            .querySelectorAll('.vbo-tm-calendar-month-day-task')
            .forEach((taskElement) => {
                if (taskElement.clickListener) {
                    // listener added already
                    return;
                }

                // get the clicked task and area IDs
                const taskId = taskElement.getAttribute('data-task-id');
                const areaId = taskElement.getAttribute('data-area-id');
                const date = taskElement.getAttribute('data-date');

                if ((!taskId || !areaId) && !date) {
                    // missing task details
                    return;
                }

                if (!taskId && !areaId && date) {
                    // see more day tasks
                    taskElement.addEventListener('click', (event) => {
                        event.preventDefault();
                        event.stopPropagation();

                        VBOCore.emitEvent('vbo-tm-apply-filters', {
                            filters: {
                                calendar_type: 'day',
                                calendar_day: date,
                            },
                        });
                    });

                    // abort
                    return;
                }

                taskElement.addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();

                    VBOCore.emitEvent('vbo-tm-apply-filters', {
                        filters: {
                            calendar_back_type: 'month',
                            calendar_month: '<?php echo $fromYmd; ?>',
                            calendar_type: 'taskdetails',
                            task_id: taskId,
                        },
                    });
                });

                // turn flag on for listener set
                taskElement.clickListener = true;
            });

    });
</script>
