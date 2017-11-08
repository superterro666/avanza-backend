import { Component, OnInit, Input } from '@angular/core';
import { SimpleTinyComponent } from './simple-tiny.component';
import { NgForm } from '@angular/forms';
import { BlogService } from '../servicios/blog.service';
import { UploadService } from '../servicios/upload.service';


@Component({
  selector: 'app-blog',
  templateUrl: './blog.component.html',
  styleUrls: ['./blog.component.css'],
  providers: [ SimpleTinyComponent ]
})

export class BlogComponent implements OnInit {
  public filesToUpload: Array<File>;
  public texto: any;
  private blogs: any = [];
  public blog = {
    id: 0,
    titulo: '',
    texto: '',
    imagen: ''
 };
  constructor(private _blog: BlogService, private _tiny: SimpleTinyComponent, private _upload: UploadService) {
    this.getBlogs();
   }

  ngOnInit() {
  }

  keyupHandlerFunction($event) {
    console.log($event);
    this.texto = $event;
  }

  onSubmit(blogForm: NgForm) {
    if (blogForm.valid) {
       const blog = {
         titulo: blogForm.value.titulo,
         texto: this.texto
      };

      console.log(blog);
      this._blog.setBlog(blog);
      this.blog.id = 0;
      this.blog.titulo = '';
      this._tiny.update('');

      this._blog.listaBlog$.subscribe(data => {
      this.blogs = data;
      this._upload.makeFileRequest(this.blogs[0]['id'], this.filesToUpload, 'imagen', 'blog')
      .then((result: any) => {
        this.blogs[0]['imagen'] = result;
        }, error => {
         console.log(error);
       });
      });
    }
  }

  getBlogs() {
    this._blog.getBlogs();
    this._blog.listaBlog$.subscribe(data => {
    this.blogs = data;
    });
  }

  getBlog(id: number) {
    this._blog.getBlog(id);
    this._blog.blog$.subscribe(data => {
    return data;
    });
  }

  update(id: number) {
    const datos = this.blogs[id];
    this.blog.id = datos['id'];
    this.blog.titulo = datos['titulo'];
    this.blog.texto = datos['texto'];
    this._tiny.update(datos['texto']);
 }

 updateData() {
   this._blog.updateBlog(this.blog);
   this.blog.id = 0;
   this.blog.titulo = '';
   this._tiny.update('');
   this._blog.blog$.subscribe(data => {
   this.blogs = data;
   });
 }


 deleteBlog(id: number): void {
   this._blog.deleteBlog(this.blogs[id]['id']);
   this.blog.id = 0;
   this.blog.titulo = '';
   this._tiny.update('');
   this._blog.listaBlog$.subscribe(data => {
   this.blogs = data;
   });

 }

 fileChangeEvent(fileinput: any) {
  this.filesToUpload = <Array<File>>fileinput.target.files;
  console.log(this.filesToUpload);
}

}
