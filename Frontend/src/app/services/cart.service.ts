// src/app/cart.service.ts
import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { Cart, ApiResponse } from '../models/cart';
import { Order, OrderRequest } from '../models/order';

@Injectable({
  providedIn: 'root'
})
export class CartService {
  private apiUrl = 'http://localhost:8000/api/user/carts';
  private orderUrl = 'http://localhost:8000/api/orders';

  constructor(private http: HttpClient) { }
  private getHeaders() {
    const token = localStorage.getItem('token'); // Assuming the token is stored in localStorage
    return new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  }

  addToCart(item: Cart): Observable<Cart> {
    return this.http.post<Cart>(this.apiUrl, item);
  }

  getCart(): Observable<Cart[]> {
    return this.http.get<ApiResponse>(this.apiUrl, { headers: this.getHeaders() }).pipe(
      map(response => response.data)
    );
  }

  // Add other cart-related methods if necessary
  updateCartItem(item: Cart): Observable<Cart> {
    const url = `${this.apiUrl}/${item.id}`;
    return this.http.put<Cart>(url, item, { headers: this.getHeaders() });
  }

  deleteCartItem(itemId: number): Observable<void> {
    const url = `${this.apiUrl}/${itemId}`;
    return this.http.delete<void>(url, { headers: this.getHeaders() });
  }
  createOrder(orderRequest: OrderRequest): Observable<Order> {
    return this.http.post<Order>(this.orderUrl, orderRequest);
  }

}
