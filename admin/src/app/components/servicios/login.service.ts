import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { Subject } from 'rxjs/Subject';
import { Router } from '@angular/router';


@Injectable()
export class LoginService {

  private url_base = 'http://localhost/avanza-backend/web/app_dev.php/login';
  private url_checktoken = 'http://localhost/avanza-backend/web/app_dev.php/checktoken';
  private token: string;
  private identity: any;

  private loginSource = new Subject<boolean>();
  public isLogin$ = this.loginSource.asObservable();

  private correoSource = new Subject<Number>();
  public correo$ = this.correoSource.asObservable();
  constructor(private http: HttpClient, private router: Router) { }

  login(user: string, password: string) {

    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const json = { user: user, password: password };
    const data = JSON.stringify(json);
    const params = 'json=' + data;
    this.http.post(this.url_base, params, { headers: headers }).subscribe( data => {

      if (data['code'] === 200) {
        this.setToken(data['token']);
        this.setIdentity(data['user']);
        this.correoSource.next(data['user'][0]);
        this.loginSource.next(true);
        } else {
        this.loginSource.next(false);
      }
    }, error => {
      console.log(error);
    });
  }

  checktoken() {
    this.http.get(this.url_checktoken + '?token=' + this.getToken()).subscribe(data => {
      if (data['code'] === 200) {
        this.correoSource.next(data['correo']);
        this.loginSource.next(true);
      } else {
        this.loginSource.next(false);
      }
    }, error => {
      console.log(error);
      return;
    });
  }


  isSession() {
    if (localStorage.getItem('token') && localStorage.getItem('identity')) {
      if (localStorage.getItem('identity') !== 'undefined' || localStorage.getItem('token') !== 'undefined') {
        const identity = JSON.parse(localStorage.getItem('identity'));
        const token = localStorage.getItem('token');
        this.checktoken();
        return;
      }
    } else {
      this.loginSource.next(false);
    }
  }

  logout() {
    if (localStorage.getItem('token') && localStorage.getItem('identity')) {
      localStorage.removeItem('token');
      localStorage.removeItem('identity');
      localStorage.removeItem('psw');
     }
     this.loginSource.next(false);
     this.router.navigate(['/home']);
  }

  setToken(value: string) {
    const token = JSON.stringify(value);
    localStorage.setItem('token', token);
    return;
  }

  setIdentity(value: string) {
    const identity = JSON.stringify(value);
    localStorage.setItem('identity', identity);
    return;
  }

  getToken() {
    const token = JSON.parse(localStorage.getItem('token'));
    if (token !== undefined) {
      this.token = token;
      return token;
    }
    return this.token = null;
  }

  getIdentity() {
    const identity = JSON.parse(localStorage.getItem('identity'));
    if (identity !== undefined) {
      this.identity = identity;
      return identity;
    }
    return this.identity = null;
  }


}
