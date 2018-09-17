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
 * @package    mod_forumqta
 * @copyright  2016 Cyberlearn HES-SO, Leyun Xia<leyun.xia@hevs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/moodleform_mod.php');

/**
 * Module instance settings form
 */
class mod_forumqta_mod_form extends moodleform_mod {

    /**
     * Defines forms elements
     */
    public function definition() {

        $mform = $this->_form;

        //-------------------------------------------------------------------------------
        // Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Adding the standard "name" field
        $mform->addElement('text', 'name', get_string('forumqtaname', 'forumqta'), array('size'=>'64'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEAN);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'forumqtaname', 'forumqta');

        // Adding the standard "intro" and "introformat" fields
        $this->standard_intro_elements() ;

        //-------------------------------------------------------------------------------
        // Adding the rest of forumqta settings, spreeading all them into this fieldset
        // or adding more fieldsets ('header' elements) if needed for better logic
        //$mform->addElement('static', 'label1', 'forumqtasetting1', 'Your forumqta fields go here. Replace me!');

        //$mform->addElement('header', 'forumqtafieldset', get_string('forumqtafieldset', 'forumqta'));
        //$mform->addElement('static', 'label2', 'forumqtasetting2', 'Your forumqta fields go here. Replace me!');

        /*$options = array(NOGROUPS => 'Public',
            SEPARATEGROUPS => 'Group A',
            VISIBLEGROUPS => 'Group B');
        $mform->addElement('select', 'groupmode', get_string('groupmode', 'group'), $options, NOGROUPS);*/

        /*$mform->addElement('header', 'forumqtafieldset', get_string('forumqtafieldset', 'forumqta'));
        $options2 = array(NOGROUPS => 'Public',
                SEPARATEGROUPS => 'Private');
        $mform->addElement('select', 'groupmode', get_string('groupmode', 'group'), $options2, NOGROUPS);*/

        //-------------------------------------------------------------------------------
        // add standard elements, common to all modules
        $this->standard_coursemodule_elements();
        //-------------------------------------------------------------------------------
        // add standard buttons, common to all modules
        $this->add_action_buttons();
    }

    /**
     * Add elements for setting the custom completion rules.
     *
     * @category completion
     * @return array List of added element names, or names of wrapping group elements.
     */
    public function add_completion_rules() {

        $mform = $this->_form;

        $group = [
            $mform->createElement('checkbox', 'completionpostsenabled', ' ', get_string('completionposts', 'forumqta')),
            $mform->createElement('text', 'completionposts', ' ', ['size' => 3]),
        ];
        $mform->setType('completionposts', PARAM_INT);
        $mform->addGroup($group, 'completionpostsgroup', get_string('completionpostsgroup','forumqta'), [' '], false);
        $mform->addHelpButton('completionpostsgroup', 'completionposts', 'forumqta');
        $mform->disabledIf('completionposts', 'completionpostsenabled', 'notchecked');

        return ['completionpostsgroup'];
    }

    /**
     * Called during validation to see whether some module-specific completion rules are selected.
     *
     * @param array $data Input data not yet validated.
     * @return bool True if one or more rules is enabled, false if none are.
     */
    public function completion_rule_enabled($data) {
        return (!empty($data['completionpostsenabled']) && $data['completionposts'] != 0);
    }

    function get_data() {
        $data = parent::get_data();
        if (!$data) {
            return $data;
        }
        if (!empty($data->completionunlocked)) {
            // Turn off completion settings if the checkboxes aren't ticked
            $autocompletion = !empty($data->completion) && $data->completion==COMPLETION_TRACKING_AUTOMATIC;
            if (empty($data->completionpostsenabled) || !$autocompletion) {
                $data->completionposts = 0;
            }
        }
        return $data;
    }

    function data_preprocessing(&$default_values){
        // [Existing code, not shown]

        // Set up the completion checkboxes which aren't part of standard data.
        // We also make the default value (if you turn on the checkbox) for those
        // numbers to be 1, this will not apply unless checkbox is ticked.
        $default_values['completionpostsenabled']=
            !empty($default_values['completionposts']) ? 1 : 0;
        if(empty($default_values['completionposts'])) {
            $default_values['completionposts']=1;
        }
    }
}
