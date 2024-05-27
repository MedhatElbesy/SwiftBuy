import { Routes } from '@angular/router';
import { ProductsComponent } from './products/products.component';
import { AdminComponent } from './admin/admin.component';
import {ProductsComponent as ProductAdminComponent} from './admin/products/products.component'
import { AddProductComponent } from './admin/products/add-product/add-product.component';

export const routes: Routes = [
  {path:"products",component:ProductsComponent},
  {
    path: "dashboard",
    component: AdminComponent,
    children: [
      { path: "products", component: ProductAdminComponent },
      {path:"product/add",component:AddProductComponent}
    ]
  },

];

