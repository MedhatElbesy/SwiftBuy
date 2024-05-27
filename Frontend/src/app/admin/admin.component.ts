import { Component } from '@angular/core';
import {ProductsComponent} from './products/products.component';
import { LayoutComponent } from './layout/layout.component';


@Component({
  selector: 'app-admin',
  standalone: true,
  imports: [ProductsComponent, LayoutComponent],
  templateUrl: './admin.component.html',
  styleUrl: './admin.component.css'
})
export class AdminComponent {

}
