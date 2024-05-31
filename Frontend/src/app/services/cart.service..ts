import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { map, Observable } from 'rxjs';
import { ApiResponse, Cart } from '../models/cart';

@Injectable({
  providedIn: 'root',
})
export class CartService {
  private apiUrl = 'http://127.0.0.1:8000/api/user/carts';

  constructor(private http: HttpClient) { }
  private getHeaders() {
    const token = localStorage.getItem('token'); // Assuming the token is stored in localStorage
    return new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  }

  addToCart(product: any): Observable<any> {
    return this.http.post(this.apiUrl, product,{ headers: this.getHeaders() });
    //return this.http.post(this.apiUrl, product);
  }




  delete(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/${id}`);
  }

  // getCartItems(userId: number): Observable<any> {
  //   return this.http.get(`${this.apiUrl}?user_id=${userId}`);
  // }
  getCart(): Observable<Cart[]> {
    return this.http.get<ApiResponse>(this.apiUrl, { headers: this.getHeaders() }).pipe(
      map(response => response.data)
    );
  }
  isProductInCart(productId: number): Observable<boolean> {
    return this.getCart().pipe(
      map(cartItems => cartItems.some(item => item.product_id === productId))
    );
  }
}
