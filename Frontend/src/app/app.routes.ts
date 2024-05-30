// app.routes.ts

import { Routes } from '@angular/router';
import { ProductsComponent } from './products/products.component';
import { AdminComponent } from './admin/admin.component';
import { ProductsComponent as ProductAdminComponent } from './admin/products/products.component';
import { AddProductComponent } from './admin/products/add-product/add-product.component';
import { ProfileComponentComponent } from './profile-component/profile-component.component';
import { ProductDetailsComponent } from './products/product-details/product-details.component';
import { EditProductComponent } from './admin/products/edit-product/edit-product.component';
import { LoginComponent } from './auth/login/login.component';
import { RegisterComponent } from './auth/register/register.component';
import { UserHomeComponent } from '../app/components/user-home/user-home.component';
import { AboutComponent } from './components/about/about.component';
import { ContactComponent } from './components/contact/contact.component';
import { AuthGuard } from './guard/auth.guard';
import { Error404Component } from './error/404/404.component';
import { DeleteProductComponent } from './admin/products/delete-product/delete-product.component';
import { CartComponent } from './cart/cart.component';

export const routes: Routes = [
  { path: '', component: UserHomeComponent },
  { path: 'about', component: AboutComponent },
  { path: 'contact', component: ContactComponent },
  { path: 'products', component: ProductsComponent, canActivate: [AuthGuard] },
  { path: 'products/:id', component: ProductDetailsComponent },
  { path: 'carts', component:CartComponent},
  {
    path: 'dashboard',
    component: AdminComponent,
    canActivate: [AuthGuard],
    children: [
      { path: 'products', component: ProductAdminComponent },
      { path: 'product/add', component: AddProductComponent },
      { path: 'product/edit/:id', component: EditProductComponent },
      { path: 'product/delete/:id', component: DeleteProductComponent },
    ],
  },
  { path: 'users', component: ProfileComponentComponent },
  { path: 'login', component: LoginComponent },
  { path: 'register', component: RegisterComponent },
  { path: '**', component: Error404Component },
];
