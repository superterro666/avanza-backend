import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { Subject } from 'rxjs/Subject';
import { Router } from '@angular/router';
import { LoginService } from './login.service';

@Injectable()
export class MensajesService {
 private url = 'http://localhost/avanza/web/app_dev.php';

  private listaMensajeSource = new Subject<any>();
  public listaMensaje$ = this.listaMensajeSource.asObservable();
  private mensajeSource = new Subject<any>();
  public mensaje$ = this.mensajeSource.asObservable();
  private numMensajeSource = new Subject();
  public numMensaje= this.numMensajeSource.asObservable();
  constructor(private http: HttpClient, private _login: LoginService) { }

  setMensaje(datos) {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const data = JSON.stringify(datos);
    const params = 'json=' + data + '&token=' + this._login.getToken();
    this.http.post(this.url + '/set/mensaje', params, { headers: headers }).subscribe(data => {
      if (data['code'] === 200) {
        console.log(data);
        this.listaMensajeSource.next(data['mensajes']);
        return;
      }
      this.listaMensajeSource.next(false);
      return;
    }, error => {
      console.log(error);
    });
  }


  getMensajes() {
    this.http.get(this.url + '/views/mensaje' + '?token=' + this._login.getToken())
      .subscribe(data => {
        if (data['code'] === 200) {
          this.listaMensajeSource.next(data['mensajes']);
        } else {
          this.listaMensajeSource.next(false);
        }
      });
  }


  getMensaje(id: number) {
    this.http.get(this.url + '/view/mensaje' + '?id=' + id + '&token=' + this._login.getToken())
      .subscribe(data => {
        if (data['code'] === 200) {
          this.mensajeSource.next(data['mensaje']);
        } else {
          this.mensajeSource.next(false);
        }
      });
  }

  update(id: number) {
    this.http.get(this.url + '/update/mensaje' + '?id=' + id + '&token=' + this._login.getToken())
    .subscribe(data => {
      if (data['code'] === 200) {
     }
    });
  }

  delete(id: number) {
    this.http.get(this.url + '/delete/mensaje' + '?id=' + id + '&token=' + this._login.getToken())
    .subscribe(data => {
      if (data['code'] === 200) {
     }
    });
  }


}
