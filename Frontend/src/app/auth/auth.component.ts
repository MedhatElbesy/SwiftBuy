import { Component } from '@angular/core';
import { LoginComponent } from "./login/login.component";
import { RegisterComponent } from "./register/register.component";

@Component({
  selector: 'app-auth',
  standalone: true,
  templateUrl: './auth.component.html',
  styleUrls: ['./auth.component.css'],
  imports: [
    LoginComponent,
    RegisterComponent
  ]
})
export class AuthComponent {}
