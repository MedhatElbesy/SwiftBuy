
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Order } from '../models/order';


@Injectable({
  providedIn: 'root'
})
export class OrderService {
  public orders : Order[]=[];
  private baseUrl = 'http://127.0.0.1:8000/api';

  constructor(private http: HttpClient) { }

  getOrders() {
    return this.http.get<any>(`${this.baseUrl}/orders`);
  }


  getOrderByName(title: string): Observable<Order> {
    return this.http.get<Order>(`${this.baseUrl}/orders/title/${title}`);
  }

  cancel(id :number){
    return this.http.get(`${this.baseUrl}/orders/${id}/reject`);
  }
  done(id :number){
    return this.http.get(`${this.baseUrl}/orders/${id}/accept`);
  }
  createOrder(){
    return this.http.post(`${this.baseUrl}/orders`,{});
  }

}





