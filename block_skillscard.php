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
 * Skills Card block
 *
 * @package    block_skillscard
 * @copyright  2022 Tengku Alauddin <din@pukunui.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_skillscard extends block_base {
    public function init() {
        $this->title = get_string('skillscard', 'block_skillscard');
    }

    public function instance_allow_multiple() {
      return true;
    }

    public function get_content() {
        global $USER, $DB;

        if ($this->content !== null) {
            return $this->content;
        }

        $id = optional_param('id', 0, PARAM_INT);

        // Load user.
        if ($id) {
            $user = $DB->get_record('user', array('id' => $id), '*', MUST_EXIST);
        } else {
            $user = $USER;
        }

        $this->content         =  new stdClass;
        $this->content->text   = '';
        $this->content->footer = '';
        
        //Get data
        $sql = 'SELECT COALESCE(c.scaleid, cf.scaleid, 0) AS scaleidx, c.shortname as compname, mc.grade as grade 
        FROM {competency_usercomp} mc
        JOIN {user} mu on mu.id = mc.userid
        JOIN {competency} c on c.id = mc.competencyid
        LEFT JOIN {competency_framework} cf on cf.id = c.competencyframeworkid
        WHERE mc.userid = :userid
        order by mc.userid';

        $skillscard = $DB->get_records_sql($sql, array('userid' => $user->id));
        if (empty($skillscard)){
            $this->content->text = get_string('noskillscard', 'block_skillscard');
            return $this->content;
        }

        //render data
        $li = '<ul style="list-style: none;">';
        foreach ($skillscard as $sc){
            $scales = ($values = $DB->get_field('scale', 'scale', ['id'=>($sc->scaleidx)])) ? explode(',', $values) : [];
            $grade = $scales[$sc->grade-1];
            $skill = format_text($sc->compname, FORMAT_PLAIN);
            $li .= '<li text-align : center><span><i class="fa fa-trophy fa-5x text-primary" 
            style="float:left; padding: 10px;"></i></span><br>'. get_string('rank', 'block_skillscard') . " " . 
            $grade . '<br>' . get_string('competency', 'block_skillscard') . ' ' . $skill . '</li>
            <div style="clear:both;"></div>';
        }

        $li .= '</ul>';

        $this->content->text .= $li;
        // $this->content->footer = html_writer::empty_tag('br');
        return $this->content;
    }
}