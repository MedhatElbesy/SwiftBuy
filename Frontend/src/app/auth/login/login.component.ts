import { Component, OnDestroy } from '@angular/core';
import { Router } from '@angular/router';
import { NgForm } from '@angular/forms';
import { Subscription } from 'rxjs';
import { UserService } from '../../services/user.service';
import { LocalStorageService } from '../../services/localstorage.service';
import { LoggedInUser } from '../../models/logged-in-user';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterModule], // Ensure RouterModule is included
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
})
export class LoginComponent implements OnDestroy {
  user_mail: string = '';
  password: string = '';
  userType: string = 'user'; // Default to user
  passwordIcon: string = 'fas fa-eye-slash';
  passwordFieldType: string = 'password';
  errorInSubmitting = 'hide-error';
  private loginProcess: Subscription | null = null;

  constructor(
    private localStorage: LocalStorageService,
    private router: Router,
    private userService: UserService
  ) {}

  togglePasswordVisibility() {
    if (this.passwordFieldType === 'password') {
      this.passwordFieldType = 'text';
      this.passwordIcon = 'fa-solid fa-eye'; // Updated icon class for Bootstrap Icons
    } else {
      this.passwordFieldType = 'password';
      this.passwordIcon = 'fas fa-eye-slash'; // Reverting back to FontAwesome icon
    }
  }

  login(signInForm: NgForm) {
    if (signInForm.valid) {
      this.submitLogin();
    } else {
      signInForm.form.markAllAsTouched();
    }
  }

  submitLogin() {
    try {
      const loggedInUserData: LoggedInUser = {
        email: this.user_mail,
        password: this.password,
        device_name: 'mobile',
      };

      // Clear storage before login
      localStorage.clear();

      if (this.userType === 'user') {
        this.loginProcess = this.userService
          .userLogin(loggedInUserData)
          .subscribe({
            next: (response) => {
              this.localStorage.setValue('token', response.body.data.token);
              this.localStorage.setValue('name', response.body.data.name);
              this.localStorage.setValue('id', response.body.data.id);
              this.router.navigate(['/products']);
            },
            error: (error) => {
              console.log(error);
              this.errorInSubmitting = 'show-error text-danger';
            },
          });
      } else if (this.userType === 'admin') {
        this.loginProcess = this.userService
          .adminLogin(loggedInUserData)
          .subscribe({
            next: (response) => {
              this.localStorage.setValue('token', response.body.data.token); // Use response.body?.token
              this.localStorage.setValue('id', response.body.data.id);
              this.localStorage.setValue('name', response.body.data.name);
              this.router.navigate(['/products']);
            },
            error: (error) => {
              console.log(error);
              this.errorInSubmitting = 'show-error text-danger';
            },
          });
      }
    } catch (error) {
      this.errorInSubmitting = 'show-error text-danger';
    }
  }

  ngOnDestroy() {
    if (this.loginProcess) {
      this.loginProcess.unsubscribe();
    }
  }
}
