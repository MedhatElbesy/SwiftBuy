import { CommonModule } from '@angular/common';
import { Component, OnDestroy } from '@angular/core';
import { FormsModule, NgForm } from '@angular/forms';
import { LocalStorageService } from '../../services/localstorage.service';
import { UserInfo } from '../../models/user-info';
import { UserService } from '../../services/user.service';
import { Token } from '../../models/token';

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnDestroy{

  first_name: string = '';
  last_name: string = '';
  gender: string = '';
  email: string = '';
  password: string = '';
  confirm_password: string = '';
  mobile_number:string='';
  registrationProcess:any="";
  passwordIcon: string = 'fas fa-eye-slash';
  passwordFieldType: string = 'password';
  errorInSubmitting: string = 'hide-error';
  errorMessage:string="Error While Register ";
  errorIcon:string="bi bi-check-circle";
  private userData: UserInfo=new UserInfo;
  constructor(
    private localStorage: LocalStorageService,
    private userService: UserService
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
      this.submitRegister();
    } else {
      registerForm.form.markAllAsTouched();
    }
  }

  setregisterToken(token: string) {
    this.localStorage.setValue("uEmail",this.email);
    this.localStorage.setValue("uPassword",this.confirm_password);
    this.localStorage.setValue('registerToken', token);
  }

  submitRegister() {
    try {
      // Create user info object
      let registedUser: UserInfo = {
        name: `${this.first_name} ${this.last_name}`,
        email: this.email,
        password: this.password,
        gender: this.gender,
        mobile_number: this.mobile_number
      };

     this.registrationProcess = this.userService.register(registedUser).subscribe({
        next: (response: any) => {
          this.errorInSubmitting = 'show-error text-success custom-alert';
          this.errorMessage="Registed Successfully"
          this.errorIcon="bi bi-dash-circle mx-2"
        },
        error: (error) => {
          this.errorInSubmitting = 'show-error text-danger custom-alert';
          this.errorMessage="Error While Registering"
          this.errorIcon="bi bi-dash-circle mx-2";
        }

      });
    } catch (error) {
          this.errorInSubmitting = 'show-error text-danger custom-alert';
          this.errorMessage="Error While Registering"

    }
  }
  ngOnDestroy(): void {
     if (this.registrationProcess) {
      this.registrationProcess.unsubscribe();
    }
  }
}
