import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpResponse } from '@angular/common/http';
import { Observable } from 'rxjs';
import { LoggedInUser } from '../models/logged-in-user';
import { Token } from '../models/token';
import { UserInfo } from '../models/user-info';

@Injectable({
  providedIn: 'root',
})
export class UserService {
  private userRegisterUrl = 'http://localhost:8000/api/user/register/';
  private adminRegisterUrl = 'http://localhost:8000/api/admin/register/';
  private userLoginUrl = 'http://localhost:8000/api/user/login/';
  private adminLoginUrl = 'http://localhost:8000/api/admin/login/';
  private logoutUrl = 'http://localhost:8000/api/logout/';

  constructor(private http: HttpClient) {}

  userLogin(user: LoggedInUser): Observable<HttpResponse<any>> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      Accept: 'application/json',
    });
    return this.http.post<any>(this.userLoginUrl, user, { headers, observe: 'response' });
  }

  adminLogin(user: LoggedInUser): Observable<HttpResponse<any>> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      Accept: 'application/json',
    });
    return this.http.post<any>(this.adminLoginUrl, user, { headers, observe: 'response' });
  }

  userRegister(user: UserInfo): Observable<HttpResponse<any>> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      Accept: 'application/json',
    });
    return this.http.post<any>(this.userRegisterUrl, user, { headers, observe: 'response' });
  }

  adminRegister(user: UserInfo): Observable<HttpResponse<any>> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      Accept: 'application/json',
    });
    return this.http.post<any>(this.adminRegisterUrl, user, { headers, observe: 'response' });
  }

  logout(token: string): Observable<HttpResponse<any>> {
    const headers = new HttpHeaders({
      Authorization: `Bearer ${token}`,
      'Content-Type': 'application/json',
      Accept: 'application/json',
    });
    return this.http.post<any>(this.logoutUrl, {}, { headers, observe: 'response' });
  }
}
