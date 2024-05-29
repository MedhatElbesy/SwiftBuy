import { Routes } from '@angular/router';
import { UserHomeComponent } from '../app/components/user-home/user-home.component';
import { AboutComponent } from './components/about/about.component';
import { ContactComponent } from './components/contact/contact.component';


export const routes: Routes = [
    { path: '', component: UserHomeComponent },
    { path: 'about', component: AboutComponent },
    { path: 'contact', component: ContactComponent },
];
