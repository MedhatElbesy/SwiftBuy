import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { User } from '../models/users';

@Injectable({
  providedIn: 'root'
})
export class ProfileService {
  private baseURL = "http://localhost:8000/api/users/";

  constructor(private http: HttpClient) { }

  getAll(): Observable<User[]> {
    return this.http.get<{ status: string, msg: string, data: User[] }>(this.baseURL).pipe(
      map(response => response.data)
    );
  }

  getById(id: number): Observable<User> {
    return this.http.get<{ status: string, msg: string, data: User }>(this.baseURL + id).pipe(
      map(response => response.data)
    );
  }
}
