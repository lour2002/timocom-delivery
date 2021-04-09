require('./bootstrap');

require('alpinejs');
require('./dtsel');

document.addEventListener("DOMContentLoaded", () => {
  if (document.getElementById("task_individual_days")) {
    const task_individual_days = new dtsel.DTS('#task_individual_days',  {
      direction: 'TOP',
      dateFormat: "dd.mm.yyyy",
      showTime: false,
      timeFormat: "HH:MM:SS"
    });
  }

  if (document.getElementById("task_period_start")) {
    const task_period_start = new dtsel.DTS('#task_period_start',  {
      direction: 'TOP',
      dateFormat: "dd.mm.yyyy",
      showTime: false,
      timeFormat: "HH:MM:SS"
    });
  }

  if (document.getElementById("task_period_stop")) {
    const task_period_stop = new dtsel.DTS('#task_period_stop',  {
      direction: 'TOP',
      dateFormat: "dd.mm.yyyy",
      showTime: false,
      timeFormat: "HH:MM:SS"
    });
  }
})

window.modal = function () {
  return {
    showModal: true,
    data: {},
    trigger: {
      ['@click'](url) {
        this.showModal = true;
      }
    },
  }
}
