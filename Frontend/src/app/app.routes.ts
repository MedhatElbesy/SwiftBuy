import { Routes } from '@angular/router';
import { ProductsComponent } from './products/products.component';
import { AdminComponent } from './admin/admin.component';
import {ProductsComponent as ProductAdminComponent} from './admin/products/products.component'

export const routes: Routes = [
  {path:"products",component:ProductsComponent},
  {
    path: "dashboard",
    component: AdminComponent,
    children: [
      { path: "products", component: ProductAdminComponent }
    ]
  }
];

