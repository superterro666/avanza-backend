import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { Subject } from 'rxjs/Subject';
import { Router } from '@angular/router';
import { LoginService } from './login.service';

@Injectable()
export class PortfolioService {
  private url = 'http://localhost/avanza-backend/web/app_dev.php';
  private listaPortfolioSource = new Subject<any>();
  public listaPortfolio$ = this.listaPortfolioSource.asObservable();
  private portfolioSource = new Subject<any>();
  public portfolio$ = this.portfolioSource.asObservable();
  constructor(private http: HttpClient, private _login: LoginService) { }

  setPortfolio(datos) {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const data = JSON.stringify(datos);
    const params = 'json=' + data + '&token=' + this._login.getToken();
    this.http.post(this.url + '/set/portfolio', params, { headers: headers }).subscribe(data => {
      if (data['code'] === 200) {
        console.log(data);
        this.listaPortfolioSource.next(data['portfolios']);
        return;
      }
      this.listaPortfolioSource.next(false);
      return;
    }, error => {
      console.log(error);
    });
  }


  getPortfolios() {
    this.http.get(this.url + '/views/portfolio' + '?token=' + this._login.getToken())
      .subscribe(data => {
        if (data['code'] === 200) {
          this.listaPortfolioSource.next(data['portfolios']);
        } else {
          this.listaPortfolioSource.next(false);
        }
      });
  }


  getPortfolio(id: number) {
    this.http.get(this.url + '/view/portfolio' + '?id=' + id + '&token=' + this._login.getToken())
      .subscribe(data => {
        console.log(data)
        if (data['code'] === 200) {
          this.portfolioSource.next(data['portfolio']);
        } else {
          this.portfolioSource.next(false);
        }
      });
  }

  updatePortfolio(datos: any) {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const data = JSON.stringify(datos);
    const params = 'json=' + data;
    this.http.put(this.url + '/update/portfolio', params, { headers: headers }).subscribe(data => {
      if (data['code'] === 200) {
        this.listaPortfolioSource.next(data['portfolios']);
        return;
      }
      this.listaPortfolioSource.next(false);
      return;
    }, error => {
      console.log(error);
    });
  }

  deletePortfolio(id: number) {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    headers.append('Content-Type', 'application/json');
    this.http.delete(
      this.url + '/delete/portfolio?id=' + id + '&token=' + this._login.getToken(),
      { headers: headers }
    ).subscribe(data => {
      if (data['code'] === 200) {
        this.listaPortfolioSource.next(data['portfolios']);
        return;
      }
      this.listaPortfolioSource.next(false);
      return;
    }, error => {
      console.log(error);
    });
  }

}
