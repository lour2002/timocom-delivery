require('./bootstrap');

require('alpinejs');
require('./dtsel');
// import Quill from 'quill';

document.addEventListener("DOMContentLoaded", () => {
  // if (document.getElementById('email_template')) {
  //   var Size = Quill.import('attributors/style/size');
  //   Size.whitelist = ['10px', '12px', '14px', '18px', '22px'];
  //   Quill.register(Size, true);
  //
  //   var Parchment = Quill.import('parchment');
  //   var Delta = Quill.import('delta');
  //   let Break = Quill.import('blots/break');
  //   let Embed = Quill.import('blots/embed');
  //   let Block = Quill.import('blots/block');
  //   function lineBreakMatcher() {
  //     var newDelta = new Delta();
  //     newDelta.insert({'break': ''});
  //     return newDelta;
  //   }
  //   var toolbarOptions = [
  //     [{'header': 1}, {'header': 2}, {'header': 3}],
  //     [{'size': ['10px', '12px', '14px', '18px', '22px']}],
  //     ['bold', 'italic', 'underline', {'align': []}],
  //     [{'color': []}, {'background': []}],
  //     [{'list': 'ordered'}, {'list': 'bullet'}, 'blockquote'],
  //     ['link'],
  //     ['clean']
  //   ];
  //   var options = {
  //     theme: 'snow',
  //     modules: {
  //       toolbar: toolbarOptions,
  //       clipboard: {
  //         matchers: [
  //           ['BR', lineBreakMatcher]
  //         ]
  //       },
  //       keyboard: {
  //         bindings: {
  //           handleEnter: {
  //             key: 13,
  //             handler: function (range, context) {
  //               if (range.length > 0) {
  //                 this.quill.scroll.deleteAt(range.index, range.length);  // So we do not trigger text-change
  //               }
  //               let lineFormats = Object.keys(context.format).reduce(function (lineFormats, format) {
  //                 if (Parchment.query(format, Parchment.Scope.BLOCK) && !Array.isArray(context.format[format])) {
  //                   lineFormats[format] = context.format[format];
  //                 }
  //                 return lineFormats;
  //               }, {});
  //               var previousChar = this.quill.getText(range.index - 1, 1);
  //               // Earlier scroll.deleteAt might have messed up our selection,
  //               // so insertText's built in selection preservation is not reliable
  //               this.quill.insertText(range.index, '\n', lineFormats, Quill.sources.USER);
  //               if (previousChar == '' || previousChar == '\n') {
  //                 this.quill.setSelection(range.index + 2, Quill.sources.SILENT);
  //               } else {
  //                 this.quill.setSelection(range.index + 1, Quill.sources.SILENT);
  //               }
  //               this.quill.selection.scrollIntoView();
  //               Object.keys(context.format).forEach((name) => {
  //                 if (lineFormats[name] != null)
  //                   return;
  //                 if (Array.isArray(context.format[name]))
  //                   return;
  //                 if (name === 'link')
  //                   return;
  //                 this.quill.format(name, context.format[name], Quill.sources.USER);
  //               });
  //             }
  //           },
  //           linebreak: {
  //             key: 13,
  //             shiftKey: true,
  //             handler: function (range, context) {
  //               var nextChar = this.quill.getText(range.index + 1, 1)
  //               var ee = this.quill.insertEmbed(range.index, 'break', true, 'user');
  //               if (nextChar.length == 0) {
  //                 // second line break inserts only at the end of parent element
  //                 var ee = this.quill.insertEmbed(range.index, 'break', true, 'user');
  //               }
  //               this.quill.setSelection(range.index + 1, Quill.sources.SILENT);
  //             }
  //           }
  //         }
  //       }
  //     }
  //   };
  //
  //   Break.prototype.insertInto = function (parent, ref) {
  //     Embed.prototype.insertInto.call(this, parent, ref)
  //   };
  //   Break.prototype.length = function () {
  //     return 1;
  //   }
  //   Break.prototype.value = function () {
  //     return '\n';
  //   }
  //
  //   const quill = new Quill('#email_template_new', options);
  //
  //   document.querySelectorAll('.add_data').forEach((item)=>{
  //     item.addEventListener('click', function (event) {
  //       const add_data = event.target.dataset.insert;
  //       //console.log(add_data);
  //       quill.focus();
  //       const symbol = add_data;
  //       const caretPosition = quill.getSelection(true);
  //       quill.insertText(caretPosition, symbol);
  //     })
  //   });
  // }
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

window.settingsFormEdit = function () {
  return {
    showModal: true,
    data: {
      tagsValue: '',
    },
    trigger: {
      ['@click'](url) {
        this.showModal = true;
      }
    },
  }
}
