import { Routes } from '@angular/router';
import { ProductsComponent } from './products/products.component';
import { AdminComponent } from './admin/admin.component';
import {ProductsComponent as ProductAdminComponent} from './admin/products/products.component'
import { AddProductComponent } from './admin/products/add-product/add-product.component';
import { ProfileComponentComponent } from './profile-component/profile-component.component';
import { ProductDetailsComponent } from './products/product-details/product-details.component';
import { EditProductComponent } from './admin/products/edit-product/edit-product.component';

import { LoginComponent } from './auth/login/login.component';
import { RegisterComponent } from './auth/register/register.component';

export const routes: Routes = [
  { path: "products", component: ProductsComponent },
  { path: "products/:id", component:ProductDetailsComponent},
  {
    path: "dashboard",
    component: AdminComponent,
    children: [
      { path: "products", component: ProductAdminComponent },
      { path: "product/add", component: AddProductComponent },
      {path:"product/edit/:id",component:EditProductComponent}
    ]
  },
  {path: "users", component:ProfileComponentComponent},
  { path: 'login', component: LoginComponent },
  { path: 'register', component: RegisterComponent },
];
