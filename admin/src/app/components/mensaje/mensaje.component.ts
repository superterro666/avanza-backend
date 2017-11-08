import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { MensajesService } from '../servicios/mensajes.service';
@Component({
  selector: 'app-mensaje',
  templateUrl: './mensaje.component.html',
  styleUrls: ['./mensaje.component.css']
})
export class MensajeComponent implements OnInit {
  private mensaje: any;
  private id: number;
  constructor(private route: ActivatedRoute, private router: Router, private _mensajes: MensajesService) {
        this.route.params.subscribe(params => {
        this.id = params['id'];
        this._mensajes.getMensaje(this.id);

        this._mensajes.mensaje$.subscribe(data => {
        this.mensaje = data;
        this.update();
        });
   });

  }

  ngOnInit() {
  }

  update(){
    this._mensajes.update(this.id);
  }

}
