import { Component, OnInit } from '@angular/core';
import { MensajesService } from '../servicios/mensajes.service';

@Component({
  selector: 'app-mensajes',
  templateUrl: './mensajes.component.html',
  styleUrls: ['./mensajes.component.css']
})
export class MensajesComponent implements OnInit {
  private mensajes: Array<any>;
  private mensaje: any;
  constructor(private _mensajes: MensajesService) {
   this._mensajes.getMensajes();
   }

  ngOnInit() {
      this._mensajes.listaMensaje$.subscribe(data => {
          this.mensajes = data;
      });
  }

  delete(id: number) {
    this._mensajes.delete(this.mensajes[id].id);
    this.mensajes.splice(id, 1);
  }

}
