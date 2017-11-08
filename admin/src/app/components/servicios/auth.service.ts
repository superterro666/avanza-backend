import { Injectable } from '@angular/core';
import { CanActivate } from '@angular/router';
import { LoginService } from './login.service';

@Injectable()
export class AuthService implements CanActivate {
  private status: boolean;
  constructor(private _login: LoginService) {

  }

  canActivate() {
    this._login.checktoken();
    this._login.isLogin$.subscribe(data => {
      if (data) {
        this.status = true;
      } else {
        this.status = false;
      }
    });
    return this.status;

  }

}
