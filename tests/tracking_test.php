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
namespace block_course_tracking;
/**
 * PHPUnit block_course_tracking tests
 *
 * @package    block_course_tracking
 * @category   test
 * @copyright  2022 Santosh N.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @coversDefaultClass \block_course_tracking
 */

class tracking_test extends \advanced_testcase {
    /**
     * Add the required files before class setup
     */
    public static function setUpBeforeClass(): void {
        require_once(__DIR__ . '/../../moodleblock.class.php');
        require_once(__DIR__ . '/../block_course_tracking.php');
    }

    /**
     * Test the behaviour of can_block_be_added() method.
     *
     * @covers ::can_block_be_added
     */
    public function test_can_block_be_added(): void {

        $this->resetAfterTest();
        $this->setAdminUser();

        // Create a course and prepare the page where the block will be added.
        $course = $this->getDataGenerator()->create_course();
        $page = new \moodle_page();
        $page->set_context(context_course::instance($course->id));
        $page->set_pagelayout('course');

        $block = new block_course_tracking();

        // If pagetype is course-view-topics, the method should return true.
        $page->set_pagetype('course-view-topics');
        $this->assertTrue($block->can_block_be_added($page));

        // However, if pagetype is not course-view-topics, the method should return false.
        $page->set_pagetype('mod-assign-view');
        $this->assertFalse($block->can_block_be_added($page));
    }

}
