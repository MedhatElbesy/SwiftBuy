import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Product } from '../models/product';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ProductService {
  private baseUrl = 'http://localhost:8000/api/products/';

  constructor(private http: HttpClient) { }

  getAllProducts(): Observable<Product[]> {
    return this.http.get<any>(this.baseUrl).pipe(
      map(response => response.data as Product[])
    );
  }
  addProduct(prd:Product){
    return this.http.post<any>(this.baseUrl,prd);
  }

}
