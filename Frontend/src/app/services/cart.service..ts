import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class CartService {
  private apiUrl = 'http://127.0.0.1:8000/api/carts';

  constructor(private http: HttpClient) {}

  addToCart(product: any): Observable<any> {
    return this.http.post(this.apiUrl, product);
  }
}
