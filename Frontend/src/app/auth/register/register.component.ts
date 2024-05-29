import { CommonModule } from '@angular/common';
import { Component, OnDestroy } from '@angular/core';
import { FormsModule, NgForm } from '@angular/forms';
import { Router, RouterLink, RouterOutlet } from '@angular/router';
import { LocalStorageService } from '../../services/localstorage.service';
import { UserInfo } from '../../models/user-info';
import { UserService } from '../../services/user.service';
import { Token } from '../../models/token';
import { NgModule } from '@angular/core';

@Component({
  selector: 'app-register',
  standalone: true,
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'],
  imports: [CommonModule, FormsModule]
})
export class RegisterComponent implements OnDestroy {

  name: string = '';
  gender: string = '';
  email: string = '';
  password: string = '';
  confirm_password: string = '';
  mobile_number:string='';
  userType: string = 'user';
  registrationProcess: any="";
  passwordIcon: string = 'fas fa-eye-slash';
  passwordFieldType: string = 'password';
  errorInSubmitting: string = 'hide-error';
  errorMessage:string="Error While Register ";
  errorIcon:string="bi bi-check-circle";

  constructor(
    private localStorage: LocalStorageService,
    private userService: UserService,
    private router: Router
  ) {}

  togglePasswordVisibility() {
    if (this.passwordFieldType === 'password') {
      this.passwordFieldType = 'text';
      this.passwordIcon = 'fa-solid fa-eye';
    } else {
      this.passwordFieldType = 'password';
      this.passwordIcon = 'fas fa-eye-slash';
    }
  }

  register(registerForm: NgForm) {
    if (registerForm.valid && this.password === this.confirm_password) {
      if (this.userType === 'user') {
        this.registerUser();
      } else if (this.userType === 'admin') {
        this.registerAdmin();
      }
    } else {
      registerForm.form.markAllAsTouched();
    }
  }

  registerUser() {
    let registedUser: UserInfo = {
      name: `${this.name}`,
      email: this.email,
      password: this.password,
      gender: this.gender,
      mobile_number: this.mobile_number
    };

    this.registrationProcess = this.userService.userRegister(registedUser).subscribe({
      next: (response: any) => {
        this.errorInSubmitting = 'show-error text-success custom-alert';
        this.errorMessage="Registered Successfully";
        this.errorIcon="bi bi-check-circle mx-2";
        this.router.navigate(['/login']);
      },
      error: (error) => {
        this.errorInSubmitting = 'show-error text-danger custom-alert';
        this.errorMessage="Error While Registering";
        this.errorIcon="bi bi-dash-circle mx-2";
      }
    });
  }

  registerAdmin() {
    let registedAdmin: UserInfo = {
      name: `${this.name}`,
      email: this.email,
      password: this.password,
      gender: this.gender,
      mobile_number: this.mobile_number
    };

    this.registrationProcess = this.userService.adminRegister(registedAdmin).subscribe({
      next: (response: any) => {
        this.errorInSubmitting = 'show-error text-success custom-alert';
        this.errorMessage="Registered Successfully";
        this.errorIcon="bi bi-check-circle mx-2";
        this.router.navigate(['/login']);
      },
      error: (error) => {
        this.errorInSubmitting = 'show-error text-danger custom-alert';
        this.errorMessage="Error While Registering";
        this.errorIcon="bi bi-dash-circle mx-2";
      }
    });
  }

  setregisterToken(token: string) {
    this.localStorage.setValue("uEmail",this.email);
    this.localStorage.setValue("uPassword",this.confirm_password);
    this.localStorage.setValue('registerToken', token);
  }

  ngOnDestroy(): void {
    if (this.registrationProcess) {
      this.registrationProcess.unsubscribe();
    }
  }
}
