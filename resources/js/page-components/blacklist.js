export default {
  data: () => ({
    email: '',
    ttl: 112800,
    input: null,
    blacklist: [],
  }),
  mounted() {
    this.input = this.$refs.newEmail
  },
  methods: {
    addEmailToBlackList() {
      const input = this.input;
      if(input instanceof HTMLInputElement) {
        if (!input.validity.valid) {
          input.reportValidity();
          return;
        }

        axios({
          method: 'post',
          url: '/blacklist/store',
          data: {
            email: this.email,
            ttl: this.ttl
          }
        })
          .then(({data}) => {
            if (data.success) {
              this.email = '';
              this.ttl = 112800;
              this.blacklist.push(data.item);
            } else {
              alert('Can\'t add email to Black list' )
            }
          })
      }
    },
    removeEmailFromBlackList($event, id) {
      const rowElement = $event.target.parentElement.closest("tr");

      axios({
        method: 'post',
        url: '/blacklist/delete',
        data: {
          id: id
        }
      })
        .then(({data}) => {
          if (data.success) {
            const index = this.blacklist.findIndex(item => item.id === id)
            if (-1 !== index) {
              this.blacklist.splice(index, 1);
            } else {
              rowElement.remove();
            }
          } else {
            alert('Can\'t delete email from Black list' )
          }
        })
    }
  }
}
