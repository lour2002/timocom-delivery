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
      const START = $event.target.parentElement.querySelector("[data-action=start]");
      const TEST = $event.target.parentElement.querySelector("[data-action=test]");
      $event.target.disabled = true;
      changeTaskStatus('stop').then(() => {
        START.disabled = false;
        TEST.disabled = false;
      }).catch((e) => {
        console.log(e);
      })
    },
    test($event) {
      const START = $event.target.parentElement.querySelector("[data-action=start]");
      const STOP = $event.target.parentElement.querySelector("[data-action=stop]");
      $event.target.disabled = true;
      changeTaskStatus('test').then(() => {
        STOP.disabled = false;
        START.disabled = false;
      }).catch((e) => {
        console.log(e);
      })
    },
    start($event) {
      const TEST = $event.target.parentElement.querySelector("[data-action=test]");
      const STOP = $event.target.parentElement.querySelector("[data-action=stop]");
      $event.target.disabled = true;
      changeTaskStatus('start').then(() => {
        STOP.disabled = false;
        TEST.disabled = false;
      }).catch((e) => {
        console.log(e);
      })
    },
  }
}
