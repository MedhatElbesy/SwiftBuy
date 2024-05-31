// src/app/cart.service.ts
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
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
  deleteCartItem(itemId: number): Observable<void> {
    const url = `${this.apiUrl}/${itemId}`;
    return this.http.delete<void>(url);
  }
  createOrder(orderRequest: OrderRequest): Observable<Order> {
    return this.http.post<Order>(this.orderUrl, orderRequest);
  }

}
