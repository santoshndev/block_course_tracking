<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Class collecting data for course tracking block.
 *
 * @package    block_course_tracking
 * @copyright  2022 Santosh N.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_course_tracking\output;
defined('MOODLE_INTERNAL') || die;

use completion_info;
use renderer_base;

class main implements \renderable, \templatable
{

    /**
     * Get Activities with completion status
     * @return array
    */
    public function block_course_tracking_get_activities(): array {
        global $COURSE, $USER;
        $completion = new completion_info($COURSE);
        $activities = $completion->get_activities();
        $results = array();
        foreach ($activities as $activity) {
            // Check if activity is visible to current user.
            if (!$activity->uservisible) {
                continue;
            }

            // Get the activity completion status.
            $activitycompletiondata = $completion->get_data($activity, true, $USER->id);

            $results[] = array(
                'cmid' => $activity->id,
                'activityname' => $activity->name,
                'timecreated' => userdate($activity->added, '%d-%b-%Y', 99, false),
                'link' => $activity->url->out(),
                'completionstate' => ($activitycompletiondata->completionstate == COMPLETION_COMPLETE_PASS ||
                    $activitycompletiondata->completionstate == COMPLETION_COMPLETE) ?
                    get_string('completed', 'block_course_tracking') : '',
            );
        }

        return $results;

    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param \renderer_base $output
     * @return array
     */
    public function export_for_template(renderer_base $output): array {
        return array(
            'activities' => $this->block_course_tracking_get_activities()
        );
    }
}