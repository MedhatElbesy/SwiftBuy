// src/app/cart.service.ts
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { Cart, ApiResponse } from '../models/cart';

@Injectable({
  providedIn: 'root'
})
export class CartService {
  private apiUrl = 'http://localhost:8000/api/user/carts';
  // private apiUrl = 'http://localhost:8000/api/carts';

  constructor(private http: HttpClient) { }

  addToCart(item: Cart): Observable<Cart> {
    return this.http.post<Cart>(this.apiUrl, item);
  }

  getCart(): Observable<Cart[]> {
    return this.http.get<ApiResponse>(this.apiUrl).pipe(
      map(response => response.data)
    );
  }

  // Add other cart-related methods if necessary
  updateCartItem(item: Cart): Observable<Cart> {
    const url = `${this.apiUrl}/${item.id}`;
    return this.http.put<Cart>(url, item);
  }
}
