import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { Subject } from 'rxjs/Subject';
import { Router } from '@angular/router';
import { LoginService } from './login.service';

@Injectable()
export class BlogService {
  private url = 'http://localhost/avanza-backend/web/app_dev.php';

  private listaBlogSource = new Subject<any>();
  public listaBlog$ = this.listaBlogSource.asObservable();

  private blogSource = new Subject<any>();
  public blog$ = this.blogSource.asObservable();



  constructor(private http: HttpClient, private _login: LoginService) { }

  setBlog(datos) {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const data = JSON.stringify(datos);
    const params = 'json=' + data;
    this.http.post(this.url + '/set/blog', params, { headers: headers }).subscribe(data => {
      if (data['code'] === 200) {
        console.log(data);
        this.listaBlogSource.next(data['blogs']);
        return;
      }
      this.listaBlogSource.next(false);
      return;
    }, error => {
      console.log(error);
    });
  }


  getBlogs() {
    this.http.get(this.url + '/views/blog' + '?token=' + this._login.getToken())
      .subscribe(data => {
        if (data['code'] === 200) {
          this.listaBlogSource.next(data['blogs']);
        } else {
          this.listaBlogSource.next(false);
        }
      });
  }


  getBlog(id: number) {
    this.http.get(this.url + '/view/blog' + '?id=' + id + '&token=' + this._login.getToken())
      .subscribe(data => {
        if (data['code'] === 200) {
          this.blogSource.next(data['blog']);
        } else {
          this.blogSource.next(false);
        }
      });
  }

  updateBlog(datos: any) {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const data = JSON.stringify(datos);
    const params = 'json=' + data;
    this.http.put(this.url + '/update/blog', params, { headers: headers }).subscribe(data => {
      if (data['code'] === 200) {
        this.listaBlogSource.next(data['blogs']);
        return;
      }
      this.listaBlogSource.next(false);
      return;
    }, error => {
      console.log(error);
    });
  }

  deleteBlog(id: number) {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    headers.append('Content-Type', 'application/json');
    this.http.delete(
      this.url + '/delete/blog?id=' + id + '&token=' + this._login.getToken(),
      { headers: headers }
    ).subscribe(data => {
      if (data['code'] === 200) {
        this.listaBlogSource.next(data['blogs']);
        return;
      }
      this.listaBlogSource.next(false);
      return;
    }, error => {
      console.log(error);
    });
 }

}
