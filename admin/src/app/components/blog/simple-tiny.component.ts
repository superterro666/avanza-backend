import {
    Component,
    OnDestroy,
    AfterViewInit,
    EventEmitter,
    Input,
    Output
  } from '@angular/core';
  @Component({
    // tslint:disable-next-line:component-selector
    selector: 'simple-tiny',
    template: `<textarea id="{{elementId}}"></textarea>`
  })
  export class SimpleTinyComponent implements AfterViewInit, OnDestroy {
    @Input() elementId: String;
    @Output() onEditorKeyup = new EventEmitter<any>();
    editor;
    ngAfterViewInit() {
      tinymce.init({
        selector: '#' + this.elementId,
        plugins: ['link', 'paste', 'table', 'image'],
        skin_url: 'assets/lightgray',
        setup: editor => {
          this.editor = editor;
          editor.on('keyup', () => {
            const content = editor.getContent();
            this.onEditorKeyup.emit(content);
          });
        },
      });
    }
   ngOnDestroy() {
      tinymce.remove(this.editor);
    }


    update(datos) {
      tinymce.get('blogId').setContent(datos);
    }
}