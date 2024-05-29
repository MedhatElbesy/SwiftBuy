import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Product } from '../models/product';
import { Observable,of } from 'rxjs';
import { map,tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ProductService {
  private baseUrl = 'http://localhost:8000/api/products/';
  // private cache: { [key: string]: Product[] } = {};
  // private productCache: { [id: number]: Product } = {};

  constructor(private http: HttpClient) { }

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
    return this.http.get<any>(this.baseUrl).pipe(
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
    return this.http.put<any>(this.baseUrl + prd.id, prd);
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
