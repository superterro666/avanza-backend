import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map';
import { LoginService } from './login.service';

@Injectable()
export class UploadService {
  private url: string;
  private action: string;
  constructor(private _http: HttpClient, private _login: LoginService) {
    this.url =  'http://localhost/avanza-backend/web/app_dev.php/upload/';
   }

  makeFileRequest(id, files: Array<File>, name: string, action: string) {
    const url = this.url + action;
    const token = this._login.getToken();
    return new Promise(function(resolve, reject){
      const formData: any = new FormData();
      const xhr = new XMLHttpRequest();

      for (let i = 0; i < files.length; i++) {
        formData.append(name, files[i], files[i].name);
      }
      formData.append('token', token);
      formData.append('id', id);

      xhr.onreadystatechange = function(){
        if (xhr.readyState === 4) {

            if (xhr.status === 200 ) {
              console.log(xhr.response);
              resolve(JSON.parse(xhr.response));
            } else {
              reject(xhr.response);
            }
      }
    };
        xhr.open('POST', url, true);
        xhr.send(formData);
   });
}
}
