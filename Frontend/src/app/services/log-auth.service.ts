import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class LogAuthService {

  private isLoggedIn = false;

  constructor() {}

  signin() {
    this.isLoggedIn = true;
    localStorage.setItem('isLoggedIn', 'true');
  }

  logout() {
    this.isLoggedIn = false;
    // Clear the token or any authentication-related data
    localStorage.removeItem('isLoggedIn');
    localStorage.removeItem('name');
    localStorage.removeItem('token');
    localStorage.removeItem('id');
    localStorage.removeItem('role');
  }

  isAuthenticated(): boolean {
    console.log();
    return this.isLoggedIn || localStorage.getItem('isLoggedIn') === 'true';
  }
}
