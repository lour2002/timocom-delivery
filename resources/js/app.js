require('./bootstrap');

require('alpinejs');

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
