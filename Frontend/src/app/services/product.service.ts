import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Product } from '../models/product';
import { Observable,of } from 'rxjs';
import { map,tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ProductService {
  private baseUrl = 'http://localhost:8000/api/user/products/';
  // private cache: { [key: string]: Product[] } = {};
  // private productCache: { [id: number]: Product } = {};

  constructor(private http: HttpClient) { }
  private getHeaders() {
    const token = localStorage.getItem('token'); // Assuming the token is stored in localStorage
    return new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  }

  // getAllProducts(): Observable<Product[]> {zz
  //   if (this.cache['allProducts']) {
  //     return of(this.cache['allProducts']);
  //   }
  //   return this.http.get<any>(this.baseUrl).pipe(
  //     map(response => response.data as Product[]),
  //     tap(data => this.cache['allProducts'] = data)
  //   );
  // }
  getAllProducts(): Observable<Product[]> {
    const headers = this.getHeaders();
    return this.http.get<any>(this.baseUrl, { headers }).pipe(
      map(response => response.data as Product[])
    );
  }

  addProduct(prd: Product) {
    return this.http.post<any>(this.baseUrl, prd);
  }

  getProductById(id: number): Observable<Product> {
    return this.http.get<any>(this.baseUrl + id).pipe(
      map(response => response.data as Product)
    )
  }
  update(prd: Product) {
    const url = `${this.baseUrl}${prd.id}?_method=PATCH`;
    return this.http.post<any>(url, prd);
    // http://localhost:8000/api/user/products/
    // return this.http.post<any>(this.baseUrl + prd.id +?_method=patch, prd);
  }
  // update(formData: FormData, id: number): Observable<any> {
  //   return this.http.put<any>(this.baseUrl + id, formData);
  // }





  // getProductById(id: number): Observable<Product> {
  //   if (this.productCache[id]) {
  //     return of(this.productCache[id]);
  //   }
  //   return this.http.get<any>(`${this.baseUrl}${id}`).pipe(
  //     map(response => response.data as Product),
  //     tap(product => this.productCache[id] = product)
  //   );
  // }
}
