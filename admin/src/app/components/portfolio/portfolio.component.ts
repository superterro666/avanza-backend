import { Component, OnInit, Input } from '@angular/core';
import { NgForm } from '@angular/forms';
import { PortfolioService } from '../servicios/portfolio.service';
import { UploadService } from '../servicios/upload.service';

@Component({
  selector: 'app-portfolio',
  templateUrl: './portfolio.component.html',
  styleUrls: ['./portfolio.component.css']
})
export class PortfolioComponent implements OnInit {
  public filesToUpload: Array<File>;
  public texto: string;
  private portfolios: any = [];
  public portfolio = {
    id: 0,
    titulo: '',
    texto: '',
    imagen: ''
 };
  constructor(private _portfolio: PortfolioService, private _upload: UploadService) {
    this.getPortfolios();
   }

  ngOnInit() {
  }
 onSubmit(portfolioForm: NgForm) {
    if (portfolioForm.valid) {
       const portfolio = {
         titulo: portfolioForm.value.titulo,
         texto: portfolioForm.value.texto
      };

      this._portfolio.setPortfolio(portfolio);
      this.portfolio.id = 0;
      this.portfolio.titulo = '';
      this.portfolio.texto = '';
      this._portfolio.listaPortfolio$.subscribe(data => {
      this.portfolios = data;
      this._upload.makeFileRequest(this.portfolios[0]['id'], this.filesToUpload, 'imagen', 'portfolio')
      .then((result: any) => {
        this.portfolios[0]['imagen'] = result;
        }, error => {
         console.log(error);
       });
      });
    }
  }

  getPortfolios() {
    this._portfolio.getPortfolios();
    this._portfolio.listaPortfolio$.subscribe(data => {
    this.portfolios = data;
    });
  }

  getPortfolio(id: number) {
    this._portfolio.getPortfolio(id);
    this._portfolio.portfolio$.subscribe(data => {
    return data;
    });
  }

  update(id: number) {
    const datos = this.portfolios[id];
    this.portfolio.id = datos['id'];
    this.portfolio.titulo = datos['titulo'];
    this.portfolio.texto = datos['texto'];
 }

 updateData() {
   this._portfolio.updatePortfolio(this.portfolio);
   this.portfolio.id = 0;
   this.portfolio.titulo = '';
   this.portfolio.texto = '';
   this._portfolio.portfolio$.subscribe(data => {
   this.portfolios = data;
   });
 }


 deleteBlog(id: number): void {
   this._portfolio.deletePortfolio(this.portfolios[id]['id']);
   this.portfolio.id = 0;
   this.portfolio.titulo = '';
   this.portfolio.texto = '';
   this._portfolio.listaPortfolio$.subscribe(data => {
   this.portfolios = data;
   });

 }

 fileChangeEvent(fileinput: any) {
   this.filesToUpload = <Array<File>>fileinput.target.files;
   console.log(this.filesToUpload);
 }




}
