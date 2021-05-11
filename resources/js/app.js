require('./bootstrap');

require('alpinejs');
import { TASK_EDIT, initTaskEdit } from './page-components/task-edit.js';
import SWITCH_TASK_STATUS from './page-components/task-status-actions.js';

initTaskEdit();
window.SWITCH_TASK_STATUS = SWITCH_TASK_STATUS;
window.TASK_EDIT = TASK_EDIT;
