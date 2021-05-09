require('./bootstrap');

require('alpinejs');
require('./page-components/task-edit.js');
import SWITCH_TASK_STATUS from './page-components/task-status-actions.js';

window.SWITCH_TASK_STATUS = SWITCH_TASK_STATUS;
