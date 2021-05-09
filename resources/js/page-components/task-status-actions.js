export default function (taskId) {
  const changeTaskStatus = function (status) {
    const url = `/task/${status}`;

    return axios({
      method: 'post',
      url: url,
      data: {
        id: taskId,
      }
    }).then(({data}) => {
      if (!data.success) throw new Error(data.message);
    })
  };

  return {
    stop($event) {
      $event.currentTarget.disabled = true;
      changeTaskStatus('stop').then(() => {
        this.$refs['start'].disabled = false;
        this.$refs['test'].disabled = false;
      }).catch((e) => {
        console.log(e);
      })
    },
    test($event) {
      $event.currentTarget.disabled = true;
      changeTaskStatus('test').then(() => {
        this.$refs['start'].disabled = false;
        this.$refs['stop'].disabled = false;
      }).catch((e) => {
        console.log(e);
      })
    },
    start($event) {
      $event.currentTarget.disabled = true;
      changeTaskStatus('start').then(() => {
        this.$refs['test'].disabled = false;
        this.$refs['stop'].disabled = false;
      }).catch((e) => {
        console.log(e);
      })
    },
  }
}
