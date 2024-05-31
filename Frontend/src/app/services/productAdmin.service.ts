import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Product } from '../models/product';
import { Observable,of } from 'rxjs';
import { map,tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ProductAdminService {
  private baseUrl = 'http://localhost:8000/api/admin/products/';


  constructor(private http: HttpClient) { }

  getAllProducts(): Observable<Product[]> {
    return this.http.get<any>(this.baseUrl).pipe(
      map(response => response.data as Product[])
    );
  }
  addProduct(prd: FormData) {
    return this.http.post<any>(this.baseUrl, prd);
  }

  getProductById(id: number): Observable<Product> {
    return this.http.get<any>(this.baseUrl + id).pipe(
      map(response => response.data as Product)
    )

  }
  deleteProduct(id: number): Observable<any> {
    return this.http.delete<any>(`${this.baseUrl}+${id}`);
  }

  updateProductStatus(productId: number, status: string): Observable<any> {
    return this.http.put(`${this.baseUrl}+${productId}`, { status });
  }
  update(id: number, formData: FormData): Observable<any> {
    const url = `${this.baseUrl}${id}?_method=PATCH`;
    return this.http.post<any>(url, formData);
    // http://localhost:8000/api/user/products/
    // return this.http.post<any>(this.baseUrl + prd.id +?_method=patch, prd);
  }

}
