import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { PortfolioService } from '../servicios/portfolio.service';
import { BlogService } from '../servicios/blog.service';

@Component({
  selector: 'app-show',
  templateUrl: './show.component.html',
  styleUrls: ['./show.component.css']
})
export class ShowComponent implements OnInit {
  private datos = {
    titulo: '',
    texto: '',
    imagen: '',
    id: 0
  };
  private id: number;
  private tipo: string;
  constructor(private route: ActivatedRoute, private router: Router, private _portfolio: PortfolioService, private _blog: BlogService) {
        this.route.params.subscribe(params => {
        this.id = params['id'];
        this.tipo = params['tipo'];

        if (this.tipo === 'portfolio') {
          this._portfolio.getPortfolio(this.id);
          this._portfolio.portfolio$.subscribe(data => {
          this.datos = data;
          });
        } else {
          this._blog.getBlog(this.id);
          this._blog.blog$.subscribe(data => {
          this.datos = data;
          });
        }
   });

  }

  ngOnInit() {
  }

}
