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
 * course tracking block.
 *
 * @package   block_course_tracking
 * @copyright 2022 Santosh N.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

class block_course_tracking extends block_base {
    /**
     * Sets the title of the block
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_course_tracking');
    }

    /**
     * defines whether multiple instance of this block is allowed
     *
     * @return bool
     */
    public function instance_allow_multiple(): bool {
        return false;
    }

    /**
     * define where this block can be added
     *
     * @return array
     */
    public function applicable_formats(): array {
        return array(
                'course-view' => true,
                'site-index' => false,
                'mod' => false,
                'my' => false,
                'site' => false
        );
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        $renderable = new \block_course_tracking\output\main();
        $renderer = $this->page->get_renderer('block_course_tracking');

        $this->content->text = $renderer->render($renderable);

        return $this->content;
    }

}