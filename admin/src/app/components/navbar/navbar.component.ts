import { Component, OnInit } from '@angular/core';
import { LoginService } from '../servicios/login.service';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {
  private user: string;
  private password: string;
  private logueado: boolean;
  private mensajes: Number;
  constructor(private _login: LoginService) {
    this._login.isSession();
   }

  ngOnInit() {
    this._login.isLogin$.subscribe(data => {
      this.logueado = data;
   });
   this._login.correo$.subscribe(data => {
   this.mensajes = data;
  });
 }

  login() {
    if (this.user.length > 1 && this.password.length > 4) {
          this._login.login(this.user, this.password);
          this._login.isLogin$.subscribe(data => {
            this.logueado = data;
            this._login.correo$.subscribe(data => {
              console.log(data)
              this.mensajes = data;
            });
         });
    }
  }

  logout() {
    this._login.logout();
  }

}
