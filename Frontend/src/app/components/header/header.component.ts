import { Component } from '@angular/core';
import { Router, RouterModule } from '@angular/router';
// import { AuthService } from '../../services/auth.service';

import { NgIf } from '@angular/common';
import { LogAuthService } from '../../services/log-auth.service';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-header',
  standalone: true,
  imports: [RouterModule,NgIf],
  templateUrl: './header.component.html',
  styleUrl: './header.component.css'
})
export class HeaderComponent {
  constructor(public authService: LogAuthService, public role: AuthService, private router: Router) {}

  logout() {
    if (confirm('Do you really want to log out?')) {
      this.authService.logout();
      this.router.navigate(['/']);
    }
  }
}
