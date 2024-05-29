import { Component, OnInit, OnDestroy } from '@angular/core';
import { Router, RouterLink, RouterOutlet } from '@angular/router';
import { FormsModule, NgForm } from '@angular/forms';
import { LocalStorageService } from '../../services/localstorage.service';
import { CommonModule } from '@angular/common';
import { UserService } from '../../services/user.service';
import { Token } from '../../models/token';
import { LoggedInUser } from '../../models/logged-in-user';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [RouterLink, RouterOutlet, CommonModule, FormsModule],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'] // Updated from styleUrl to styleUrls
})
export class LoginComponent implements OnDestroy {
  user_mail: string = "";
  password: string = "";
  passwordIcon: string = 'fas fa-eye-slash';
  passwordFieldType: string = 'password';
  errorInSubmitting = "hide-error";
  errorMessage = "";
  errorIcon = "bi bi-circle";
  private loginProcess: Subscription | null = null; // Add a subscription variable

  constructor(private localStorage: LocalStorageService, private router: Router, private userService: UserService) { }

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

        // Generate object
        let loggedInUserData: LoggedInUser = {
          email: this.user_mail,
          password: this.password,
          device_name: "mobile"
        };

        this.loginProcess = this.userService.login(loggedInUserData).subscribe({
          next: (response) => {
            console.log(response)
            this.localStorage.setValue("loginToken", response.access_token);
            this.localStorage.setValue("uEmail", this.user_mail);

            this.localStorage.removeValue("registerToken");
            this.router.navigate(['/home']);
          },
          error: (error) => {
            console.log(error);
            this.errorInSubmitting = 'show-error text-danger';
          }
        });
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
