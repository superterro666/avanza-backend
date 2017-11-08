import { RouterModule, Routes } from '@angular/router';
import { BlogComponent } from './components/blog/blog.component';
import { PortfolioComponent } from './components/portfolio/portfolio.component';
import { ShowComponent } from './components/show/show.component';
import { AuthService } from './components/servicios/auth.service';
import { MensajesComponent } from './components/mensajes/mensajes.component';
import { MensajeComponent } from './components/mensaje/mensaje.component';


const APP_ROUTES: Routes = [
 { path: 'blog', component: BlogComponent, canActivate: [AuthService]},
 { path: 'portfolio', component: PortfolioComponent, canActivate: [AuthService]},
 { path: 'show/:id/:tipo' , component: ShowComponent, canActivate: [AuthService] },
 { path: 'mensajes' , component: MensajesComponent, canActivate: [AuthService] },
 { path: 'mensaje/:id' , component: MensajeComponent, canActivate: [AuthService] },
 { path: '**', pathMatch: 'full', redirectTo: '/' }
];
export const APP_ROUTING = RouterModule.forRoot(APP_ROUTES);
